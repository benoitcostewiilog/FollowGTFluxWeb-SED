<?php

require_once(dirname(__FILE__) . '/conf.inc.php');
require_once(dirname(__FILE__) . '/Logger.class.php');

/**
 * Ecrire un tuple en base de données
 *
 * @author Loic
 */
class DBSetter {

    //Connexion à la base de données
    private static $db = NULL;

    /**
     * Insère un élément
     * @param string $tableName Le nom de la table
     * @param string / array $champs Les champs dans lesquels des données seront insérés
     * @param string / array $valeurs Les valeurs à inserer dans les champs
     * @param string $caller Le nom de l'appelant (pour log)
     */
    public static function creerElement($tableName, $champs = array(), $valeurs = array(), $caller = NULL, $img_dir = NULL) {
        Logger::log("Début de DBSetter::creerElement (caller : $caller)");
        self::configureDB();

        if (count($champs) != count($valeurs)) {
            Logger::log("Nombre de champs different du nommbre de valeurs");
            return "Nombre de champs different du nommbre de valeurs";
        }

        foreach ($valeurs as $cle => $valeur) {
            if (preg_match("/^data:/", $valeur) && preg_match("/;base64,/", $valeur)) {
                $valeurs[$cle] = self::enregistreBase64Document($tableName, $champs[$cle], $valeur);
            }
        }

        $sql = "INSERT INTO `$tableName` (`" . implode('`,`', $champs) . "`) VALUES ('" . implode("','", $valeurs) . "');";

        if (!mysqli_query(self::$db, $sql)) {
            Logger::log("Echec de l insertion en base de donnees. Requete : " . $sql);
            return "Echec";
        }

        $lastId = self::$db->insert_id;

        Logger::log("Fin de DBSetter::creerElement (caller : $caller) Dernier id : " . $lastId);
        return $lastId;
    }

    public static function creerElements($tableName, $data = array(), $caller = NULL, $img_dir = NULL) {
        Logger::log("Début de DBSetter::creerElements (caller : $caller)");
        self::configureDB();
        mysqli_autocommit(self::getDB(), false);
        $ids = array();
        foreach ($data as $d) {
            $id = self::creerElement($tableName, $d['champs'], $d['valeurs'], $caller, $img_dir);
            if ($id == 'Echec') {
                return 0;
            }
            $ids[] = $id;
        }
        mysqli_commit(self::getDB());
        mysqli_autocommit(self::getDB(), true);
        Logger::log("Fin de DBSetter::creerElements (caller : $caller)");
        return $ids;
    }

    public static function supprimerElement($tableName, $clauseWhere, $caller = NULL) {
        Logger::log("Début de DBSetter::supprimerElement (caller : $caller)");
        self::configureDB();

        if (substr(trim($clauseWhere), 0, 3) === "AND") {
            $clauseWhere = " WHERE 1=1 " . $clauseWhere;
        }
        $sql = "DELETE FROM `$tableName` " . $clauseWhere . ";";
        
        if (!mysqli_query(self::$db, $sql)) {
            Logger::log("Echec de la suppression en base de donnees. Requete : " . $sql);
            return "Echec";
        }
        Logger::log("Fin de DBSetter::supprimerElement (caller : $caller)");
    }

    /**
     * Met à jour un élément
     * Il récupère aussi le dernier élément inséré dans la table inc_wrk_incident
     * @param string $tableName Le nom de la table
     * @param string / array $champs Les champs dans lesquels des données seront modifiés
     * @param string / array $valeurs Les valeurs à modifier dans les champs
     * @param string / array $champsCondition Les champs sur lesquels seront effectués les conditions
     * @param string / array $valeursCondition Les valeurs des champs pour les conditions
     * @param string $caller Le nom de l'appelant (pour log)
     */
    public static function updateElement($tableName, $champs = NULL, $valeurs = NULL, $champsCondition = "", $valeursCondition = "", $caller = NULL, $img_dir = NULL) {
        Logger::log("Début de DBSetter::updateElement (caller : $caller)");
        self::configureDB();

        if (count($champs) != count($valeurs)) {
            Logger::log("Nombre de champs different du nommbre de valeurs pour les modifications");
            return;
        }

        if (count($champsCondition) != count($valeursCondition)) {
            Logger::log("Nombre de champs different du nommbre de valeurs pour les conditions");
            return;
        }

        $conditions = "";
        $i = 0;
        if (is_array($champsCondition)) {
            while (isset($champsCondition[$i]) && isset($valeursCondition[$i])) {
                if ($i == 0) {
                    $conditions .= " WHERE ";
                } else {
                    $conditions .= " AND ";
                }

                $conditions .= "`" . $champsCondition[$i] . "` LIKE '" . $valeursCondition[$i] . "' ";
                $i++;
            }
        } else {
            if ($champsCondition != "") {
                $conditions = " WHERE `" . $champsCondition . "` = '" . $valeursCondition . "'";
            } else {
                if ($valeursCondition != "") {
                    Logger::log("Champs vide alors que sa valeur est renseignée");
                    return;
                }
            }
        }

        if ($tableName == "inc_wrk_commentaire") {
            if (is_array($champs)) {
                if (array_search("fichier", $champs) !== FALSE) {
                    $position = array_search("fichier", $champs);

                    if ($img_dir == NULL) {
                        $img_dir = IMG_DIR;
                    }

                    $sql = "SELECT fichier FROM $tableName " . $conditions;
                    $result = mysqli_query(self::$db, $sql);
                    if ($result) {
                        $listeFichiers = self::getListeFromQueryResult($result, "fichier");
                        foreach ($listeFichiers as $value) {
                            if (file_exists($img_dir . $value . '.png')) {
                                unlink($img_dir . $value . '.png');
                            }
                        }

                        $nomFichier = self::genereNumFichier("inc_wrk_commentaire", "fichier");
                        $fichier = $valeurs[$position];

                        $valeurs[$position] = $nomFichier;

                        file_put_contents($img_dir . $nomFichier . '.png', base64_decode($fichier));
                    }
                }
            } else {
                if ($champs == "fichier") {
                    if ($img_dir == NULL) {
                        $img_dir = IMG_DIR;
                    }

                    $sql = "SELECT fichier FROM $tableName " . $conditions;
                    $result = mysqli_query(self::$db, $sql);
                    $listeFichiers = self::getListeFromQueryResult($result, "fichier");

                    foreach ($listeFichiers as $value) {
                        if (file_exists($img_dir . $value . '.png')) {
                            unlink($img_dir . $value . '.png');
                        }
                    }

                    $nomFichier = self::genereNumFichier("inc_wrk_commentaire", "fichier");
                    $fichier = $valeurs;
                    $valeurs = $nomFichier;

                    file_put_contents($img_dir . $nomFichier . '.png', base64_decode($fichier));
                }
            }
        }

        $modifs = "";
        $i = 0;

        if (is_array($champs)) {
            foreach ($champs as $cle => $champ) {
                $modifs .= " `" . $champ . "` = '" . $valeurs[$cle] . "', ";
            }
            $modifs = substr($modifs, 0, -1);
        } else {
            if ($champs != "") {
                $modifs = " `" . $champs . "` = '" . $valeurs . "' ";
            } else {
                if ($valeurs != "") {
                    Logger::log("Champs vide alors que sa valeur est renseignée");
                    return;
                } else {
                    Logger::log("Aucune modification a effectuer");
                    return;
                }
            }
        }

        $sql = "UPDATE `$tableName` SET " . $modifs . $conditions;

        if (!mysqli_query(self::$db, $sql)) {
            Logger::log("Echec de l insertion en base de donnees. Requete : " . $sql);
            return;
        }

        Logger::log("Fin de DBSetter::updateElement (caller : $caller)");
    }

