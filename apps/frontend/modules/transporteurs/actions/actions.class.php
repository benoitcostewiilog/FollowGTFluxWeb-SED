<?php

/**
 * transporteurs actions.
 *
 * @package    MobileStockV3
 * @subpackage transporteurs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class transporteursActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->transporteurs = Doctrine_Core::getTable('RefTransporteur')
                ->createQuery('a')
                ->select('a.*,c.*')
                ->leftJoin('a.RefChauffeur c')
                ->execute();
    }

    public function executeListAjax(sfWebRequest $request) {
        $transporteurs = Doctrine_Core::getTable('RefTransporteur')
                ->createQuery('a')
                ->select('a.*,c.*')
                ->leftJoin('a.RefChauffeur c')
                ->execute();

        return $this->renderPartial('list', array('transporteurs' => $transporteurs));
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $libelle = $request->getParameter('libelle');
        $statut = 0;
        $statut = $this->build($libelle);
        if($statut) {
            return $this->renderText($statut);
        }
        return $this->renderText('');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($transporteur = Doctrine_Core::getTable('RefTransporteur')->find(array($request->getParameter('id'))), sprintf('Object ref_transporteur does not exist (%s).', $request->getParameter('id')));
        $this->transporteur = $transporteur;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($transporteur = Doctrine_Core::getTable('RefTransporteur')->find(array($request->getParameter('id'))), sprintf('Object ref_transporteur does not exist (%s).', $request->getParameter('id')));

        $libelle = $request->getParameter('libelle');

        $statut = 0;
        if ($this->build($libelle, $transporteur)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($transporteur = Doctrine_Core::getTable('RefTransporteur')->find(array($request->getParameter('id'))), sprintf('Object ref_transporteur does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            $transporteur->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build($libelle, RefTransporteur $transporteur = null) {
        if ($libelle !== '') {
            if ($transporteur === null || ($transporteur !== null && $transporteur->getLibelle() !== $libelle)) {
                if (!$this->checkLibelleUnique($libelle)) {
                    return false;
                }
            }
            if ($transporteur == null) {
                $transporteur = new RefTransporteur();
                $transporteur->setCreatedAt(date('Y-m-d H:i:s'));
            }
            $transporteur->setLibelle($libelle);
            $transporteur->save();
            
            return $transporteur->getIdTransporteur();
        }
        return false;
    }

    public function checkLibelleUnique($libelle) {
        $transporteur = RefTransporteurTable::getInstance()->findByLibelle($libelle);
        if (count($transporteur) > 0) {
            return false;
        }
        return true;
    }

}
