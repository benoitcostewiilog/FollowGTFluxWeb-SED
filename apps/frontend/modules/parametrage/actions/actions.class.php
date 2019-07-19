<?php

/**
 * config actions.
 *
 * @subpackage parametrage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class parametrageActions extends sfActions {

    // Action permettant de charger les configuration
    public function executeIndex(sfWebRequest $request) {
        $this->feries = Doctrine::getTable('RefFerie')->getAllFerie();
        $this->horaires = Doctrine::getTable('RefHoraire')->findAll();
    }

    public function executeListFeriesAjax(sfWebRequest $request) {
        $feries = Doctrine::getTable('RefFerie')->getAllFerie();
        return $this->renderPartial("listFeries", array("feries" => $feries));
    }

    public function executeListHorairesAjax(sfWebRequest $request) {
        $horaires = Doctrine::getTable('RefHoraire')->findAll();
        return $this->renderPartial("listHoraires", array("horaires" => $horaires));
    }

    public function executeAddFeries(sfWebRequest $request) {
        $annee = $request->getPostParameter('annee');
        $feries = $this->getHolidays($annee);

        $collectionFeries = new Doctrine_Collection("RefFerie");

        foreach ($feries as $unFerie) {
            $ferie = new RefFerie();
            $ferie->setLibelle($unFerie[1]);
            $ferie->setDate(date("Y-m-d", $unFerie[0]));

            $collectionFeries->add($ferie);
        }
        $collectionFeries->save();

        $listeFerie = '';
        foreach ($collectionFeries as $ferie) {
            $listeFerie = $listeFerie . '|' . date('d/m/Y', $ferie->getDate()) . ';' . $ferie->getLibelle();
        }
        return $this->renderText($listeFerie);
    }

    public function executeAddJour(sfWebRequest $request) {
        $libelle = $request->getPostParameter('libelle');
        $date = $request->getPostParameter('date');
        $date = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        $ferie = new RefFerie();
        $ferie->setLibelle($libelle);
        $ferie->setDate($date);
        $ferie->save();

        return $this->renderText("ok");
    }

    public function executeRemoveJourFeries(sfWebRequest $request) {
        $idFeries = $request->getPostParameter('id');

        $feries = RefFerieTable::getInstance()->find($idFeries);
        $feries->delete();

        return $this->renderText("ok");
    }

    function getHolidays($year = null) {
        if ($year === null) {
            $year = intval(date('Y'));
        }

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = array(
            // Dates fixes
            array(mktime(0, 0, 0, 1, 1, $year), '1er Janvier'), // 1er janvier
            array(mktime(0, 0, 0, 5, 1, $year), 'Fête du travail'), // Fête du travail
            array(mktime(0, 0, 0, 5, 8, $year), '8 Mai 1945'), // Victoire des alliés
            array(mktime(0, 0, 0, 7, 14, $year), 'Fête Nationale'), // Fête nationale
            array(mktime(0, 0, 0, 8, 15, $year), 'Assomption'), // Assomption
            array(mktime(0, 0, 0, 11, 1, $year), 'La Toussaint'), // Toussaint
            array(mktime(0, 0, 0, 11, 11, $year), 'Armistice'), // Armistice
            array(mktime(0, 0, 0, 12, 25, $year), 'Noël'), // Noel
            // Dates variables
            array(mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear), 'Lundi de Pâques'),
            array(mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear), 'Jeudi de l\'Ascension'),
            array(mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), 'Lundi de Pentecôte'),
        );

        sort($holidays);

        return $holidays;
    }

    public function executeUpdateHoraire(sfWebRequest $request) {
        $jours = $request->getParameter('jour');
        $debut = $request->getParameter('debut');
        $fin = $request->getParameter('fin');

        foreach ($jours as $jour) {
            $horaire = new RefHoraire();
            $horaire->setJour($jour);
            $horaire->setCreatedAt(date("Y-m-d H:i:s"));
            $horaire->setFermer(0);
            $horaire->setHeureDebut($debut);
            $horaire->setHeureFin($fin);
            $horaire->save();
        }

        return $this->renderText("ok");
    }

    public function executeRemoveHoraire(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $horaire = RefHoraireTable::getInstance()->find($id);
        $horaire->delete();
        return $this->renderText("ok");
    }

    public function executeRemoveAllHoraire(sfWebRequest $request) {
        $horaires = RefHoraireTable::getInstance()->findAll();
        $horaires->delete();
        return $this->renderText("ok");
    }

}
