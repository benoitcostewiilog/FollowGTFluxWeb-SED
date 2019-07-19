<?php

/**
 * acceuil actions.
 *
 * @package    
 * @subpackage acceuil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class acceuilActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        //redirection automatique vers l'url comportant l'i18n
        if (!$request->getParameter('sf_culture')) {
            if ($this->getUser()->isFirstRequest()) {
                $culture = "fr";
                $this->getUser()->setCulture($culture);
                $this->getUser()->isFirstRequest(false);
            } else {
                $culture = $this->getUser()->getCulture();
            }
            $this->redirect('@localized_homepage');
        }

        $this->initWidgets();
    }

    public function executeProduitRetardAjax() {
        $produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardAvecHoraire(-900);
        return $this->renderPartial('listRetard', array("produitEnRetard" => $produitEnRetard));
    }
      public function executeArrivageRetardAjax() {
          $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $produitEnRetard = WrkMouvementTable::getInstance()->getArrivageEnRetard($dateDebutStats, $dateFinStats,-1200);
        return $this->renderPartial('listRetard', array("produitEnRetard" => $produitEnRetard));
    }
    
          public function executeDeposeRetardAjax() {
          $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardDeuxiemeDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats,-1200);
        return $this->renderPartial('listdeposeRetard', array("produitEnRetard" => $produitEnRetard));
    }
    
           public function executeReceptionRetardAjax() {
          $d = new DateTime();
        $d->modify('-4 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $produitEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardPremiereDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats,-1200);
        return $this->renderPartial('listRetardReception', array("produitEnRetard" => $produitEnRetard));
    }
    
      public function executeEncoursAjax(sfWebRequest $request) {
            $emplacement = $request->getParameter('emplacement');
          $time = strtotime('now  -15 days');
   
        $heureDebut = date("Y-m-d", $time) . ' 00:00:00';
    
        $mouvements = WrkMouvementTable::getInstance()->getDeposeEmplacementDelais($heureDebut,$emplacement);
        return $this->renderPartial('encours', array("mouvements" => $mouvements));
    }
    

    //User Mono-connexion : Contrôle de la clé d'authentification
    public function executeAjaxControleKey(sfWebRequest $request) {
        //Pas de contrôle si on est superAdmin
        if ($this->getUser()->getGuardUser()->getGroup() == 'Super-Administrateur') {
            return $this->renderText("ok");
            
        }
        //On récup la clé en cookie et la clé en bdd
        $key = $this->getUser()->getAttribute('AuthenticationKey');
        $baseKey = $this->getUser()->getGuardUser()->getAuthenticationKey();
        //Si <> on déconnecte.
        if ($key != $baseKey) {
            return $this->renderText("nok");
        } else {
            return $this->renderText($key);
        }
    }

    //Permet de recharger les statistiques lorsque l'on change d'annee
    public function executeReloadStats(sfWebRequest $request) {
        $annee = $request->getParameter('annee', date('Y'));
        $mois = $request->getParameter('mois', date('m'));
        $jour = $request->getParameter('jour', "01");
        $type = $request->getParameter('type', '');

        $nbDayInMonth=cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

        if ($jour > $nbDayInMonth) {
            $jour = "01";
            $mois++;
        } else {
        
            if ($jour <= 0) {
                $mois--;
                $nbDayInMonth=cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
                $jour = "".$nbDayInMonth;
               
            } else if ($jour < 10 && strlen($jour) < 2) {
                $jour = '0' . $jour;
            }
        }

        if ($mois > 12) {
            $mois = '01';
            $annee++;
        } else {
            if ($mois <= 0) {
                $mois = '12';
                $jour ="31";
                $annee--;
            } else if ($mois < 10) {
                $mois = '0' . $mois;
            }
        }


        $d = new DateTime($annee . '-' . $mois . '-'.$jour);
    
        $dateFinStats = $d->format('Y-m-d') . "23:59:59";

    
   
        $d->modify('-9 day');

        $dateDebutStats = $d->format('Y-m-d');

        if ($type === 'arrivage' || $type == 'volumetrie-arrivage') {
            $nbColisArrivageParMois = WrkMouvementTable::getInstance()->getNbColisArrivageParJours($dateDebutStats, $dateFinStats);
            $nbColisArrivageReceptionnerParMois = WrkMouvementTable::getInstance()->getNbColisArrivageReceptionneParJours($dateDebutStats, $dateFinStats);
            if ($type === 'arrivage') {
                return $this->renderPartial('nbColisParMois', array('nbColisParMois' => $nbColisArrivageParMois, 'titre' => 'Arrivages (UM)', 'id' => 'arrivage', 'nbColisSeries2' => $nbColisArrivageReceptionnerParMois, 'annee' => $annee, 'mois' => $mois, 'labels' => array("Arrivage", "Réceptionné")));
            } else {
                return $this->renderPartial('volumetrieArrivageJour', array('nbArrivage' => $nbColisArrivageParMois, 'nbReceptionne' => $nbColisArrivageReceptionnerParMois, 'annee' => $annee, 'mois' => $mois, "jour" => $jour));
            }
        } else if ($type === 'reception') {
            $nbColisReceptionParMois = WrkMouvementTable::getInstance()->getNbColisReceptionParJours($dateDebutStats, $dateFinStats);
            return $this->renderPartial('nbColisParJour', array('nbColisParMois' => $nbColisReceptionParMois, 'titre' => 'Arrivages', 'id' => 'reception', 'annee' => $annee, 'mois' => $mois, "jour" => $jour));
        } else if ($type === 'schemaReception') {
            $d = new DateTime($annee . '-' . $mois . '-'.$jour);
            $dateDebutStats = $d->format('Y-m-d');
           
            
            
            $nbArrivage = WrkMouvementTable::getInstance()->getArrivage($dateDebutStats, $dateFinStats);
            $nbArrivageEnAttente = WrkMouvementTable::getInstance()->getArrivageEnAttente($dateDebutStats, $dateFinStats);
            $arrivageEnRetard = WrkMouvementTable::getInstance()->getArrivageEnRetard($dateDebutStats, $dateFinStats);
            $nbReceptionNonAchemine = WrkMouvementTable::getInstance()->getReceptionNonAchemine($dateDebutStats, $dateFinStats);
            $receptionEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardPremiereDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats);
            $deposeEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardDeuxiemeDAvecHoraireEtArrivage($dateDebutStats, $dateFinStats);
            return $this->renderPartial('schemaReceptionParJour', array('nbArrivage' => $nbArrivage, 'nbArrivageEnAttente' => $nbArrivageEnAttente,'arrivageEnRetard'=>$arrivageEnRetard, 'nbReceptionNonAchemine' => $nbReceptionNonAchemine, 'receptionEnRetard' => $receptionEnRetard,'deposeEnRetard'=>$deposeEnRetard, 'annee' => $annee, 'mois' => $mois, 'jour' => $jour));
        }
    }

    public function executeListRetardExcel() {
        $this->setLayout(false);
        $this->setTemplate('exportListRetardExcel');
        $this->date = date('d/m/Y');
        $this->print = false;

        list($this->uniteTracking, $this->dateDebut, $this->dateFin) = $this->getDelaisReceptionUniteTracking();

        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard.xls"');
    }

    public function executeListRetardWord() {
        $this->setLayout(false);
        $this->setTemplate('exportListRetard');
        $this->date = date('d/m/Y');
        $this->print = false;


        list($this->uniteTracking, $this->dateDebut, $this->dateFin) = $this->getDelaisReceptionUniteTracking();

        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export_retard.doc"');
    }

    public function executeListRetardPrint() {
        $this->setLayout(false);
        $this->setTemplate('exportListRetard');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
        $this->print = true;

        list($this->uniteTracking, $this->dateDebut, $this->dateFin) = $this->getDelaisReceptionUniteTracking();
    }

    private function getDelaisReceptionUniteTracking() {
		$d = new DateTime();
         $d->modify('-15 days');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . ' 23:59:59';
        return array(WrkMouvementTable::getInstance()->getDelaisReceptionUniteTracking($dateDebutStats, $dateFinStats), $dateDebutStats, $dateFinStats);
    }

//Initialise les widgets de la page d'acceuil
    private function initWidgets() {
        $idGroups = $this->getUser()->getGuardUser()->getGroups()->toKeyValueArray('id', 'id');
        $this->widgets = RefWidgetTable::getInstance()->getWidgetWithGroupId($idGroups);

  
        $d = new DateTime($dateDebutStats);
        $d->modify('-9 day');
        $dateDebutStats = $d->format('Y-m-d');
        $d = new DateTime();
        $dateFinStats = $d->format('Y-m-d') . " 23:59:59";
        $t = new DateTime();
        $t->modify('-3 days');
        $dateLimit3 = $t->format('Y-m-d H:i:s');
        $this->annee = date('Y');
        $this->mois = date('m');
        $this->jour = date('d');

        foreach ($this->widgets as $widget) {
            switch ($widget) {
                case "Arrivages (UM)":
                    $this->nbColisArrivageParMois = WrkMouvementTable::getInstance()->getNbColisArrivageParJours($dateDebutStats, $dateFinStats);
                    $this->nbColisArrivageReceptionnerParMois = WrkMouvementTable::getInstance()->getNbColisArrivageReceptionneParJours($dateDebutStats, $dateFinStats);
                    break;
                case "Réceptions (UM)":
                    $this->nbColisReceptionParMois = WrkMouvementTable::getInstance()->getNbColisReceptionParJours($dateDebutStats, $dateFinStats);
                    break;
                case "Unités de tracking en retard":
                    $this->produitEnRetard = array(); //chargement ajax
                    break;
                case "Processus de réception":
                    $dateDebutStatsSchemaRecept = $d->format('Y-m-d') . " 00:00:00";
                    $this->nbArrivage = WrkMouvementTable::getInstance()->getArrivage($dateDebutStatsSchemaRecept, $dateFinStats);
                    $this->nbArrivageEnAttente = WrkMouvementTable::getInstance()->getArrivageEnAttente($dateDebutStatsSchemaRecept, $dateFinStats);
                    $this->arrivageEnRetard = WrkMouvementTable::getInstance()->getArrivageEnRetard($dateDebutStatsSchemaRecept, $dateFinStats);
                    $this->nbReceptionNonAchemine = WrkMouvementTable::getInstance()->getReceptionNonAchemine($dateDebutStatsSchemaRecept, $dateFinStats);
                    $this->receptionEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardPremiereDAvecHoraireEtArrivage($dateDebutStatsSchemaRecept, $dateFinStats);
                     $this->deposeEnRetard = WrkMouvementTable::getInstance()->getProduitEnRetardDeuxiemeDAvecHoraireEtArrivage($dateDebutStatsSchemaRecept, $dateFinStats);
           
                    break;
                case "Arrivages en retard":
                    $this->listeArrivage = WrkMouvementTable::getInstance()->getArrivageRetard($dateLimit3, $dateFinStats);
                    break;
                case "Réception en retard":
                    $this->listeReception = WrkMouvementTable::getInstance()->getReceptionRetard($dateLimit3, $dateFinStats);
                    break;
                case "Dépose en retard":
                    $this->listeDepose = WrkMouvementTable::getInstance()->getDeposeRetard($dateLimit3, $dateFinStats);
                    break;
                    
            }
        }
    }

}
