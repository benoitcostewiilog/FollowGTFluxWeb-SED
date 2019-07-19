<?php

require_once(dirname(__FILE__) . '/conf.inc.php');
require_once(dirname(__FILE__) . '/Logger.class.php');

class DBGetter {

    //Connexion à la base de données
    private static $db = NULL;

    /**
     * Récupérer les éléments d'une/des colonnes d'une table
     * @param type $tableName Le nom de la table
     * @param type $columnName Le nom des colonnes
     * @param string $caller Le nom de l'appelant (pour log)
     * @param string $sortingColumn Le nom de la colonne de tri
     * @return array(string) Les valeurs de la colonne pour la table demandée
     */
    public static function getColumns($tableName, $columnsName = array(), $caller = NULL, $sortingColumn = 'id', $clauseWhere = NULL) {
        Logger::log("Début de DBGetter::getColumns (appel par $caller)");
        self::configureDB();
        $i = 0;
        $selectClause = '';
        foreach ($columnsName as $column) {
            $col = self::escapeClause($column);
            if ($i == 0) {
                $selectClause.=$col;
            } else {
                $selectClause.=',' . $col;
            }
            $i++;
        }

        if ($clauseWhere) {
            if (substr(trim($clauseWhere), 0, 3) === "AND") {
                $clauseWhere = " WHERE 1=1 " . $clauseWhere;
            }
            $sql = "SELECT $selectClause FROM $tableName " . $clauseWhere . " ORDER BY $sortingColumn";
        } else {
            $sql = "SELECT $selectClause FROM $tableName ORDER BY $sortingColumn";
        }
        $result = mysqli_query(self::$db, $sql);
        $liste = array();
        if ($result) {
            while ($item = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                $liste[] = $item;
            }
        }

        Logger::log("Fin de DBGetter::getColumns (appel par $caller)");
        return $liste;
    }

    /**
     * Récupérer les éléments d'une colonne d'une table
     * @param type $tableName Le nom de la table
     * @param type $columnName Le nom de la colonne
     * @param string $caller Le nom de l'appelant (pour log)
     * @param string $sortingColumn Le nom de la colonne de tri
     * @return array(string) Les valeurs de la colonne pour la table demandée
     */
    public static function getColumn($tableName, $columnName, $caller = NULL, $sortingColumn = 'id', $clauseWhere = NULL) {
        Logger::log("Début de DBGetter::getColumn (appel par $caller)");
        self::configureDB();

        $selectClause = self::escapeClause($columnName);

        if ($clauseWhere) {
            if (substr(trim($clauseWhere), 0, 3) === "AND") {
                $clauseWhere = " WHERE 1=1 " . $clauseWhere;
            }
            $sql = "SELECT $selectClause FROM $tableName " . $clauseWhere . " ORDER BY $sortingColumn";
        } else {
            $sql = "SELECT $selectClause FROM $tableName ORDER BY $sortingColumn";
        }
        $result = mysqli_query(self::$db, $sql);

        $liste = self::getListeFromQueryResult($result, $columnName);

        Logger::log("Fin de DBGetter::getColumn (appel par $caller)");
        return $liste;
    }

    /**
     * Récupérer les éléments d'une colonne d'une table
     * @param type $tableName Le nom de la table
     * @param type $columnName Le nom de la colonne
     * @param string $caller Le nom de l'appelant (pour log)
     * @param string $sortingColumn Le nom de la colonne de tri
     * @param string $whereColumn Colonne où effectuer le where
     * @param string $whereBegin Valeur de départ ou valeur précise si whereEnd = NULL
     * @param string $whereEnd Valeur de fin ou valeur précise si whereBegin = NULL
     * @return array(string) Les valeurs de la colonne pour la table demandée
     */
    public static function getColumnWith($tableName, $columnName, $caller = NULL, $sortingColumn = 'id', $whereColumn = '', $whereBegin = NULL, $whereEnd = NULL) {
        Logger::log("Début de DBGetter::getColumnWith (appel par $caller)");
        if (empty($whereColumn) || (is_null($whereBegin) && is_null($whereEnd))) {
            return self::getColumn($tableName, $columnName, $caller, $sortingColumn);
        }

        self::configureDB();

        $selectClause = self::escapeClause($columnName);
        $whereClause = ' WHERE ' . self::escapeClause($whereColumn);
        if (is_null($whereBegin)) {
            $whereClause .= " = '$whereEnd'";
        } else if (is_null($whereEnd)) {
            $whereClause .= " = '$whereBegin'";
        } else {
            $whereClause .= " BETWEEN '$whereBegin' AND '$whereEnd'";
        }

        $sql = "SELECT $selectClause FROM $tableName $whereClause ORDER BY $sortingColumn";
        $result = mysqli_query(self::$db, $sql);

        $liste = self::getListeFromQueryResult($result, $columnName);

        Logger::log("Fin de DBGetter::getColumnWith (appel par $caller)");
        return $liste;
    }

