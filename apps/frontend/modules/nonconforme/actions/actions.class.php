<?php

/**
 * nonconformes actions.
 *
 * @package    MobileStockV3
 * @subpackage nonconformes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nonconformeActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->initList($request);
        $this->emplacements = RefEmplacementTable::getInstance()->findAll();
    }

    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_nonconforme.xls"');
    }

    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->initList($request);

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_nonconforme.doc"');
    }

    public function executePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = 'true';

        $this->initList($request);
    }

    private function initList(sfWebRequest $request) {
        
        $time = strtotime('now  -15 days');
   
        $this->heureDebut = $request->getParameter('heureDebut',date("d/m/Y", $time) . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');
     
        $heureDebut = '';
        if ($this->heureDebut != '') {
            $heureDebut = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureDebut)->format('Y-m-d H:i:s');
        }
        $heureFin = '';
        if ($this->heureFin != '') {
            $heureFin = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureFin)->format('Y-m-d H:i:s');
        }
        
        $this->emplacement=  RefEmplacementTable::findEmplacementNonConforme()->getCodeEmplacement();
        $this->nonconformes = WrkInventaireTable::getInstance()->getDeposeEmplacement($heureDebut, $heureFin, $this->emplacement);
        $users = sfGuardUserTable::getInstance()->findAll();
        $this->users = array();
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user->getUsername();
        }
        
    }
    
  public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($mouvement = Doctrine_Core::getTable('WrkMouvement')->find(array($request->getParameter('id'))), sprintf('Object ref_nature does not exist (%s).', $request->getParameter('id')));
        $this->mouvement = $mouvement;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($mouvement = Doctrine_Core::getTable('WrkMouvement')->find(array($request->getParameter('id'))), sprintf('Object ref_nature does not exist (%s).', $request->getParameter('id')));

        $anomalie = $request->getParameter('anomalie');

        
        $mouvement->setAnomalie($anomalie);
        
        $mouvement->save();
        return $this->renderText(true);
    }
}
