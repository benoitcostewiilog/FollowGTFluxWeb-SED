<?php

class RefFerieTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object RefFerieTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('RefFerie');
    }

    public function getAllFerie() {
        $req = Doctrine_Query::CREATE()->from('RefFerie')
                ->orderBy('date');
        return $req->execute();
    }

    public function addFerie($date, $lib) {
        $connection = Doctrine_Manager::connection();
        $libSlash = addslashes($lib);
        $query = "INSERT INTO ref_ferie (date, libelle) VALUES ('$date', '$libSlash');";
        $statement = $connection->execute($query);
    }

    public function truncateFerie() {
        $connection = Doctrine_Manager::connection();
        $query = "TRUNCATE ref_ferie";
        $statement = $connection->execute($query);
    }

    public function getFerieWithAnnee($annee) {
        $req = Doctrine_Query::CREATE()->from('RefFerie')
                ->where('YEAR(date) = ?', $annee);
        return $req->execute();
    }

    public function getFeriesArrayUnique() {
        $feries = $this->getAllFerie();
        $feriesArray = array();
        foreach ($feries as $ferie) {
            $feriesArray[$ferie->getDate()] = $ferie->getDate();
        }
        return $feriesArray;
    }

}
