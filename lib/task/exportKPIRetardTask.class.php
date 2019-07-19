<?php

class exportKPIRetardTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array( new sfCommandArgument('date_deb', sfCommandArgument::REQUIRED, 'Date de debut'), 
                               new sfCommandArgument('date_fin', sfCommandArgument::REQUIRED, 'Date de fin')));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'MobileStockV3'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'exportKPIRetard';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [exportKPIRetard|INFO] task does things.
Call it with:

  [php symfony exportKPIRetard|INFO]
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

    
    $con = Doctrine_Manager::getInstance()->connection();
    
    $dateDebut = $arguments['date_deb']." 00:00:00";
    $dateFin   = $arguments['date_fin']." 23:59:59";
    
    
    // Vidage de la table tampon
    //$req = $con->execute("TRUNCATE TABLE exp_kpi_retard ");

    // Ajout unite, br_sap, date_reception
    $req = $con->execute("REPLACE INTO exp_kpi_retard (unite_tracking, num_arrivage, date_reception)
                                (SELECT ref_produit, br_sap, created_at
                                FROM wrk_mouvement
                                WHERE wrk_mouvement.created_at < '".$dateFin."'
                                AND wrk_mouvement.created_at > '".$dateDebut."'	
                                AND wrk_mouvement.code_emplacement = 'Réception')");

    // Arrivage
    $req = $con->execute("UPDATE exp_kpi_retard ek, wrk_arrivage_produit wap 
                          SET ek.date_arrivage = wap.created_at
                          WHERE wap.ref_produit = ek.num_arrivage
                          AND ek.num_arrivage <> 'Absent'
                          AND wap.br_sap IS NULL");
    
    // Zone Attente apres arrivage
    $req = $con->execute("UPDATE exp_kpi_retard ek SET ek.zone_attente1 = (SELECT wm.code_emplacement
                                                                           FROM wrk_mouvement wm
                                                                           WHERE wm.ref_produit = ek.num_arrivage
                                                                           AND wm.type = 'depose'
                                                                           ORDER BY wm.created_at ASC
                                                                           LIMIT 1 ),
                                                       ek.date_attente1 = (SELECT wm.heure_prise
                                                                           FROM wrk_mouvement wm
                                                                           WHERE wm.ref_produit = ek.num_arrivage
                                                                           AND wm.type = 'depose'
                                                                           ORDER BY wm.created_at ASC
                                                                           LIMIT 1 ) 
                          WHERE ek.zone_attente1 IS NULL ");
    
    // Zone attente aprés réception
    $req = $con->execute("UPDATE exp_kpi_retard ek SET ek.zone_attente2 = (SELECT wm.code_emplacement
                                                                        FROM wrk_mouvement wm
                                                                        WHERE wm.ref_produit = ek.unite_tracking
                                                                        AND wm.type = 'depose'
                                                                        AND wm.code_emplacement LIKE 'Attente%'
                                                                        ORDER BY wm.created_at ASC
                                                                        LIMIT 1 ),
                                                      ek.date_attente2 = (SELECT wm.heure_prise
                                                                        FROM wrk_mouvement wm
                                                                        WHERE wm.ref_produit = ek.unite_tracking
                                                                        AND wm.type = 'depose'
                                                                        AND wm.code_emplacement LIKE 'Attente%'
                                                                        ORDER BY wm.created_at ASC
                                                                        LIMIT 1 ); 
                           WHERE ek.zone_attente2 IS NULL ");
    
    
    
    // 1ere Dépose
    $req = $con->execute("UPDATE exp_kpi_retard ek SET ek.date_depose = (
															SELECT wm.heure_prise
															FROM wrk_mouvement wm
															WHERE wm.ref_produit = ek.unite_tracking
															AND wm.type = 'depose'
															AND wm.code_emplacement <> 'Réception'
                                                            AND wm.code_emplacement NOT LIKE 'Attente%'
															ORDER BY wm.created_at ASC
															LIMIT 1 ),
													   ek.zone_depose =(
															SELECT wm.code_emplacement
															FROM wrk_mouvement wm
															WHERE wm.ref_produit = ek.unite_tracking
															AND wm.type = 'depose'
															AND wm.code_emplacement <> 'Réception'
                                                            AND wm.code_emplacement NOT LIKE 'Attente%'
															ORDER BY wm.created_at ASC
															LIMIT 1 ) 
                         WHERE ek.date_depose IS NULL ");

	// 2ieme Dépose
    $req = $con->execute("UPDATE exp_kpi_retard ek SET ek.date_depose_suivante =(SELECT wm.heure_prise
                                                                                FROM wrk_mouvement wm
                                                                                WHERE wm.ref_produit = ek.unite_tracking
                                                                                AND wm.type = 'depose'
                                                                                AND wm.code_emplacement <> 'Réception'
                                                                                AND wm.code_emplacement NOT LIKE 'Attente%'
                                                                                ORDER BY wm.created_at ASC
                                                                                LIMIT 1,1 )
                          WHERE ek.date_depose_suivante IS NULL ");
							
    //calcul des délais
    $res = WrkMouvementTable::getInstance()->getDelaisReceptionUniteTracking($dateDebut, $dateFin);

    //mise à jour de la table tampon
    foreach ($res as $ut){
        $retard = $ut['date_depose'] ? $ut['time_retard_depose'] : $ut['time_retard_sans_depose'];
        $req = $con->execute("UPDATE exp_kpi_retard set delai_brut = '".$ut['time_delais_acheminement']."', "
            . "                                              delai = '".$ut['time_delais_acheminement_horaire']."',"
            . "                                              retard= '".$retard."'"
            . "               WHERE unite_tracking = '".mysql_real_escape_string($ut['unite'])."' ");
    }
    
    //Calcul retard A Arrivage Réception
    $req = $con->execute ("SELECT * FROM exp_kpi_retard WHERE date_arrivage IS NOT NULL AND retard_A IS NULL");
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
        $req = $con->execute("UPDATE exp_kpi_retard SET retard_A = '".$delai."' WHERE unite_tracking = '".mysql_real_escape_string($listeUnite[$i]["unite_tracking"])."' ");   
    }
    
    //Calcul retard B Réception Dépose
    $req = $con->execute ("SELECT * FROM exp_kpi_retard WHERE date_depose IS NOT NULL AND retard_B IS NULL");
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
        $req = $con->execute("UPDATE exp_kpi_retard SET retard_B = '".$delai."' WHERE unite_tracking = '".mysql_real_escape_string($listeUnite[$i]["unite_tracking"])."' ");   
    }
    
    //Calcul retard C 1ere Dépose - 2ieme Dépose
    $req = $con->execute ("SELECT * FROM exp_kpi_retard WHERE date_depose_suivante IS NOT NULL AND retard_C IS NULL");
    $listeUnite = $req->fetchAll(PDO::FETCH_ASSOC);
    
    $nbUnit = sizeof($listeUnite);
    
    for($i=0; $i < $nbUnit; $i++){
        
        // maj des délais 
        $req = $con->execute("SELECT `WORKDAY_TIME_DIFF_HOLIDAY_TABLE` ('ALL', '".$listeUnite[$i]["date_depose"]."', '".$listeUnite[$i]["date_depose_suivante"]."', '07:00', '17:00') /60 AS delai");
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
        $req = $con->execute("UPDATE exp_kpi_retard SET retard_C = '".$delai."' WHERE unite_tracking = '".mysql_real_escape_string($listeUnite[$i]["unite_tracking"])."' ");   
    }
    
    $fin=microtime(true);
	$duree=$fin-$debut;
	$duree=SUBSTR($duree, 0, 4);
    
	echo "Duree du script : ".$duree." secondes \n";
	echo "\r\n";
    
  }
}