    /**
     * Lire le résultat d'une requête
     * @param mysqli $result Le résultat d'une requête
     * @param string $columnName Le nom de la colonne de lecture
     * @return array Un tableau contenant toutes les valeurs de la colonne
     */
    private static function getListeFromQueryResult(&$result, $columnName) {
        $liste = array();
        while ($item = mysqli_fetch_array($result, MYSQL_ASSOC)) {
            $liste[] = ($item[$columnName]);
        }
        return $liste;
    }

    /**
     * Enregistre un champ encodé en base64 dans un fichier
     * @param string $tableName Le nom de la table
     * @param string $champ Le champ concerné
     * @param string $base64Data La donnée encodée
     * @param string $imgDir Le répertoire ou se trouvera le fichier
     * @return string le nom du fichier
     */
    public static function enregistreBase64Document($tableName, $champ, $base64Data, $imgDir = IMG_DIR) {
        $nomFichier = self::genereNumFichier($tableName, $champ);
        $base64Data = explode('base64,', $base64Data);
        file_put_contents($imgDir . $nomFichier . '.png', base64_decode($base64Data[1]));
        return $nomFichier . '.png';
    }

    /**
     * Retourne la plus grande valeur du champ (entier
     * @param string $tableName Le nom de la table
     * @param string $champ Le champ concerné
     * @return int le maximum
     */
    public static function getMaxValue($tableName, $champ) {
        $sql = "SELECT MAX($champ) as max_value FROM $tableName";
        $result = mysqli_query(self::$db, $sql);
        $item = mysqli_fetch_array($result, MYSQL_ASSOC);
        return $item['max_value'];
    }

    /**
     * Gérer la connexion à la BD
     */
    private static function configureDB() {
        if (self::isDbInvalid()) {
            self::$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        }
    }

    /**
     * Vérifier une invalidité de la base de données
     * @return bool true si la connexion n'est pas valide (non définie / serveur injoignable)
     */
    private static function isDbInvalid() {
        return is_null(self::$db);
    }

    /**
     * Obtenir la connexion à la base de données
     * @return mysqli L'objet de connexion à la base de données
     */
    public static function getDB() {
        self::configureDB();
        return self::$db;
    }

    /**
     * Obtenir la connexion à la base de données
     * @return mysqli L'objet de connexion à la base de données
     */
    public static function genereNumFichier($tableName, $champ) {
        $sql = "SELECT MAX($champ) as max FROM $tableName";
        $result = mysqli_query(self::$db, $sql);
        $item = mysqli_fetch_array($result, MYSQL_ASSOC);
        if (substr($item['max'], 0, 6) != date('Ym')) {
            return date('Ym') . '0001';
        } else {
            return $item['max'] + 1;
        }
    }

    /**
     * Enregistrer une fonction sur un serveur SOAP. La fonction à enregistrer doit être définie (avant ou après appel à cette fonction-ci)
     * @param soap_server   $server         L'instance du serveur SOAP prenant l'enregistrement
     * @param string        $wsdlName       Le nom WSDL
     * @param string        $funcName       Le nom de la fonction
     * @param string        $doc            Documentation
     * @param string        $params         Paramètres si présents
     */
    public static function registerSetter(&$server, $wsdlName, $funcName, $doc = '', $params = array()) {
        $namespace = (defined('NAMESP') ? NAMESP : 'urn') . ':' . $wsdlName;
        $soapAction = $namespace . "#$funcName";
        $server->register($funcName, // method name
                $params, // input parameters
                array('return' => 'xsd:string'), // output parameters
                $namespace, // namespace
                $soapAction, // soapaction
                'rpc', // style
                'encoded', // use
                $doc            // documentation
        );
    }

}
