<?php

/**
 * acheminement actions.
 *
 * @package    MobileStockV3
 * @subpackage acheminement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class acheminementActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->acheminements = WrkAcheminementTable::getInstance()->getAcheminements();
    }

    public function executeListAjax(sfWebRequest $request) {
        $acheminements = WrkAcheminementTable::getInstance()->getAcheminements();

        return $this->renderPartial('list', array('acheminements' => $acheminements));
    }

    public function executeNew(sfWebRequest $request) {
        $this->users = RefDestinataireAcheminementTable::getInstance()->findAll();
        $this->emplacements = RefEmplacementAcheminementTable::getInstance()->findAll();
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $statut = 0;
        if ($this->build($request)) {
            $statut = 1;
        }
        return $this->renderText('');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('id'))), sprintf('Object ref_acheminement does not exist (%s).', $request->getParameter('id')));
        $this->acheminement = $acheminement;
        $this->users = RefDestinataireAcheminementTable::getInstance()->findAll();
        $this->emplacements = RefEmplacementAcheminementTable::getInstance()->findAll();
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('idAch'))), sprintf('Object ref_acheminement does not exist (%s).', $request->getParameter('id')));

        $statut = 0;
        $statut = $this->build($request, $acheminement);
        if ($statut) {
            return $this->renderText($statut);
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('id'))), sprintf('Object ref_acheminement does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            
            $lstColis = $acheminement->getWrkAcheminementColis();
            foreach ($lstColis as $colis){
            
                $colis->delete();
             
            }
            
            $acheminement->delete();
        } catch (Exception $e) {
            $statut = 0;
        }

        return $this->renderText($statut);
    }

    public function build(sfWebRequest $request, WrkAcheminement $acheminement = null) {

        $emplacementPrise   = $request->getParameter('empPrise');
        $emplacementDepose  = $request->getParameter('empDepose');
        $nbColis            = $request->getParameter('nbColis');
        $demandeur          = $request->getParameter('demandeur');
        $destinataire       = $request->getParameter('destinataire');
        
        sfContext::getInstance()->getLogger()->info("NB_COLIS : ".$nbColis);
        
        if ($emplacementPrise !== '' && $emplacementDepose !== '' && $destinataire !== '') {
            if ($acheminement == null) {
 
                $dateCreation = date('Y-m-d H:i:s');
                $numAcheminement = date('YmdHis');
                $numTracking = 'TRC' . $numAcheminement;
                
                // creation de l'acheminement 
                $acheminement = new WrkAcheminement();
                $acheminement->setNumAcheminement($numAcheminement);
                $acheminement->setRefProduit('');
                $acheminement->setNbColis($nbColis);
                $acheminement->setCodeEmplacementPrise($emplacementPrise);
                $acheminement->setCodeEmplacementDepose($emplacementDepose);
                $acheminement->setDelais('');
                $acheminement->setStatut('initial');
                $acheminement->setCreatedAt($dateCreation);
                $acheminement->setDemandeur($demandeur);
                $acheminement->setDestinataire($destinataire);
                $acheminement->save();
                
                //on créé ensuite tous les colis
                for($i = 1; $i <= $nbColis; $i++){
                    
                    $colis = new WrkColisAcheminement();
                    $colis->setIdAcheminement($acheminement->getIdAcheminement());
                    $colis->setTracking($numTracking.$i);
                    $colis->setNumeroColis($i);
                    $colis->setStatut('initial');
                    $colis->setCreatedAt($dateCreation);
                    $colis->save();
                }
                             
                return $this->renderText($acheminement->getIdAcheminement());                
            }
            else{
            
                $acheminement->setRefProduit('');
                $acheminement->setCodeEmplacementPrise($emplacementPrise);
                $acheminement->setCodeEmplacementDepose($emplacementDepose);
                $acheminement->setDelais('');
                $acheminement->setDemandeur($demandeur);
                $acheminement->setDestinataire($destinataire);
                
                // ctrl si la qte colis a été modifié
                if($acheminement->getNbColis() != $nbColis){
                    $colis = Doctrine::getTable('WrkColisAcheminement')->deleteColisAcheminement($acheminement);  
                    $colis = Doctrine::getTable('WrkColisAcheminement')->createColisAcheminement($nbColis,$acheminement); 
                    $acheminement->setNbColis($nbColis);
                }
                    
                $acheminement->save();
                
               return $acheminement->getIdAcheminement();
            }
        }
        return false;
    }
    
    /* Impression des fiches de suivi tracking */
    public function executePrint(sfWebRequest $request) {
        $this->forward404Unless($this->acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('id'))), sprintf('Object acheminement does not exist (%s).', $request->getParameter('id')));
        
        //on recupere tous les colis lies a cet acheminement
        
        $this->listeColis = $this->acheminement->getWrkAcheminementColis();
        
        $this->setLayout(false);
        $this->setTemplate('print');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
    }
    
    /* Generation fiche suivi en pdf*/
    public function executeExportPdf(sfWebRequest $request) {
        
        require_once(sfConfig::get('sf_lib_dir') . '/mpdf/mpdf.php');
        require_once(sfConfig::get('sf_lib_dir') . '/barcode.php');
        
        $dateHeure = date('dmY-Hi');
        
        $this->forward404Unless($acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('id'))), sprintf('Object acheminement does not exist (%s).', $request->getParameter('id')));
        
        //on recupere tous les colis lies a cet acheminement
        $listeColis = $acheminement->getWrkAcheminementColis();
        
        //generation des images temporaire des code-barres 
        $filepath = sfConfig::get('sf_web_dir') . '/export/';
        foreach ($listeColis as $colis ){ 
            
           barcode($filepath.$colis->getTracking().'.png', $colis->getTracking());
           
        }
           
        $html = $this->getPartial('pdf', array('listeColis' => $acheminement->getWrkAcheminementColis(), 'acheminement' => $acheminement));

        $mpdf = new mPDF();
		$mpdf->WriteHTML($html);
		$file_namePdf = "Tracking" . $dateHeure . ".pdf";
		$mpdf->Output($file_namePdf,'D');
        
        //suppression des images CB 
        foreach ($listeColis as $colis ){ 
            
            unlink($filepath.$colis->getTracking().'.png');
           
        }
        
        return $this->renderText('');
    }
    
    /* Affichage formulaire designation colis */
     public function executeListColis(sfWebRequest $request) {
         
         $this->forward404Unless($acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('idAch'))), sprintf('l\' Object acheminement est inconnu (%s).', $request->getParameter('id')));
         
         $colis = $acheminement->getWrkAcheminementColis();
         $idAcheminement = $acheminement->getIdAcheminement();
         return $this->renderPartial('listColis', array('lstColis' => $colis, 'nbColis' => count($colis), 'idAchm' => $idAcheminement));
     }
     
     /* Enregistre les désignation colis */
     public function executeSaveColis(sfWebRequest $request) {
         
        $nbColis =  $request->getParameter('nbColis');
         
        //on recupere tous les colis de l'acheminement
         $this->forward404Unless($acheminement = Doctrine_Core::getTable('WrkAcheminement')->find(array($request->getParameter('idAcheminement'))), sprintf('pas d\' Object acheminement(%s).', $request->getParameter('idAcheminement')));
         $listeColis = $acheminement->getWrkAcheminementColis();
         $i = 1;
         foreach ($listeColis as $colis){
             
             $colis->setDesignation($request->getParameter('colis'.$i));
             $colis->save();
             $i++;
             
         }
    
         $this->redirect('@acheminement');
     }
     
}
