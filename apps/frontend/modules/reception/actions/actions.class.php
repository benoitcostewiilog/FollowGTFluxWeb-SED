<?php

/**
 * reception actions.
 *
 * @package    MobileStockV3
 * @subpackage reception
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class receptionActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->initList($request);
        $this->setTemplate('index');
    }

    public function executeListAjax(sfWebRequest $request) {
        $this->initList($request);
        return $this->renderPartial('list', array('assBR' => $this->assBR, 'users' => $this->users));
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($reception = Doctrine_Core::getTable('WrkArrivageProduit')->find(array($request->getParameter('id'))), sprintf('Object WrkArrivageProduit does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            $mvtReception = WrkMouvementTable::getInstance()->getWrkMouvementReception($reception);
            WrkArrivageProduitTable::getInstance()->getConnection()->beginTransaction();
            $mvtReception->delete();
            $reception->delete();
            WrkArrivageProduitTable::getInstance()->getConnection()->commit();
        } catch (Exception $e) {
            $statut = 0;
        }

        return $this->renderText($statut);
    }

    private function initList(sfWebRequest $request) {
        $this->heureDebut = $request->getParameter('heureDebut', date('d/m/Y') . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');
        $this->produit = $request->getParameter('produit', '');
        $this->brSap = $request->getParameter('brSap', '');
        $heureDebut = '';
        if ($this->heureDebut != '') {
            $heureDebut = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureDebut)->format('y-m-d H:i:s');
        }
        $heureFin = '';
        if ($this->heureFin != '') {
            $heureFin = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureFin)->format('y-m-d H:i:s');
        }
        $this->assBR = WrkArrivageProduitTable::getInstance()->getReceptions($heureDebut, $heureFin, $this->produit, $this->brSap);

        $users = sfGuardUserTable::getInstance()->findAll();
        $this->users = array();
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user->getUsername();
        }
    }

    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;
        $users = sfGuardUserTable::getInstance()->findAll();
        $this->users = array();
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user->getUsername();
        }
        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_reception.xls"');
    }

    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;


        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_reception.doc"');
    }

    public function executePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = 'true';

        $this->initList($request);
    }

}
