<?php

/**
 * statistiques actions.
 *
 * @package    MobileStockV3
 * @subpackage statistiques
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statistiquesActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $dateDebut = date('d/m/Y'). " 00:00:00";
        $dateFin = date('d/m/Y'). " 23:59:59";


        $this->heureDebut = $dateDebut . " 00:00:00";
        $this->heureFin = $dateFin . " 23:59:59";

        $dateDebut = DateTime::createFromFormat('d/m/Y H:i:s', $dateDebut)->format('Y-m-d');
        $dateFin = DateTime::createFromFormat('d/m/Y H:i:s', $dateFin)->format('Y-m-d');

        $dateDebut .= " 00:00:00";
        $dateFin .= " 23:59:59";

        //Statistiques::majKpiRetard($dateDebut, $dateFin);

        $con = Doctrine_Manager::getInstance()->connection();
        $requete = "SELECT * FROM exp_kpi_retard WHERE date_reception BETWEEN '" . $dateDebut . "' AND '" . $dateFin . "' ORDER BY date_reception ASC";
        $st = $con->execute($requete);
        $this->resultats = $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Recalcul en live les KPI en fonction d'une plage de date */

    public function executeGetStat(sfWebRequest $request) {

        $dateDebut = $request->getParameter('dateDebut', date('d/m/Y'));
        $dateFin = $request->getParameter('dateFin', date('d/m/Y'));

        $this->heureDebut = $dateDebut . " 00:00:00";
        $this->heureFin = $dateFin . " 23:59:59";
        
        $dateDebut = DateTime::createFromFormat('d/m/Y H:i:s', $dateDebut)->format('Y-m-d');
        $dateFin = DateTime::createFromFormat('d/m/Y H:i:s', $dateFin)->format('Y-m-d');

        $dateDebut .= " 00:00:00";
        $dateFin .= " 23:59:59";

        //Statistiques::majKpiRetard($dateDebut, $dateFin);

        $con = Doctrine_Manager::getInstance()->connection();
        $requete = "SELECT * FROM exp_kpi_retard WHERE date_reception BETWEEN '" . $dateDebut . "' AND '" . $dateFin . "' ORDER BY date_reception ASC";
        $st = $con->execute($requete);
        $this->resultats = $st->fetchAll(PDO::FETCH_ASSOC);


        $this->setTemplate('index');
    }
    
        public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('exportExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        $dateDebut = $request->getParameter('dateDebut', date('d/m/Y'));
        $dateFin = $request->getParameter('dateFin', date('d/m/Y'));

        $this->heureDebut = $dateDebut . " 00:00:00";
        $this->heureFin = $dateFin . " 23:59:59";

      $dateDebutFormat = DateTime::createFromFormat('d/m/Y H:i:s', $dateDebut);
        if($dateDebutFormat){
        $dateDebut = $dateDebutFormat->format('Y-m-d');
        }else{
            $dateDebut =date('Y-m-d');
        }
        
        $dateFinFormat=DateTime::createFromFormat('d/m/Y H:i:s', $dateFin);
          if($dateFinFormat){
        $dateFin = $dateFinFormat->format('Y-m-d');
   }else{
            $dateDebut =date('Y-m-d');
        }

        $dateDebut .= " 00:00:00";
        $dateFin .= " 23:59:59";

        //Statistiques::majKpiRetard($dateDebut, $dateFin);

        $con = Doctrine_Manager::getInstance()->connection();
        $requete = "SELECT * FROM exp_kpi_retard WHERE date_reception BETWEEN '" . $dateDebut . "' AND '" . $dateFin . "' ORDER BY date_reception ASC";
        $st = $con->execute($requete);
        $this->resultats = $st->fetchAll(PDO::FETCH_ASSOC);

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_mouvement.xls"');
    }

}
