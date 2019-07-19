<?php

class majBdTestTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    //   $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'MobileStockV3'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'majBdTest';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [migrationBd|INFO] task does things.
Call it with:

  [php symfony migrationBd|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $debut = microtime(true);
	// initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    
    $con = Doctrine_Manager::getInstance()->connection();
    
	$color = "[36m";
	$text = "Done\n";
	
	echo "\n";
	echo "Migration des donnees\n";
	echo "________________________________________\n";
	echo "\n";
    
	/* Export donnees production */
	echo "Export donnees production...........";	
	echo shell_exec("mysqldump -uusrGtUtc01 -paVKG8pmhvPtDPtS gt-utc-01 > gt.sql 2>&1");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Raz nouvelle base */
	echo "Reset tables nouvelle BD............";	
	$req = $con->execute("SET foreign_key_checks = 0");
	$req = $con->execute("DROP TABLE `adm_parametrage`, `adm_spool`, `adm_supervision_parametrage`, `exp_kpi`, `exp_kpi_retard`, `holiday_table`, `ref_chauffeur`, `ref_destinataire_acheminement`, `ref_emplacement`, `ref_emplacement_acheminement`, `ref_ferie`, `ref_fournisseur`, `ref_horaire`, `ref_nature`, `ref_transporteur`, `ref_widget`, `sf_guard_forgot_password`, `sf_guard_group`, `sf_guard_group_permission`, `sf_guard_permission`, `sf_guard_remember_key`, `sf_guard_user`, `sf_guard_user_group`, `sf_guard_user_permission`, `tables`, `wrk_acheminement`, `wrk_arrivage`, `wrk_arrivage_produit`, `wrk_colis_acheminement`, `wrk_expedition`, `wrk_expedition_produit`, `wrk_groupe`, `wrk_group_widget`, `wrk_inventaire`, `wrk_mouvement`");
	$req = $con->execute("SET foreign_key_checks = 1");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Import des donnees*/
	echo "Import donnees production...........";	
	echo shell_exec("mysql -uusrgttest -pZVKG8pmhvPyxDPtS gt_log_test < gt.sql 2>&1");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
		
	$fin=microtime(true);
	$duree=$fin-$debut;
	$duree=SUBSTR($duree, 0, 4);
	
		/* View */
	echo "Import view.........................";
	$req = $con->execute("CREATE VIEW `v_mouvement_retard` AS select `m`.`id_mouvement` AS `id_mouvement`,`m`.`ref_produit` AS `ref_produit`,`m`.`heure_prise` AS `heure_prise`,`m`.`type` AS `type`,`m`.`code_emplacement` AS `code_emplacement`,`m`.`groupe` AS `groupe`,timestampdiff(SECOND,addtime(`m`.`heure_prise`,`n`.`delais`),now()) AS `secondes` 
							from ((`wrk_mouvement` `m` 
							join `wrk_arrivage_produit` `ap` on((`ap`.`br_sap` = convert(`m`.`ref_produit` using utf8)))) 
							join `ref_nature` `n` on((`n`.`id_nature` = `ap`.`id_nature`)))");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
    
	echo "\r\n";
	echo "_________________________________________\n";
	echo "\n";
	echo "Migration des donnees terminee\n";
	echo "Duree du script : ".$duree." secondes \n";
	echo "\n";
	
  }
}
