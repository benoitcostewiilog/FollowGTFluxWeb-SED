<?php

/**
 * associationBR actions.
 *
 * @package    MobileStockV3
 * @subpackage associationBR
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class associationBRActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('indexSimpleAjax');
    }

    public function executeIndex2(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('indexSimpleRedirect');
    }

    public function executeIndexComplete(sfWebRequest $request) {
        $this->setTemplate('index');
    }

    public function executeListAjax(sfWebRequest $request) {
        $assBR = Doctrine_Core::getTable('WrkArrivageProduit')
                ->createQuery('a')
                ->andWhere('br_sap != ?', "")
                ->execute();

        return $this->renderPartial('list', array('assBR' => $assBR));
    }

    //NEW
    public function executeValiderAss(sfWebRequest $request) {
        $this->prod = $request->getPostParameter('produit');
        $this->sap = $request->getPostParameter('brsap');

        if ($this->prod && $this->sap) {
            $this->validerAss($this->prod, $this->sap);

            $this->prodErreur = count($this->arrivages) > 0 ? false : true;
            $this->sapErreur = count($this->brSAP) == 0 ? false : true;

            if (!$this->prodErreur && !$this->sapErreur) {
                $this->prod = '';
                $this->sap = '';
            }
        }
        $this->assBR = Doctrine_Core::getTable('WrkArrivageProduit')
                ->createQuery('a')
                ->andWhere('br_sap != ?', "")
                ->execute();
        $this->setLayout(false);
        $this->setTemplate('indexSimpleRedirect');
    }

    //NEW
    public function executeValiderAssAjax(sfWebRequest $request) {
        $prod = $request->getPostParameter('prod');
        $sap = $request->getPostParameter('sap');
        $arrivageSuppJSON = $request->getPostParameter('arrivageSuppJson', '[]');

        $prodErreur = 1;
        $sapErreur = 1;
        $jsonErrorArrivageSupp = "[]";
        $this->errorArrivageSupp = array();
        if ($prod && $sap) {
            $this->validerAss($prod, $sap, $arrivageSuppJSON);
            if ($prod == 'Absent') {
                $prodErreur = 0;
            } else {
                $prodErreur = count($this->arrivages) > 0 ? 0 : 1;
            }
            $sapErreur = count($this->brSAP) == 0 ? 0 : 1;

            $jsonErrorArrivageSupp = json_encode($this->errorArrivageSupp);
        }
        $res = array('erreurProduit' => $prodErreur, 'erreurSap' => $sapErreur, 'jsonErrorArrivageSupp' => $jsonErrorArrivageSupp);

        return $this->renderText(json_encode($res));
    }

    private function validerAss($prod, $sap, $arrivageSuppJSON = '[]') {
        $brSAP = Doctrine_Core::getTable('WrkArrivageProduit')->findByBrSap($sap);
        $arrivages = Doctrine_Core::getTable('WrkArrivageProduit')->findByRefProduit($prod);

        if (count($arrivages) > 0 || $prod == 'Absent') { //si on a un arrivage liee ou que c'est une reception sans arrivage
            $arrivageSupp = json_decode($arrivageSuppJSON, false);
            if ($this->checkArrivageSupp($arrivageSupp)) {
                if (count($brSAP) == 0) { //si le num reception n'est pas deja utilise
                    $this->createNewReception($prod, $sap, $arrivages, $arrivageSupp);
                }
            }
        }
        $this->arrivages = $arrivages;
        $this->brSAP = $brSAP;
    }

    private function checkArrivageSupp($arrivageSupp) {
        if (count($arrivageSupp) == 0) {
            return true;
        }
        foreach ($arrivageSupp as $numArrivage) {
            $arrivages = Doctrine_Core::getTable('WrkArrivageProduit')->findByRefProduit($numArrivage);
            if (count($arrivages) == 0) {
                $this->errorArrivageSupp[] = $numArrivage;
            }
        }

        if (count($this->errorArrivageSupp) == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function createNewReception($prod, $sap, $arrivages, $arrivageSupp = array()) {
        $arrivageSupp[] = $prod;
        $arrivageSuppUnique = array_unique($arrivageSupp);

        $collectionArrivage = new Doctrine_Collection('WrkArrivageProduit');

        foreach ($arrivageSuppUnique as $numArrivage) {
            $newArr = new WrkArrivageProduit();
            $newArr->set('ref_produit', $numArrivage);
            $newArr->set('br_sap', $sap);
            $newArr->set('id_utilisateur', $this->getUser()->getGuardUser()->getId());
            $newArr->set('created_at', date('Y-m-d H:i:s'));
            if ($prod == 'Absent') { //si il n'y a pas de num arrivage
                $newArr->set('id_arrivage', NULL);
                $newArr->set('id_nature', RefNature::NATURE_STANDARD);
            } else {
                $unArrrivage = $arrivages->getFirst();
                $newArr->set('id_arrivage', $unArrrivage->getIdArrivage());
                $newArr->set('id_nature', $unArrrivage->getIdNature());
            }

            $collectionArrivage->add($newArr);
        }

        WrkArrivageTable::getInstance()->getConnection()->beginTransaction();
        $collectionArrivage->save();
        $this->createNewMouvement($prod, $sap);
        WrkArrivageTable::getInstance()->getConnection()->commit();
    }

    private function createNewMouvement($refProduit, $sap) {
        $emplacement = RefEmplacementTable::findEmplacementReception();
        $mouvement = new WrkMouvement();
        $mouvement->setIdUtilisateur($this->getUser()->getGuardUser()->getId());
        $mouvement->setHeurePrise(date('Y-m-d H:i:s'));
        $mouvement->setCreatedAt(date('Y-m-d H:i:s'));
        $mouvement->setBrSap($refProduit);
        $mouvement->setRefProduit($sap);
        $mouvement->setRefEmplacement($emplacement);
        $mouvement->setType('depose');
        $mouvement->setRetry(0);
        $mouvement->setGroupe('');
        $mouvement->setCommentaire('');

        $mouvement->save();
    }

}
