<?php

/**
 * statistiques actions.
 *
 * @package    MobileStockV3
 * @subpackage statistiques
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class encoursActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeExport(sfWebRequest $request) {
        $type = $request->getParameter("type");

            if ($type == "excel") {
                $this->executeListDeposeExcel($request);
            } else if ($type == "word") {
                $this->executeListDeposeWord($request);
            } else if ($type == "print") {
                $this->executeListDeposePrint($request);
            }
    }

    public function executeListDeposeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->emplacement = $request->getParameter('emplacement');
        $time = strtotime('now  -15 days');

        $heureDebut = date("Y-m-d", $time) . ' 00:00:00';

        $this->mouvements = WrkMouvementTable::getInstance()->getDeposeEmplacementDelais($heureDebut, $this->emplacement);


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_segment.xls"');
    }

    public function executeListDeposeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;


        $this->emplacement = $request->getParameter('emplacement');
        $time = strtotime('now  -15 days');

        $heureDebut = date("Y-m-d", $time) . ' 00:00:00';

        $this->mouvements = WrkMouvementTable::getInstance()->getDeposeEmplacementDelais($heureDebut, $this->emplacement);


        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_segment.doc"');
    }

    public function executeListDeposePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = true;


        $this->emplacement = $request->getParameter('emplacement');
        $time = strtotime('now  -15 days');

        $heureDebut = date("Y-m-d", $time) . ' 00:00:00';

        $this->mouvements = WrkMouvementTable::getInstance()->getDeposeEmplacementDelais($heureDebut, $this->emplacement);
    }

}
