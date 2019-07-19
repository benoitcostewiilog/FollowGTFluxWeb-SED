<?php

/**
 * urgence actions.
 *
 * @package    MobileStockV3
 * @subpackage urgence
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class urgenceActions extends sfActions {

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

        return $this->renderPartial('list', array('urgences' => $this->urgences));
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

        $this->urgences = WrkUrgenceTable::getInstance()->getUrgences($heureDebut, $heureFin, $this->fournisseur, $this->transporteur, $this->statut, $this->produit, $this->urgent);
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
        $numUrgence = $this->build($request);
       
        return $this->renderText($numUrgence);
    }


    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));
        $this->urgence = $urgence;
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        $this->natures = RefNatureTable::getInstance()->findAll();   $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
        
          $dateCreation = strtotime( $urgence->getCreatedAt());
        $date1 = strtotime("-1 day");
        
        $this->editUrgence=true;
        if($dateCreation<$date1){
           $this->editUrgence=false;
        
        }
    }
    
    
    public function executeEditUrgence(sfWebRequest $request) {
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));
        $this->urgence = $urgence;
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
          $dateCreation = strtotime( $urgence->getCreatedAt());
        $date1 = strtotime("-1 day");
        
        $this->editUrgence=true;
        if($dateCreation<$date1){
           $this->editUrgence=false;
        
        }
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));

        $statut = 0;
        if ($this->build($request, $urgence)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));
        $statut = 1;
        try {
          $urgence->delete();
            
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build(sfWebRequest $request, WrkUrgence $urgence = null) {
        $dateUrgence = $request->getParameter('dateUrgence', '');
        $idFournisseur = $request->getParameter('fournisseur');
        $idTransporteur = $request->getParameter('transporteur');
        
        
         $tracking_four = $request->getParameter('tracking_four');
          $commande_achat = $request->getParameter('commande_achat');
          
           $date_livraison_debut = $request->getParameter('date_livraison_debut',null);
           $date_livraison_fin = $request->getParameter('date_livraison_fin',null);
            $contact_pff = $request->getParameter('contact_pff',null);
            


       

        $isOk = $this->checkValue($idFournisseur, $idTransporteur);

        if (!$isOk) {
            return false;
        }
        if ($urgence == null) {
            $urgence = new WrkUrgence();
            $urgence->setCreatedAt(date('Y-m-d H:i:s'));
        }

        $numUrgence = '';
        if ($dateUrgence != "") { //si on a une date d'urgence on creer un num urgence
            $numUrgence = DateTime::createFromFormat('d/m/Y H:i:s', $dateUrgence)->format('ymdHis');
            $dateUrgence = DateTime::createFromFormat('d/m/Y H:i:s', $dateUrgence)->format('Y-m-d H:i:s');
            $urgence->setCreatedAt($dateUrgence);
        }

        $urgence->setIdFournisseur($idFournisseur);
        $urgence->setIdTransporteur($idTransporteur);
      
        
     
        
         if($date_livraison_debut!=null && $date_livraison_debut!=""){
                 $date_livraison_debut = DateTime::createFromFormat('d/m/Y H:i:s', $date_livraison_debut)->format('Y-m-d H:i:s');
           $urgence->setDateLivraisonDebut($date_livraison_debut);
       
           }else{
                $urgence->setDateLivraisonDebut(null);
           }
            if($date_livraison_fin!=null && $date_livraison_fin!=""){
                 $date_livraison_fin = DateTime::createFromFormat('d/m/Y H:i:s', $date_livraison_fin)->format('Y-m-d H:i:s');
         $urgence->setDateLivraisonFin($date_livraison_fin);
       
           }else{
                $urgence->setDateLivraisonFin(null);
           }
        
      
          $urgence->setTrackingFour($tracking_four);
            $urgence->setCommandeAchat($commande_achat);
            
        
       
             
                $urgence->setIdInterlocuteur($contact_pff);
            
           
         
        try {
            WrkUrgenceTable::getInstance()->getConnection()->beginTransaction();
            $urgence->save();
            WrkUrgenceTable::getInstance()->getConnection()->commit();

        } catch (Exception $e) {
            return false;
        }
        return $urgence->getIdUrgence();
    }

    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_urgence.xls"');
    }

    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;


        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_urgence.doc"');
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
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));
        $statut = 1;
        try {
            $urgencesProduits = WrkUrgenceProduitTable::getInstance()->getProduits($request->getParameter('idUrgence'));
            foreach ($urgencesProduits as $urgenceProduit) {
                $this->printCodeBarre($urgenceProduit->getRefProduit());
            }
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    public function executePrintNumUrgence(sfWebRequest $request) {
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));
        $statut = 1;
        try {
            $this->printNumUrgence($urgence);
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    public function executeCheckNumUrgence(sfWebRequest $request) {
        $res = array('numUrgence' => '', 'unique' => true);
        $date = $request->getParameter('date', date('d/m/Y H:i:s'));
        $numUrgence = DateTime::createFromFormat('d/m/Y H:i:s', $date)->format('ymdHis');

        $res['numUrgence'] = $numUrgence;
        $res['unique'] = WrkUrgenceTable::getInstance()->checkNumUrgenceUnique($numUrgence);

        return $this->renderText(json_encode($res));
    }
    
    public function executeUrgenceUrgenceUpdate(sfWebRequest $request) {
         $date_livraison_debut = $request->getParameter('date_livraison_debut',null);
          $date_livraison_fin = $request->getParameter('date_livraison_fin',null);
        $contact_pff = $request->getParameter('contact_pff');
          
               $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($urgence = WrkUrgenceTable::getInstance()->find(array($request->getParameter('idUrgence'))), sprintf('Object wrk_urgence does not exist (%s).', $request->getParameter('idUrgence')));

        
     
        $dateCreation = strtotime( $urgence->getCreatedAt());
        $date1 = strtotime("-1 day");
        
        
        if($dateCreation<$date1){
            return $this->renderText(false);
        }
        
         if($date_livraison_debut!=null && $date_livraison_debut!=""){
                 $date_livraison_debut = DateTime::createFromFormat('d/m/Y H:i:s', $date_livraison_debut)->format('Y-m-d H:i:s');
           $urgence->setDateLivraisonDebut($date_livraison_debut);
       
           }
            if($date_livraison_fin!=null && $date_livraison_fin!=""){
                 $date_livraison_fin = DateTime::createFromFormat('d/m/Y H:i:s', $date_livraison_fin)->format('Y-m-d H:i:s');
         $urgence->setDateLivraisonFin($date_livraison_fin);
       
           }
          
  
           
              if($contact_pff!=null && $contact_pff!=""&& $contact_pff!="-1"){
                  $interlocuteurInit = $urgence->getIdInterlocuteur();
                $urgence->setIdInterlocuteur($contact_pff);
            
               //Envoi mail ici
                if($interlocuteurInit!=$contact_pff){
            WrkUrgenceTable::getInstance()->envoiMail($urgence);
                }
           }
             
             
             $urgence->save();
          
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

    private function printNumUrgence(WrkUrgence $urgence) {
        $urgencesProds = $urgence->getWrkUrgenceProduit();
        if (count($urgencesProds) > 0) {
            $urgenceProduit = $urgencesProds->getFirst();
            $refProduit = $urgenceProduit->getRefProduit();
            $numUrgence = substr($refProduit, 1, 12);
            $spool = new AdmSpool();
            $spool->setCodeEtiq('ETAT_ARRIVAGE');
            $spool->setNbEtiq(1);
            $spool->setParametres($numUrgence);
            $spool->setImprimee(0);
            $spool->save();
        }
    }
    
        /* Historisation mouvement */
    private function createNewMouvement($refProduit, $date) {
        $emplacement = RefEmplacementTable::findEmplacementUrgence();
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
    
      private function createNewReception($collectionUrgenceProduit) {
            foreach ($collectionUrgenceProduit as $value) {
                $urgenceProd = new WrkUrgenceProduit();
                $urgenceProd->setWrkUrgence($value->getWrkUrgence());
                $urgenceProd->setIdNature(  $value->getIdNature());
                $urgenceProd->setRefProduit( $value->getRefProduit());
                $urgenceProd->setBrSap( $value->getRefProduit());
        
              //  $urgenceProd->setDepose('1');
                $urgenceProd->setCreatedAt( $value->getCreatedAt());
                $urgenceProd->setUpdatedAt( $value->getUpdatedAt());
                $urgenceProd->setIdUtilisateur($this->getUser()->getGuardUser()->getId());
                $urgenceProd->save();
            }
           
 
    }

    public function checkValue($idFournisseur, $idTransporteur) {
        if ($idFournisseur === '') {
            return false;
        }


        return true;
    }

}
