<?php

/**
 * chauffeur actions.
 *
 * @package    MobileStockV3
 * @subpackage chauffeur
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class borneExpeditionActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {

        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        
    }
    
    /* Création de l'expédition */
    public function executeCreate (sfWebRequest $request){
        
        $expedition = new WrkExpedition();
        
        $idTransporteur = $request->getParameter('transporteur');
        $chauffeur = $request->getParameter('chauffeur');
        $lVoiture = $request->getParameter('lVoiture');
        $immatriculation = $request->getParameter('immatriculation');
        $nbcolis = intval($request->getParameter('umStandard', 0));
        
       
        $expedition->setIdTransporteur($idTransporteur);
        $expedition->setIdChauffeur($chauffeur);
        $expedition->setLettreVoiture($lVoiture);
        $expedition->setImmatriculation($immatriculation);
        $expedition->setNbColis($nbcolis);
        $expedition->setCreatedAt(date("Y-m-d H:i:s"));
        
        $expedition->save();
        
        //impression etiquettes
        
        $spool = new AdmSpool();
        $spool->setCodeEtiq('ETAT_EXPEDITION');
        $spool->setNbEtiq(1);
        $spool->setParametres(date(ymdhis));
        $spool->setImprimee(0);
        $spool->save();
        
        return $this->renderText('1');
    }

}