    /**
     * Récupérer les images d'une colonne d'une table
     * @param type $tableName Le nom de la table
     * @param type $columnName Le nom de la colonne
     * @return array(string) Les valeurs de la colonne pour la table demandée
     */
    public static function getImageColumn($tableName, $columnName, $caller = NULL, $sortingColumn = 'id', $img_dir = NULL) {
        Logger::log("Début de DBGetter::getImageColumn (appel par $caller)");
        global $list;
        $list = self::getColumn($tableName, $columnName, $caller, $sortingColumn);
        global $key;

        if ($img_dir == NULL) {
            $img_dir = IMG_DIR;
        }

        foreach ($list as $key => $val) {
            try {
                if (!empty($val)) {
                    $list[$key] = base64_encode(file_get_contents($img_dir . $val));
                } else {
                    $list[$key] = NULL;
                }
            } catch (ErrorException $e) {
                $list[$key] = NULL;
            }
        }

        Logger::log("Fin de DBGetter::getImageColumn (appel par $caller)");
        return $list;
    }

    /**
     * Rechercher toutes les associations n-n
     * @param string $groupTableName Le nom de la table contenant les identifiants de regroupement
     * @param string $groupColumnName Le nom de la colonne de regroupement
     * @param string $assocTableName Le nom de la table où rechercher
     * @param string $searchedColumnName Le nom de la colonne des éléments attendus
     * @param string $itemsColumnName Le nom de la colonne de tri, si différente de $searchedColumnName
     * @param string $caller Le nom de l'appelant (pour log)
     * @param string $foreignKeyName Le nom de la colonne de regroupement dans la table associative si différent $groupColumnName
     * @return array(string) Un ensemble de couples clé/valeur ou la clé est l'identifiant de l'objet groupant et la valeur un tableau des objets associés au format JSON
     */
    public static function getAssociatedColumn($groupTableName, $groupColumnName, $assocTableName, $searchedColumnName, $itemsColumnName = NULL, $caller = NULL, $foreignKeyName = NULL, $sortingColumn = 'id') {
        Logger::log("Début de DBGetter::getAssociatedColumn (appel par $caller)");
        $groups = self::getColumn($groupTableName, $groupColumnName, $caller, $sortingColumn);

        if (is_null($itemsColumnName)) {
            $itemsColumnName = $searchedColumnName;
        }
        if (is_null($foreignKeyName)) {
            $foreignKeyName = $groupColumnName;
        }

        $list = array();
        $group = NULL;
        $ret = NULL;

        //Préparer la requête et lier les paramètres d'E/S
        $prepared = mysqli_prepare(self::$db, "SELECT $searchedColumnName FROM $assocTableName WHERE $foreignKeyName = ? ORDER BY $foreignKeyName, $itemsColumnName");

        foreach ($groups as $group) {
            //Exécuter la requête
            $prepared->bind_param('i', $group);
            $prepared->execute();
            $prepared->bind_result($ret);
            $subList = array();
            while ($prepared->fetch()) {
                $subList[] = $ret;
            }
            $list["$group"] = json_encode($subList);
        }

        $prepared->close();
        Logger::log("Fin de DBGetter::getAssociatedColumn (appel par $caller)");
        return $list;
    }

    /**
     * Echapper une chaîne pour l'insérer dans une requête SQL
     * @param string $clause La chaîne à échapper
     * @return string La chaîne échappée
     */
    private static function escapeClause($clause) {
        return "`" . mysqli_real_escape_string(mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME), $clause) . "`";
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
     * Enregistrer une fonction sur un serveur SOAP. La fonction à enregistrer doit être définie (avant ou après appel à cette fonction-ci)
     * @param soap_server   $server         L'instance du serveur SOAP prenant l'enregistrement
     * @param string        $wsdlName       Le nom WSDL
     * @param string        $funcName       Le nom de la fonction
     * @param string        $doc            Documentation
     * @param string        $params         Paramètres si présents
     */
    public static function registerGetter(&$server, $wsdlName, $funcName, $doc = '', $params = array()) {
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
