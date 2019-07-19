<?php

/**
 * mouvements actions.
 *
 * @package    MobileStockV3
 * @subpackage mouvements
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mouvementsActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->types = array('prise', 'depose', 'prise non déposée');
        $this->emplacements = RefEmplacementTable::getInstance()->findAll();
        $this->heureDebut = $request->getParameter('heureDebut', date('d/m/Y') . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');
        $this->emplacement = $request->getParameter('emplacement', '');
        $this->type = $request->getParameter('type', '');
        $this->reference = $request->getParameter('reference', '');
         $parametrageServer=AdmSupervisionParametrageTable::getInstance()->findOneByNom("url_server_sails");
        $this->serverSails = $parametrageServer?$parametrageServer["valeur"]:"";
    }

    public function executeListAjax(sfWebRequest $request) {
        $this->getMouvements($request);


        return $this->renderPartial('list', array('mouvements' => $this->mouvements, 'mvtEnCours' => $this->mvtEnCours, 'users' => $this->users));
    }

    public function executeListJson(sfWebRequest $request) {
        $this->getMouvements($request);

        $draw = $request->getParameter('draw', '');
        return $this->renderPartial('listJson', array('mouvements' => $this->mouvements, 'draw' => $draw, "mouvementsFiltrer" => $this->mouvementsFiltrer, 'mouvementsTotal' => $this->mouvementsTotal, 'mvtEnCours' => $this->mvtEnCours, 'users' => $this->users));
    }

    public function executeNew(sfWebRequest $request) {
        $this->types = array('prise', 'passage', 'depose');
        $this->emplacements = RefEmplacementTable::getInstance()->findAll();
        $this->users = sfGuardUserTable::getInstance()->findAll();
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
        $this->forward404Unless($mouvement = Doctrine_Core::getTable('WrkMouvement')->find(array($request->getParameter('id'))), sprintf('Object ref_mouvement does not exist (%s).', $request->getParameter('id')));
        $this->types = array('prise', 'passage', 'depose');
        $this->emplacements = RefEmplacementTable::getInstance()->findAll();
        $this->users = sfGuardUserTable::getInstance()->findAll();
        $this->mouvement = $mouvement;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($mouvement = Doctrine_Core::getTable('WrkMouvement')->find(array($request->getParameter('id'))), sprintf('Object ref_transporteur does not exist (%s).', $request->getParameter('id')));

        $statut = 0;
        if ($this->build($request, $mouvement)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($mouvement = Doctrine_Core::getTable('WrkMouvement')->find(array($request->getParameter('id'))), sprintf('Object WrkMouvement does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            $mouvement->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build(sfWebRequest $request, WrkMouvement $mouvement = null) {
        $uniteTracking = $request->getParameter('uniteTracking');
        $type = $request->getParameter('type');
        $emplacement = $request->getParameter('emplacement');
        $commentaire = $request->getParameter('commentaire');
        $groupe = $request->getParameter('groupe');
        $dateHeure = $request->getParameter('heurePrise');
        $idUtilisateur = $request->getParameter('users');

        $refEmplacement = RefEmplacementTable::getInstance()->find($emplacement);

        if ($uniteTracking !== '' && $type !== '' && $emplacement !== '' && $refEmplacement) {
            $heurePrise = DateTime::createFromFormat('d/m/Y H:i:s', $dateHeure)->format('y-m-d H:i:s');
            if ($mouvement == null) {
                $mouvement = new WrkMouvement();
                $mouvement->setCreatedAt(date('Y-m-d H:i:s'));
            }
            $mouvement->setRefProduit($uniteTracking);
            $mouvement->setType($type);
            $mouvement->setRefEmplacement($refEmplacement);
            $mouvement->setCommentaire($commentaire);
            $mouvement->setGroupe($groupe);
            $mouvement->setHeurePrise($heurePrise);
            $mouvement->setIdUtilisateur($idUtilisateur);
            $mouvement->save();
            return true;
        }
        return false;
    }

    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->getMouvements($request);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_mouvement.xls"');
    }
 public function executeCsv(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportCsv');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->getMouvements($request);

            $this->getResponse()->setContentType('text/csv');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_mouvement.csv"');
    }
    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->getMouvements($request);

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_mouvement.doc"');
    }

    public function executePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = 'true';

        $this->getMouvements($request);
    }

    private function getMouvements(sfWebRequest $request) {
        $this->heureDebut = $request->getParameter('heureDebut', date('d/m/Y') . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');
        $this->emplacement = $request->getParameter('emplacement', '');
        $this->type = $request->getParameter('type', '');
        $this->reference = $request->getParameter('reference', '');

        $this->length = $request->getParameter('length', '');
        $search=$request->getParameter('search', array("value"=>null));
        $this->value = $search['value'];
        $this->start = $request->getParameter('start', '');

        $order = $request->getParameter('order', array(array('order' => null, 'dir' => null)));
        $this->orderCol = $order[0]["column"];
        $this->orderDir = $order[0]["dir"];

       

        $heureDebut = '';
        if ($this->heureDebut != '') {
            $heureDebut = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureDebut)->format('y-m-d H:i:s');
        }
        $heureFin = '';
        if ($this->heureFin != '') {
            $heureFin = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureFin)->format('y-m-d H:i:s');
        }

        list ($this->mouvements, $mvtprise) = WrkMouvementTable::getInstance()->getWrkMouvementFiltrer($heureDebut, $heureFin, $this->type, $this->emplacement, $this->reference, $this->start, $this->length, $this->value, $this->orderCol, $this->orderDir);
        $this->mouvementsTotal = WrkMouvementTable::getInstance()->countWrkMouvementFiltrer($heureDebut, $heureFin, $this->type, $this->emplacement, $this->reference);
        $this->mouvementsFiltrer = WrkMouvementTable::getInstance()->countWrkMouvementFiltrer($heureDebut, $heureFin, $this->type, $this->emplacement, $this->reference, $this->value);


        $this->mvtEnCours = array();
        if ($mvtprise) {
            foreach ($mvtprise as $mvt) {
                $this->mvtEnCours[] = $mvt['id_mouvement'];
            }
        }

        $users = sfGuardUserTable::getInstance()->findAll();
        $this->users = array();
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user->getUsername();
        }
    }

    public function executeExcelAvecDelais(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcelAvecDelais');
        $this->date = date('d/m/Y');
        $this->print = false;
        $this->heureDebut = $request->getParameter('heureDebut', date('d/m/Y') . ' 00:00:00');
        $this->heureFin = $request->getParameter('heureFin', date('d/m/Y') . ' 23:59:59');

        $heureDebut = '';
        if ($this->heureDebut != '') {
            $heureDebut = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureDebut)->format('y-m-d H:i:s');
        }
        $heureFin = '';
        if ($this->heureFin != '') {
            $heureFin = DateTime::createFromFormat('d/m/Y H:i:s', $this->heureFin)->format('y-m-d H:i:s');
        }

        $this->mouvements = WrkMouvementTable::getInstance()->getDelaisPriseDepose($heureDebut, $heureFin);

        $users = sfGuardUserTable::getInstance()->findAll();
        $this->users = array();
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user->getUsername();
        }

        $emplacements = RefEmplacementTable::getInstance()->findAll();
        $this->emplacements = array();
        foreach ($emplacements as $emplacement) {
            $this->emplacements[$emplacement->getCodeEmplacement()] = $emplacement->getLibelle();
        }


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_mouvement.xls"');
    }

}
