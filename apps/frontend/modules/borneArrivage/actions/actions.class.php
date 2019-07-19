<?php

/**
 * borneArrivage actions.
 *
 * @package    MobileStockV3
 * @subpackage arrivage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class borneArrivageActions extends sfActions {
    
    /* Affichage du formulaire de la borne */
    public function executeIndex(sfWebRequest $request) {
        $this->fournisseurs = RefFournisseurTable::getInstance()->findAll();
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
        $this->chauffeurs = RefChauffeurTable::getInstance()->findAll();
        $this->natures = RefNatureTable::getInstance()->findAll();
        $this->interlocuteurs = RefInterlocuteurTable::getInstance()->findAll();
    }
    
    /* maintien de la session */
    public function executeKeepAlive(sfWebRequest $request) {
        
        return $this->renderText('ok');
        
    }
}
