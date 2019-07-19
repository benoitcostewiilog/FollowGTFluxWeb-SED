<?php

/**
 * statistiques actions.
 *
 * @package    MobileStockV3
 * @subpackage statistiques
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statistiquesGlobaleActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeExport(sfWebRequest $request) {
        $type = $request->getParameter("type");
        $list = $request->getParameter("list");

        if ($list == "tracking") {
            if ($type == "excel") {
                $this->executeListRetardExcel();
            } else if ($type == "word") {
                $this->executeListRetardWord();
            } else if ($type == "print") {
                $this->executeListRetardPrint();
            }
        } else if ($list == "arrivage") {
            if ($type == "excel") {
                $this->executeListArrivageExcel();
            } else if ($type == "word") {
                $this->executeListArrivageWord();
            } else if ($type == "print") {
                $this->executeListArrivagePrint();
            }
        } else if ($list == "reception") {
            if ($type == "excel") {
                $this->executeListReceptionExcel();
            } else if ($type == "word") {
                $this->executeListReceptionWord();
            } else if ($type == "print") {
                $this->executeListReceptionPrint();
            }
        } else if ($list == "depose") {
            if ($type == "excel") {
                $this->executeListDeposeExcel();
            } else if ($type == "word") {
                $this->executeListDeposeWord();
            } else if ($type == "print") {
                $this->executeListDeposePrint();
            }
        }
    }

    public function executeListRetardExcel() {
        $this->setLayout(false);
        $this->setTemplate('exportListRetardExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardAvecHoraire(-900);


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard.xls"');
    }

    public function executeListRetardWord() {
        $this->setLayout(false);
        $this->setTemplate('exportListRetard');
        $this->date = date('d/m/Y');
        $this->print = false;


        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardAvecHoraire(-900);


        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard.doc"');
    }

    public function executeListRetardPrint() {
        $this->setLayout(false);
        $this->setTemplate('exportListRetard');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = true;

        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardAvecHoraire(-900);
    }

    public function executeListArrivageExcel() {
        $this->setLayout(false);
        $this->setTemplate('exportListArrivageExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getArrivageEnRetard($dateDebutStats, $dateFinStats, -1200);


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard_arrivage.xls"');
    }

    public function executeListArrivageWord() {
        $this->setLayout(false);
        $this->setTemplate('exportListArrivage');
        $this->date = date('d/m/Y');
        $this->print = false;


        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getArrivageEnRetard($dateDebutStats, $dateFinStats, -1200);


        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard_arrivage.doc"');
    }

    public function executeListArrivagePrint() {
        $this->setLayout(false);
        $this->setTemplate('exportListArrivage');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = true;

        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getArrivageEnRetard($dateDebutStats, $dateFinStats, -1200);
    }

    public function executeListReceptionExcel() {
        $this->setLayout(false);
        $this->setTemplate('exportListReceptionExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardPremiereDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats, -1200);


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard_reception.xls"');
    }

    public function executeListReceptionWord() {
        $this->setLayout(false);
        $this->setTemplate('exportListReception');
        $this->date = date('d/m/Y');
        $this->print = false;


        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardPremiereDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats, -1200);


        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard_reception.doc"');
    }

    public function executeListReceptionPrint() {
        $this->setLayout(false);
        $this->setTemplate('exportListReception');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = true;

        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardPremiereDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats, -1200);
    }

    public function executeListDeposeExcel() {
        $this->setLayout(false);
        $this->setTemplate('exportListDeposeExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardDeuxiemeDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats, -1200);


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard_depose.xls"');
    }

    public function executeListDeposeWord() {
        $this->setLayout(false);
        $this->setTemplate('exportListDepose');
        $this->date = date('d/m/Y');
        $this->print = false;
        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardDeuxiemeDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats, -1200);


        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard_depose.doc"');
    }

    public function executeListDeposePrint() {
        $this->setLayout(false);
        $this->setTemplate('exportListDepose');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = true;

        $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $this->produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardDeuxiemeDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats, -1200);
    }

}
