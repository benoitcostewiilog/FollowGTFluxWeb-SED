<?php

/**
 * nature actions.
 *
 * @package    MobileStockV3
 * @subpackage nature
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class natureActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->natures = Doctrine_Core::getTable('RefNature')
                ->createQuery('a')
                ->execute();
    }

    public function executeListAjax(sfWebRequest $request) {
        $natures = Doctrine_Core::getTable('RefNature')
                ->createQuery('a')
                ->execute();

        return $this->renderPartial('list', array('natures' => $natures));
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $libelle = $request->getParameter('libelle');
        $delais = $request->getParameter('delais');
        $statut = 0;
        if ($this->build($libelle, $delais)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($nature = Doctrine_Core::getTable('RefNature')->find(array($request->getParameter('id'))), sprintf('Object ref_nature does not exist (%s).', $request->getParameter('id')));
        $this->nature = $nature;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($nature = Doctrine_Core::getTable('RefNature')->find(array($request->getParameter('id'))), sprintf('Object ref_nature does not exist (%s).', $request->getParameter('id')));

        $libelle = $request->getParameter('libelle');
        $delais = $request->getParameter('delais');

        $statut = 0;
        if ($this->build($libelle, $delais, $nature)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($nature = Doctrine_Core::getTable('RefNature')->find(array($request->getParameter('id'))), sprintf('Object ref_nature does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            $nature->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build($libelle, $delais, RefNature $nature = null) {
        if ($libelle !== '') {
            if ($nature == null) {
                $nature = new RefNature();
                $nature->setCreatedAt(date('Y-m-d H:i:s'));
            }
            $nature->setLibelle($libelle);
            $nature->setDelais($delais);
            $nature->save();
            return true;
        }
        return false;
    }

}
