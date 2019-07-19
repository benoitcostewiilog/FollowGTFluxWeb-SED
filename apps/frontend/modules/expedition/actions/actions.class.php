<?php

/**
 * expedition actions.
 *
 * @package    MobileStockV3
 * @subpackage expedition
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class expeditionActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->initList($request);
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
    }

    public function executeListAjax(sfWebRequest $request) {
        $this->initList($request);

        return $this->renderPartial('list', array('expeditions' => $this->expeditions));
    }

    private function initList(sfWebRequest $request) {
        $this->heureDebut = $request->getParameter('heureDebut', date('d/m/Y') . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');
        $this->fournisseur = $request->getParameter('fournisseur', '');
        $this->transporteur = $request->getParameter('transporteur', '');
        $this->statut = $request->getParameter('statut', '');
        $this->produit = $request->getParameter('produit', '');

        $heureDebut = '';
        if ($this->heureDebut != '') {
            $heureDebut = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureDebut)->format('y-m-d H:i:s');
        }
        $heureFin = '';
        if ($this->heureFin != '') {
            $heureFin = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureFin)->format('y-m-d H:i:s');
        }

        $this->expeditions = WrkExpeditionTable::getInstance()->getExpeditions($heureDebut, $heureFin, $this->fournisseur, $this->transporteur, $this->statut, $this->produit);
    }

    public function executeNew(sfWebRequest $request) {
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        $this->natures = RefNatureTable::getInstance()->findAll();
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $statut = 0;
        if ($this->build($request)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($expedition = WrkExpeditionTable::getInstance()->find(array($request->getParameter('idExpedition'))), sprintf('Object wrk_expedition does not exist (%s).', $request->getParameter('idExpedition')));
        $this->expedition = $expedition;
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        $this->natures = RefNatureTable::getInstance()->findAll();
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($expedition = WrkExpeditionTable::getInstance()->find(array($request->getParameter('idExpedition'))), sprintf('Object wrk_expedition does not exist (%s).', $request->getParameter('idExpedition')));

        $statut = 0;
        if ($this->build($request, $expedition)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($expedition = WrkExpeditionTable::getInstance()->find(array($request->getParameter('idExpedition'))), sprintf('Object wrk_expedition does not exist (%s).', $request->getParameter('idExpedition')));
        $statut = 1;
        try {
            WrkExpeditionTable::getInstance()->getConnection()->beginTransaction();
            $expedition->getWrkExpeditionProduit()->delete();
            $expedition->delete();
            WrkExpeditionTable::getInstance()->getConnection()->commit();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build(sfWebRequest $request, WrkExpedition $expedition = null) {
        $idFournisseur = $request->getParameter('fournisseur', null);
        $idTransporteur = $request->getParameter('transporteur');
        $chauffeur = $request->getParameter('chauffeur');
        $lVoiture = $request->getParameter('lVoiture');
        $colis = $request->getParameter('colis');
        $palette = $request->getParameter('palette', 0);
        $immatriculation = $request->getParameter('immatriculation');
        $statut = $request->getParameter('statut', '');
        $printNumExpedition = $request->getParameter('printNumExp', null);

        $isOk = $this->checkValue($idFournisseur, $idTransporteur, $chauffeur, $lVoiture, $colis, $palette, $immatriculation);

        if (!$isOk) {
            return false;
        }
        if ($expedition == null) {
            $expedition = new WrkExpedition();
            $expedition->setCreatedAt(date('Y-m-d H:i:s'));
        }
        $expedition->setIdFournisseur(null);
        $expedition->setIdTransporteur($idTransporteur);
        $expedition->setIdChauffeur($chauffeur);
        $expedition->setLettreVoiture($lVoiture);
        $expedition->setNbColis($colis);
//        $expedition->setNbPalette($palette);
        $expedition->setImmatriculation($immatriculation);
        $expedition->setUpdatedAt(date('Y-m-d H:i:s'));
//        $expedition->setStatut($statut);

        try {
            $expedition->save();
            if ($printNumExpedition != null) {
                $this->printNumExpedition($expedition);
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_expedition.xls"');
    }

    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;


        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_expedition.doc"');
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
        $this->forward404Unless($expedition = WrkExpeditionTable::getInstance()->find(array($request->getParameter('idExpedition'))), sprintf('Object wrk_expedition does not exist (%s).', $request->getParameter('idExpedition')));
        $statut = 1;
        try {
            foreach ($expedition->getWrkExpeditionProduit() as $expeditionProduit) {
                $this->printCodeBarre($expeditionProduit->getRefProduit());
            }
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
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

    public function executePrintNumExpedition(sfWebRequest $request) {
        $this->forward404Unless($expedition = WrkExpeditionTable::getInstance()->find(array($request->getParameter('idExpedition'))), sprintf('Object wrk_expedition does not exist (%s).', $request->getParameter('idExpedition')));
        $statut = 1;
        try {
            $this->printNumExpedition($expedition);
        } catch (Exception $e) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    private function printNumExpedition(WrkExpedition $expedition) {
        $spool = new AdmSpool();
        $spool->setCodeEtiq('ETAT_EXPEDITION');
        $spool->setNbEtiq(1);
        $spool->setParametres($expedition->getNumExpedition());
        $spool->setImprimee(0);
        $spool->save();
    }

    public function checkValue($idFournisseur, $idTransporteur, $chauffeur, $lVoiture, $colis, $palette, $immatriculation) {
        if ($idFournisseur === '' || $idTransporteur === '' || $chauffeur == '' || $immatriculation == '') {
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
