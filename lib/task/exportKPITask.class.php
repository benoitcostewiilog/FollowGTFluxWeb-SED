<?php

class exportKPITask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    $this->addArguments(array( new sfCommandArgument('date_deb', sfCommandArgument::REQUIRED, 'Date de debut'), 
                               new sfCommandArgument('date_fin', sfCommandArgument::REQUIRED, 'Date de fin')));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'MobileStockV3'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'exportKPI';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [exportKPI|INFO] task does things.
Call it with:

  [php symfony exportKPI|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $debut = microtime(true);
    
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    //creer une 2ieme connection pr le lien vers la base pr les fonctions mysql
    //Variables BDD dédie
	$host = "localhost";
	$user = "usrgttest";
	$password = "ZVKG8pmhvPyxDPtS";
	$bdd = "gt_log_test";
    $link = mysql_connect($host,$user,$password);
	mysql_select_db($bdd);

    echo "Connexion à la base \n";
	echo "\r\n";
	
    $con = Doctrine_Manager::getInstance()->connection();
    
	echo "Truncate \n";
	echo "\r\n";
	
    // Vidage de la table tampon
    $req = $con->execute("TRUNCATE TABLE exp_kpi ");
    
	echo "Unité BR_SAP date rec \n";
	echo "\r\n";
    // Ajout unite, br_sap, date_reception
	$req = $con->execute("INSERT INTO exp_kpi (unite_tracking, br_sap, date_reception)
                                SELECT ref_produit, br_sap, created_at
                                FROM wrk_mouvement
                                WHERE wrk_mouvement.created_at < '".$arguments['date_fin']."%'
                                AND wrk_mouvement.created_at > '".$arguments['date_deb']." 00:00:00'	
                                AND wrk_mouvement.code_emplacement = 'Réception'");
    
	echo "Arrivage \n";
	echo "\r\n";
    // Arrivage
    $req = $con->execute("UPDATE exp_kpi ek, wrk_arrivage_produit wap 
                          SET ek.date_arrivage = wap.created_at
                          WHERE wap.ref_produit = ek.br_sap
                          AND ek.br_sap <> 'Absent'
                          AND wap.br_sap IS NULL");
    
    // Dépose
    $req = $con->execute("UPDATE exp_kpi ek SET ek.date_depose = 
                        (
                            SELECT wm.heure_prise
                            FROM wrk_mouvement wm
                            WHERE wm.ref_produit = ek.unite_tracking
                            AND wm.type = 'depose'
                            AND wm.code_emplacement <> 'Réception'
                            ORDER BY wm.created_at DESC
                            LIMIT 1
                        )");
    
    // Flux 1
    $req = $con->execute("UPDATE exp_kpi
                          SET flux_1 = CASE 
                            WHEN date_arrivage IS NULL THEN '0'
                            ELSE '1'
                          END");
    
    // Flux 2
    $req = $con->execute("UPDATE exp_kpi
                          SET flux_2 = CASE 
                            WHEN date_depose IS NULL THEN '0'
                            ELSE '1'
                          END");
    
    
    // Flux complet
    $req = $con->execute("UPDATE exp_kpi
                          SET flux_complet = CASE 
                            WHEN (flux_1 = 1 AND flux_2 = 1) THEN '1'
                            ELSE '0'
                          END");	
    
    // Jour ouvrés Flux 1
    $req = $con->execute("UPDATE exp_kpi SET nb_jo_1 = ( DATEDIFF( date_reception, date_arrivage ) - ( WEEK( date_reception ) - WEEK( date_arrivage ) ) *2 ) +1 ");
    
    // Jour ouvrés Flux 2
    $req = $con->execute("UPDATE exp_kpi SET nb_jo_2 = ( DATEDIFF( date_depose, date_reception ) - ( WEEK( date_depose ) - WEEK( date_reception ) ) *2 ) +1 ");
   
    // Délais 1
    $req = $con->execute ("SELECT * FROM exp_kpi WHERE date_arrivage IS NOT NULL");
    $listeUnite = $req->fetchAll(PDO::FETCH_ASSOC);
    
    $nbUnit = sizeof($listeUnite);
    
    for($i=0; $i < $nbUnit; $i++){
        
        // maj des délais 
        $req = $con->execute("SELECT `WORKDAY_TIME_DIFF_HOLIDAY_TABLE` ('ALL', '".$listeUnite[$i]["date_arrivage"]."', '".$listeUnite[$i]["date_reception"]."', '07:00', '17:00') /60 AS delai");
        $delai = $req->fetchAll(PDO::FETCH_ASSOC);
        
        $delai = $delai[0]["delai"];
        list($heure, $minute) = explode('.', $delai);
        $minute = '0.'.$minute;
        $minute = $minute * 60;
        $buffMinute = substr($minute, 0,2);
        if (substr($buffMinute, -1, 1) == '.'){
            $minute = '0'.substr($buffMinute, 0, 1);
        }
        $delai = $heure . ':' . substr($minute, 0,2);
        $req = $con->execute("UPDATE exp_kpi SET delai_1 = '".$delai."' WHERE unite_tracking = '".mysql_real_escape_string($listeUnite[$i]["unite_tracking"])."' ");
        
    }
    
    // Délais 2
    $req = $con->execute ("SELECT * FROM exp_kpi WHERE date_depose IS NOT NULL");
    $listeUnite = $req->fetchAll(PDO::FETCH_ASSOC);
    
    $nbUnit = sizeof($listeUnite);
    
    for($i=0; $i < $nbUnit; $i++){
        
        // maj des délais 
        $req = $con->execute("SELECT `WORKDAY_TIME_DIFF_HOLIDAY_TABLE` ('ALL', '".$listeUnite[$i]["date_reception"]."', '".$listeUnite[$i]["date_depose"]."', '07:00', '17:00') /60 AS delai");
        $delai = $req->fetchAll(PDO::FETCH_ASSOC);
        
        $delai = $delai[0]["delai"];
        list($heure, $minute) = explode('.', $delai);
        $minute = '0.'.$minute;
        $minute = $minute * 60;
        $buffMinute = substr($minute, 0,2);
        if (substr($buffMinute, -1, 1) == '.'){
            $minute = '0'.substr($buffMinute, 0, 1);
        }
        $delai = $heure . ':' . substr($minute, 0,2);
        $req = $con->execute("UPDATE exp_kpi SET delai_2 = '".$delai."' WHERE unite_tracking = '".mysql_real_escape_string($listeUnite[$i]["unite_tracking"])."' ");
        
    }
    
    // Delais total
    $req = $con->execute ("UPDATE exp_kpi SET delai_total = ADDTIME( delai_1, delai_2 ) WHERE flux_complet = 1");
    
    
    // Prochain jour ouvré
    $req = $con->execute ("UPDATE exp_kpi INNER JOIN (SELECT unite_tracking AS UNIT,
								  @refday := date_reception, 
								  @dow := (DAYOFWEEK( @refday )-1) AS DOW,
								  @subtract := IF( @dow =6, 2, IF( @dow =5, 3, 1 ) ) AS MINUS,
								  @refday + INTERVAL @subtract DAY AS NextJO 
								  FROM exp_kpi) BUFF
                            ON exp_kpi.unite_tracking = UNIT
                            SET prochain_jo = NextJO;");
    
    $fin=microtime(true);
	$duree=$fin-$debut;
	$duree=SUBSTR($duree, 0, 4);
    
	echo "Duree du script : ".$duree." secondes \n";
	echo "\r\n";
  }
}
