<?php

/**
 * arrivage actions.
 *
 * @package    MobileStockV3
 * @subpackage arrivage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class arrivageActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->initList($request);
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
    }

    public function executeListAjax(sfWebRequest $request) {
        $this->initList($request);

        return $this->renderPartial('list', array('arrivages' => $this->arrivages, 'users' => $this->users));
    }

    private function initList(sfWebRequest $request) {
        $this->heureDebut = $request->getParameter('heureDebut', date('d/m/Y') . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');
        $this->fournisseur = $request->getParameter('fournisseur', '');
        $this->transporteur = $request->getParameter('transporteur', '');
        $this->statut = $request->getParameter('statut', '');
        $this->produit = $request->getParameter('produit', '');
        $this->urgent = $request->getParameter('urgent', '');


        $heureDebut = '';
        if ($this->heureDebut != '') {
            $heureDebut = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureDebut)->format('y-m-d H:i:s');
        }
        $heureFin = '';
        if ($this->heureFin != '') {
            $heureFin = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureFin)->format('y-m-d H:i:s');
        }
        $users = sfGuardUserTable::getInstance()->findAll();
        $this->users = array();
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user->getUsername();
        }
        $this->arrivages = WrkArrivageTable::getInstance()->getArrivages($heureDebut, $heureFin, $this->fournisseur, $this->transporteur, $this->statut, $this->produit, $this->urgent);
    }

    public function executeNew(sfWebRequest $request) {
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        $this->natures = RefNatureTable::getInstance()->findAll();
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $numArrivage = $this->build($request);

        return $this->renderText($numArrivage);
    }

    private function generateNumColis(WrkArrivage $arrivage, $standard, $congelee, $urgent, $print, $numArrivage = "") {
        $collectionArrivageProduit = $arrivage->getWrkArrivageProduit();

        $dateArrivage = "";
        if ($numArrivage != "") {
            $dateArrivage = DateTime::createFromFormat('ymdHis', $numArrivage)->format('Y-m-d H:i:s');
        }
        if ($numArrivage != "" && count($collectionArrivageProduit) > 0) {//si c'est une modification et qu'on a modifier le num arrivage
            foreach ($collectionArrivageProduit as $arrivageProduit) {
                $refProduit = $arrivageProduit->getRefProduit();
                $type = substr($refProduit, 0, 1);
                $increment = substr($refProduit, 13);
                $numArrivageRef = $type . $numArrivage . $increment;

                $arrivageProduit->setRefProduit($numArrivageRef);
                $arrivageProduit->setCreatedAt($dateArrivage);

                $receptionsAssocies = WrkArrivageProduitTable::getInstance()->getReceptions('', '', $refProduit, '');
                foreach ($receptionsAssocies as $receptionAssocie) {
                    $receptionAssocie->setRefProduit($numArrivageRef);
                }
                $receptionsAssocies->save();
                $arrivageProduit->save();
            }
        }

        $standardArray = array();
        $congeleeArray = array();
        $urgentArray = array();
        if ($standard > 0)
            $standardArray = array_fill(0, $standard, array('S', RefNature::NATURE_STANDARD));
        if ($congelee > 0)
            $congeleeArray = array_fill(0, $congelee, array('C', RefNature::NATURE_CONGELEE));
        if ($urgent > 0)
            $urgentArray = array_fill(0, $urgent, array('U', RefNature::NATURE_URGENT));
        $colis = array_merge($standardArray, $congeleeArray, $urgentArray);
        if (count($colis) > 0) {
            $increment = count($collectionArrivageProduit) + 1;
            if (count($collectionArrivageProduit) > 0) { //si c'est une modification
                $arrivageProduit = $collectionArrivageProduit->getFirst();
                $refProduit = $arrivageProduit->getRefProduit();
                $numArrivage = substr($refProduit, 1, 12);
            } else {
                if ($numArrivage == "") {
                    $numArrivage = date('ymdHis');
                    $dateArrivage = date('Y-m-d H:i:s');
                }
            }
            $date = date('Y-m-d H:i:s');
            $newColis = new Doctrine_Collection("WrkArrivageProduit");
            foreach ($colis as $value) {
                $refProduit = $value[0] . $numArrivage . $increment;
                $arrivageProd = new WrkArrivageProduit();
                $arrivageProd->setWrkArrivage($arrivage);
                $arrivageProd->setIdNature($value[1]);
                $arrivageProd->setRefProduit($refProduit);
                $arrivageProd->setCreatedAt($dateArrivage);

                $emplacement = null;
                if ($arrivage->getIdContactPFF()) {
                    if ($emp = RefEmplacementTable::getInstance()->findEmplacementArrivage()) {
                        $emplacement = $emp;
                        $empDestination = RefEmplacementTable::getInstance()->find($arrivage->getRefContactPFF()->getIdEmplacement());
                    }
                } else {
                    $emplacement = RefEmplacementTable::getInstance()->findEmplacementArrivageSansDestinataire();
                    $empDestination = null;
                }

                if ($print != null) {
                    if ($empDestination == null) {
                        $empl = "";
                    } else {
                        $empl = $empDestination->getCodeEmplacement();
                    }

                    $this->printCodeBarre($refProduit . ';' . $empl);
                }
                $collectionArrivageProduit->add($arrivageProd);
                $newColis->add($arrivageProd);
                $increment++;


                $this->createNewMouvement($refProduit, $date, $emplacement);
            }
            $this->createNewReception($newColis);
        }


        return $collectionArrivageProduit;
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));
        $this->arrivage = $arrivage;
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        $this->natures = RefNatureTable::getInstance()->findAll();
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
        $dateCreation = strtotime($arrivage->getCreatedAt());
        $date1 = strtotime("-1 day");

        $this->editUrgence = false;
    }

    public function executeEditUrgence(sfWebRequest $request) {
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));
        $this->arrivage = $arrivage;
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
        $dateCreation = strtotime($arrivage->getCreatedAt());
        $date1 = strtotime("-1 day");

        $this->editUrgence = false;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));

        $statut = 0;
        if ($this->build($request, $arrivage)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));
        $statut = 1;
        $con = Doctrine_Manager::getInstance()->connection();
        $colis = $arrivage->getWrkArrivageProduit();
        foreach ($colis as $col) {
            $produit = $col->getRefProduit();
            $requete = "DELETE FROM wrk_mouvement WHERE ref_produit LIKE '$produit'";
            $st = $con->execute($requete);
        }
        WrkArrivageProduitTable::getInstance()->getConnection()->beginTransaction();
        $arrivage->getWrkArrivageProduit()->delete();
        $arrivage->delete();
        WrkArrivageProduitTable::getInstance()->getConnection()->commit();
        return $this->renderText($statut);
    }

    public function build(sfWebRequest $request, WrkArrivage $arrivage = null) {
        $dateArrivage = $request->getParameter('dateArrivage', '');
        $idFournisseur = $request->getParameter('fournisseur');
        $idTransporteur = $request->getParameter('transporteur');
        $chauffeur = $request->getParameter('chauffeur');
        $lVoiture = $request->getParameter('lVoiture');
        $colis = $request->getParameter('colis', 0);
        $palette = $request->getParameter('palette', 0);
        $immatriculation = $request->getParameter('immatriculation');

        $urgence = $request->getParameter('urgent', null);

        $tracking_four = $request->getParameter('tracking_four');
        $commande_achat = $request->getParameter('commande_achat');

        $date_livraison_debut = $request->getParameter('date_livraison_debut', null);
        $date_livraison_fin = $request->getParameter('date_livraison_fin', null);
        $contact_pff = $request->getParameter('contact_pff', null);

//       $idNature = $request->getParameter('nature');
//       $brSap = $request->getParameter('brSap');
        $statut = $request->getParameter('statut');
        $commentaire = $request->getParameter('commentaire');

        $standard = intval($request->getParameter('umStandard', 0));
        $congelee = intval($request->getParameter('umCongelee', 0));
        $urgent = intval($request->getParameter('umUrgent', 0));
        $print = $request->getParameter('autoPrint', null);
        $printNumArrivage = $request->getParameter('printNumArrivage', null);
        $colis+=$standard + $congelee + $urgent;

        $isOk = $this->checkValue($idFournisseur, $idTransporteur, $chauffeur, $lVoiture, $colis, $palette, $immatriculation);

        if (!$isOk) {
            return false;
        }
        if ($arrivage == null) {
            $arrivage = new WrkArrivage();
            $arrivage->setCreatedAt(date('Y-m-d H:i:s'));
            $arrivage->setIdUser($this->getUser()->getGuardUser()->getId());
        }

        $numArrivage = '';
        if ($dateArrivage != "") { //si on a une date d'arrivage on creer un num arrivage
            $numArrivage = DateTime::createFromFormat('d/m/Y H:i:s', $dateArrivage)->format('ymdHis');
            $dateArrivage = DateTime::createFromFormat('d/m/Y H:i:s', $dateArrivage)->format('Y-m-d H:i:s');
            $arrivage->setCreatedAt($dateArrivage);
        }

        $arrivage->setIdFournisseur($idFournisseur);
        $arrivage->setIdTransporteur($idTransporteur);
        if ($chauffeur && $chauffeur != "") {
            $arrivage->setIdChauffeur($chauffeur);
        } else {
            $arrivage->setIdChauffeur(null);
        }
        $arrivage->setLettreVoiture($lVoiture);
        $arrivage->setNbColis($colis);
        $arrivage->setNbPalette($palette);
        $arrivage->setImmatriculation($immatriculation);

        $dateCreation = strtotime($arrivage->getCreatedAt());
        $date1 = strtotime("-1 day");



        $arrivage->setTrackingFour($tracking_four);
        $arrivage->setCommandeAchat($commande_achat);

        $arrivage->setStatut($statut);
        $arrivage->setCommentaire($commentaire);

        $interlocuteurInit = $arrivage->getIdInterlocuteur();
        $idContactPFFInit = $arrivage->getIdContactPFF();
        if ($urgence = $this->checkUrgence($tracking_four, $commande_achat, $idTransporteur, $idFournisseur)) {

            $arrivage->setUrgent(true);
            $arrivage->setIdInterlocuteur($urgence->getIdInterlocuteur());
            $arrivage->setDateLivraisonDebut($urgence->getDateLivraisonDebut());
            $arrivage->setDateLivraisonFin($urgence->getDateLivraisonFin());
        }

        if ($contact_pff && $contact_pff != "" && $contact_pff != -1) {
            $arrivage->setIdContactPFF($contact_pff);
        } else {
            $arrivage->setIdContactPFF(null);
        }

        try {
            WrkArrivageTable::getInstance()->getConnection()->beginTransaction();
            $collectionArrivageProduit = $this->generateNumColis($arrivage, $standard, $congelee, $urgent, $print, $numArrivage);
            $arrivage->save();
            $collectionArrivageProduit->save();
            WrkArrivageTable::getInstance()->getConnection()->commit();
            
            if ($urgence) {
                $urgence->setIdArrivage($arrivage->getIdArrivage());
                $urgence->save();
            }

            //Envoi mail ici
            if ($urgence && ($urgence->getIdInterlocuteur() && $interlocuteurInit != $arrivage->getIdInterlocuteur())) {
                WrkArrivageTable::getInstance()->envoiMail($arrivage);
            }
            //envoi mail non urgent
            if ($idContactPFFInit != $arrivage->getIdContactPFF() && $arrivage->getIdContactPFF()) {
                WrkArrivageTable::getInstance()->envoiMailContactPFF($arrivage);
            }

            if ($printNumArrivage != null) {
                $this->printNumArrivage($arrivage);
            }
        } catch (Exception $e) {
            return false;
        }

        if ($urgence) {
             $cmeAchat = $urgence->getCommandeAchat();
              $pos2 = strpos($commande_achat, $cmeAchat);
                
                if ($pos2!==false && $commande_achat!==$cmeAchat) {
                    return "C".$cmeAchat; //rajout du C pour transformer la valeur en string
                }
            return -5;
        } else {
            return $arrivage->getIdArrivage();
        }
    }

    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_arrivage.xls"');
    }

    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;


        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_arrivage.doc"');
    }

    public function executePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = 'true';

        $this->initList($request);
    }

    public function executePrintCodeBarre(sfWebRequest $request) {
        $refProduit = $request->getParameter('refProduit');
        $statut = 1;
        try {
            $this->printCodeBarre($refProduit);
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    public function executePrintCodesBarres(sfWebRequest $request) {
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));
        $statut = 1;
        try {
            $arrivagesProduits = WrkArrivageProduitTable::getInstance()->getProduits($request->getParameter('idArrivage'));
            foreach ($arrivagesProduits as $arrivageProduit) {
                $this->printCodeBarre($arrivageProduit->getRefProduit());
            }
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    public function executePrintNumArrivage(sfWebRequest $request) {
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));
        $statut = 1;
        try {
            $this->printNumArrivage($arrivage);
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    public function executeCheckNumArrivage(sfWebRequest $request) {
        $res = array('numArrivage' => '', 'unique' => true);
        $date = $request->getParameter('date', date('d/m/Y H:i:s'));
        $numArrivage = DateTime::createFromFormat('d/m/Y H:i:s', $date)->format('ymdHis');

        $res['numArrivage'] = $numArrivage;
        $res['unique'] = WrkArrivageTable::getInstance()->checkNumArrivageUnique($numArrivage);

        return $this->renderText(json_encode($res));
    }

    public function checkUrgence($tracking_four, $commande_achat, $idTransporteur, $idFournisseur) {
        
        $date = date("Y-m-d H:i:s");
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $date->modify('-15 minutes');
        $date = $date->format('Y-m-d H:i:s');

        $urgences = WrkUrgenceTable::getInstance()->createQuery()
                        ->select("*")
                        ->andWhere("created_at <= ?", $date)
                        ->orderBy("created_at DESC")->execute();

        foreach ($urgences as $urgence) {
            $critere = 0;
            $cmeAchat = $urgence->getCommandeAchat();
            $trckFour = $urgence->getTrackingFour();
            $fourn = $urgence->getIdFournisseur();
            $transp = $urgence->getIdTransporteur();

            
            if ($trckFour == $tracking_four && $tracking_four!="") {
                $critere++;
            }

            if ($transp == $idTransporteur) {
                $critere++;
            }
            
            if ($fourn == $idFournisseur) {
                $critere++;
            }

            if ($critere >= 3) {
                return $urgence;
            }

            if ($critere >= 2) {
                $pos1 = strpos($cmeAchat, $commande_achat);
                $pos2 = strpos($commande_achat, $cmeAchat);
                
                if ($pos1!==false || $pos2!==false) {
                    return $urgence;
                }
                /*$comds1 = explode(" ", $cmeAchat);
                $comds2 = explode(" ", $commande_achat);
                foreach ($comds1 as $value1) {
                    $found = false;
                    foreach ($comds2 as $value2) {
                        if ($value1 == $value2 && $value1!="" && $value2!="" && strlen($value1)>3 && strlen($value2)>3) {
                            $found = true;
                            break;
                        }
                    }

                    if ($found) {
                        $critere++;
                        break;
                    }
                }*/

                /*if ($critere >= 3) {
                    return $urgence;
                }*/
            }
        }

        /* if ($tracking_four && $tracking_four !== "" && trim($tracking_four) != "") {
          $urgence = WrkUrgenceTable::getInstance()->createQuery()
          ->select("*")
          ->where("tracking_four = ?", $tracking_four)
          ->andWhere("created_at <= ?", $date)->execute();

          $urgence = $urgence->getLast();

          if ($urgence != null) {
          return $urgence;
          }
          }
          if ($commande_achat && $commande_achat !== "" && trim($commande_achat) != "") {

          $comds = explode(" ", $commande_achat);
          foreach ($comds as $value) {
          $urgence = WrkUrgenceTable::getInstance()->createQuery()
          ->select("*")
          ->where("commande_achat = ?", $value)
          ->andWhere("created_at <= ?", $date)->execute();

          $urgence = $urgence->getLast();

          if ($urgence) {

          }
          }

          $urgence = WrkUrgenceTable::getInstance()->createQuery()
          ->select("*")
          ->where("commande_achat = ?", $commande_achat)
          ->andWhere("created_at <= ?", $date)->execute();

          return $urgence->getLast();
          } */
        return null;
    }

    public function executeArrivageUrgenceUpdate(sfWebRequest $request) {
        $date_livraison_debut = $request->getParameter('date_livraison_debut', null);
        $date_livraison_fin = $request->getParameter('date_livraison_fin', null);
        $contact_pff = $request->getParameter('contact_pff');

        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($arrivage = WrkArrivageTable::getInstance()->find(array($request->getParameter('idArrivage'))), sprintf('Object wrk_arrivage does not exist (%s).', $request->getParameter('idArrivage')));



        $dateCreation = strtotime($arrivage->getCreatedAt());
        $date1 = strtotime("-1 day");


        if ($dateCreation < $date1) {
            return $this->renderText(false);
        }

        if ($date_livraison_debut != null && $date_livraison_debut != "") {
            $date_livraison_debut = DateTime::createFromFormat('d/m/Y H:i:s', $date_livraison_debut)->format('Y-m-d H:i:s');
            $arrivage->setDateLivraisonDebut($date_livraison_debut);
        }
        if ($date_livraison_fin != null && $date_livraison_fin != "") {
            $date_livraison_fin = DateTime::createFromFormat('d/m/Y H:i:s', $date_livraison_fin)->format('Y-m-d H:i:s');
            $arrivage->setDateLivraisonFin($date_livraison_fin);
        }



        if ($contact_pff != null && $contact_pff != "" && $contact_pff != "-1") {
            $interlocuteurInit = $arrivage->getIdInterlocuteur();
            $arrivage->setIdInterlocuteur($contact_pff);

            //Envoi mail ici
            if ($interlocuteurInit != $contact_pff) {
                WrkArrivageTable::getInstance()->envoiMail($arrivage);
            }
        }


        $arrivage->save();

        return $this->renderText(true);
    }

    private function printCodeBarre($refProduit) {
        if (!$refProduit || $refProduit === '') {
            return false;
        }
        $spool = new AdmSpool();
        $spool->setCodeEtiq('ETAT_COLIS');
        $spool->setNbEtiq(1);
        $spool->setParametres($refProduit);
        $spool->setImprimee(0);
        $spool->save();
        return true;
    }

    private function printNumArrivage(WrkArrivage $arrivage) {
        $arrivagesProds = $arrivage->getWrkArrivageProduit();
        if (count($arrivagesProds) > 0) {
            $arrivageProduit = $arrivagesProds->getFirst();
            $refProduit = $arrivageProduit->getRefProduit();
            $numArrivage = substr($refProduit, 1, 12);
            $spool = new AdmSpool();
            $spool->setCodeEtiq('ETAT_ARRIVAGE');
            $spool->setNbEtiq(1);
            $spool->setParametres($numArrivage);
            $spool->setImprimee(0);
            $spool->save();
        }
    }

    /* Historisation mouvement */

    private function createNewMouvement($refProduit, $date, $emplacement = null) {

        if ($emplacement == null) {
            $emplacement = RefEmplacementTable::findEmplacementArrivage();
        }

        $mouvement = new WrkMouvement();
        $mouvement->setIdUtilisateur($this->getUser()->getGuardUser()->getId());
        $mouvement->setHeurePrise($date);
        $mouvement->setCreatedAt($date);
        $mouvement->setUpdatedAt($date);
        $mouvement->setBrSap($refProduit);
        $mouvement->setRefProduit($refProduit);
        $mouvement->setRefEmplacement($emplacement);
        $mouvement->setType('depose');
        $mouvement->setQuantite(1);
        $mouvement->setRetry(0);
        $mouvement->setGroupe('');
        $mouvement->setCommentaire('');
        $mouvement->save();
    }

    private function createNewReception($collectionArrivageProduit) {
        foreach ($collectionArrivageProduit as $value) {
            $arrivageProd = new WrkArrivageProduit();
            $arrivageProd->setWrkArrivage($value->getWrkArrivage());
            $arrivageProd->setIdNature($value->getIdNature());
            $arrivageProd->setRefProduit($value->getRefProduit());
            $arrivageProd->setBrSap($value->getRefProduit());

            //  $arrivageProd->setDepose('1');
            $arrivageProd->setCreatedAt($value->getCreatedAt());
            $arrivageProd->setUpdatedAt($value->getUpdatedAt());
            $arrivageProd->setIdUtilisateur($this->getUser()->getGuardUser()->getId());
            $arrivageProd->save();
        }
    }

    public function checkValue($idFournisseur, $idTransporteur, $chauffeur, $lVoiture, $colis, $palette, $immatriculation) {
        if ($idFournisseur === '' || $idTransporteur === '') {
            return false;
        }

        if ($colis !== '' && !is_numeric($colis)) {
            return false;
        }
        if ($palette !== '' && !is_numeric($palette)) {
            return false;
        }

        return true;
    }

}
