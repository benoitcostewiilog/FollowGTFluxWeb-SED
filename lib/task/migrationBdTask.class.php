<?php

class migrationBdTask extends sfBaseTask
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
    $this->name             = 'migrationBd';
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
	echo shell_exec("mysqldump -uusrgttst -ppass2015gt  gt_log_tst01 > gt.sql 2>&1");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Raz nouvelle base */
	echo "Reset tables nouvelle BD............";	
	$req = $con->execute("SET foreign_key_checks = 0");
	$req = $con->execute("DROP TABLE `adm_parametrage`, `adm_spool`, `adm_supervision_parametrage`, `exp_kpi`, `exp_kpi_retard`, `holiday_table`, `ref_chauffeur`, `ref_destinataire_acheminement`, `ref_emplacement`, `ref_emplacement_acheminement`, `ref_ferie`, `ref_fournisseur`, `ref_horaire`, `ref_nature`, `ref_transporteur`, `ref_widget`, `sf_guard_forgot_password`, `sf_guard_group`, `sf_guard_group_permission`, `sf_guard_permission`, `sf_guard_remember_key`, `sf_guard_user`, `sf_guard_user_group`, `sf_guard_user_permission`, `tables`, `wrk_acheminement`, `wrk_arrivage`, `wrk_arrivage_produit`, `wrk_colis_acheminement`, `wrk_expedition`, `wrk_expedition_produit`, `wrk_groupe`, `wrk_group_widget`, `wrk_inventaire`, `wrk_mouvement`");
	$req = $con->execute("SET foreign_key_checks = 1");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Import des donnees*/
	echo "Import donnees production...........";	
	echo shell_exec("mysql -uusrGtUtc01 -paVKG8pmhvPtDPtS gt-utc-01 < gt.sql 2>&1");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Suppression mvt anterieur 2017 */
	echo "Supp old mvmt.......................";	
	$req = $con->execute("DELETE FROM `wrk_mouvement` WHERE `heure_prise` <'2017-01-01 00:00:00'");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );

	/* Suppression emplacement */
	echo "Supp emplacement....................";	
	$req = $con->execute("TRUNCATE TABLE `ref_emplacement`");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
    /* Patchs */
	echo "Patch 1.27..........................";
    $req = $con->execute("ALTER TABLE `wrk_acheminement` ADD `destinataire` VARCHAR( 45 ) NULL AFTER `demandeur`");
    
	$req = $con->execute("CREATE TABLE IF NOT EXISTS `wrk_colis_acheminement` (
						  `id_colis` int(11) NOT NULL AUTO_INCREMENT,
						  `id_acheminement` int(11) NOT NULL,
						  `tracking` varchar(45) NOT NULL,
						  `numero_colis` int(11) NOT NULL,
						  `designation` varchar(100) DEFAULT NULL,
						  `created_at` datetime DEFAULT NULL,
						  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id_colis`)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
						
    $req = $con->execute("CREATE TABLE IF NOT EXISTS `tables` (
						  `name` varchar(255) DEFAULT NULL,
						  `lastUpdated` datetime DEFAULT NULL,
						  `nbRow` int(11) DEFAULT '0',
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `createdAt` datetime DEFAULT NULL,
						  `updatedAt` datetime DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1");	
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );

    echo "Patch 1.28..........................";
	$req = $con->execute("ALTER TABLE `wrk_mouvement` ADD `quantite` INT(4) NULL DEFAULT NULL AFTER `commentaire`");
	$req = $con->execute("ALTER TABLE `wrk_groupe` ADD `quantite` INT(4) NULL DEFAULT NULL AFTER `id_utilisateur`");
	$req = $con->execute("ALTER TABLE `wrk_inventaire` ADD `quantite` INT(4) NULL DEFAULT NULL AFTER `code_emplacement`");
	$req = $con->execute("ALTER TABLE `adm_supervision_parametrage` CHANGE `valeur` `valeur` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES
						(2, 'type_passage', NULL, '[{ \"id\": 1, \"text\": \"Gare vide\", \"icon\": \"ios-cube-outline\", \"value\": \"Gare vide\" },{ \"id\": 2, \"text\": \"Navette pleine\", \"icon\": \"ios-cube\", \"value\": \"Navette pleine\" }]', '0000-00-00 00:00:00', '2017-10-04 15:46:05')");
	$req = $con->execute("ALTER TABLE `ref_emplacement` DROP PRIMARY KEY");
	$req = $con->execute("ALTER TABLE `ref_emplacement` ADD `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES 
						(NULL, 'gestion_emplacement', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP), 
						(NULL, 'auto_create_emplacement', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'logout_possible_prise', NULL, '0', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");					
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'domaine_connexion', NULL, 'Ratier Figeac', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES 
						(NULL, 'show_colis_en_prise', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP), 
						(NULL, 'vidage_um_prise_produit', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'vidage_um_depose_um', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'scan_depose_obligatoire', NULL, '0', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'toggle_vidage_complet_um', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP);");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
    echo "Patch 1.29..........................";
	$req = $con->execute("ALTER TABLE `wrk_mouvement` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL");
	$req = $con->execute("ALTER TABLE `ref_emplacement` CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");
	$req = $con->execute("ALTER TABLE `wrk_inventaire` CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
    echo "Patch 1.30..........................";
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'url_download_apk', NULL, 'http://test-gt.mobilestock.fr/uploads/GTracking.apk', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'version_nomade', NULL, '5', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'depose_produit_non_pris', NULL, '0', '0000-00-00 00:00:00', CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `sf_guard_permission` (`id`,`name`,`description`,`created_at`,`updated_at`)VALUES (NULL ,'borne-arrivage', NULL, '',CURRENT_TIMESTAMP), (NULL, 'borne-expedition', NULL , '',CURRENT_TIMESTAMP)");
	$req = $con->execute("INSERT INTO `sf_guard_permission` (`id`,`name`,`description`,`created_at`,`updated_at`)VALUES (NULL ,'statistiques-retard', NULL, '',CURRENT_TIMESTAMP), (NULL, 'statistiques-globale', NULL , '',CURRENT_TIMESTAMP)");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
    echo "Patch 1.31..........................";
	$req = $con->execute("CREATE TABLE IF NOT EXISTS `exp_kpi_retard` (
						  `num_arrivage` varchar(45) DEFAULT NULL,
						  `date_arrivage` varchar(45) DEFAULT NULL,
						  `zone_attente1` varchar(45) DEFAULT NULL,
						  `date_attente1` varchar(45) DEFAULT NULL,
						  `unite_tracking` varchar(45) DEFAULT NULL,
						  `date_reception` varchar(45) DEFAULT NULL,
						  `zone_attente2` varchar(45) DEFAULT NULL,
						  `date_attente2` varchar(45) DEFAULT NULL,  
						  `date_depose` varchar(45) DEFAULT NULL,  
						  `zone_depose` varchar(45) DEFAULT NULL,
						  `date_depose_suivante` varchar(45) DEFAULT NULL,  
						  `delai_brut` time DEFAULT NULL,
						  `delai` time DEFAULT NULL,
						  `retard` time DEFAULT NULL,
						  `retard_A` time DEFAULT NULL,
						  `retard_B` time DEFAULT NULL,
						  `retard_C` time DEFAULT NULL
						) ENGINE=MyISAM DEFAULT CHARSET=latin1");
	
	$req = $con->execute("ALTER TABLE `exp_kpi_retard` CHANGE `date_arrivage` `date_arrivage` DATETIME NULL DEFAULT NULL ,
							CHANGE `date_attente1` `date_attente1` DATETIME NULL DEFAULT NULL ,
							CHANGE `date_reception` `date_reception` DATETIME NULL DEFAULT NULL ,
							CHANGE `date_attente2` `date_attente2` DATETIME NULL DEFAULT NULL ,
							CHANGE `date_depose` `date_depose` DATETIME NULL DEFAULT NULL ,
							CHANGE `date_depose_suivante` `date_depose_suivante` DATETIME NULL DEFAULT NULL");
	$req = $con->execute("ALTER TABLE `exp_kpi_retard` ADD INDEX ( `unite_tracking` )");
	$req = $con->execute("ALTER TABLE `wrk_colis_acheminement` ADD `statut` VARCHAR( 100 ) NULL AFTER `designation`");
	$req = $con->execute("ALTER TABLE `exp_kpi_retard` DROP INDEX `unite_tracking` , ADD UNIQUE `unite_tracking` ( `unite_tracking` ) ");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
    echo "Patch 1.32..........................";
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES
							(19, 'delai_retard_A ', NULL, '03:30:00', '0000-00-00 00:00:00', '2017-11-16 11:24:13'),
							(20, 'delai_retard_B', NULL, '01:30:00', '0000-00-00 00:00:00', '2017-11-16 11:24:13'),
							(21, 'delai_retard_C', NULL, '01:00:00', '0000-00-00 00:00:00', '2017-11-16 11:24:34')"); 
	$req = $con->execute("INSERT INTO `ref_widget` (`id_widget`, `name`, `created_at`, `updated_at`) VALUES
							(5, 'Arrivages en retard', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
							(6, 'Réception en retard', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
							(7, 'Dépose en retard', '0000-00-00 00:00:00', '0000-00-00 00:00:00')");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	echo "Patch 1.33..........................";
	$req = $con->execute("ALTER TABLE `adm_supervision_parametrage` CHANGE `nom` `nom` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
	$req = $con->execute("INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES
							(18, 'input_method_emplacement_scan', NULL, '1', '0000-00-00 00:00:00', NOW( )),
							(17, 'input_method_emplacement_input', NULL, '0', '0000-00-00 00:00:00', NOW( )),
							(16, 'input_method_emplacement_list', NULL, '1', '0000-00-00 00:00:00', NOW( )),
							(15, 'first_input_method_emplacement', NULL, 'scan', '0000-00-00 00:00:00', NOW( ))");
	$req = $con->execute("UPDATE `adm_supervision_parametrage` SET `valeur` = 'http://gt-utc.mobilestock.fr/uploads/apk/FollowGT-v0.8.apk',`updated_at` = NOW( ) WHERE `adm_supervision_parametrage`.`id` = 12");
	$req = $con->execute("UPDATE `adm_supervision_parametrage` SET `valeur` = '18',`updated_at` = NOW( ) WHERE `adm_supervision_parametrage`.`id` = 13");
	$req = $con->execute("UPDATE `adm_supervision_parametrage` SET `valeur` = '1',`updated_at` = NOW( ) WHERE `adm_supervision_parametrage`.`id` = 10");
	$req = $con->execute("UPDATE `wrk_mouvement` SET `updated_at` = NOW() LIMIT 5");
	$req = $con->execute("UPDATE `wrk_inventaire` SET `updated_at` = NOW()");
	$req = $con->execute("ALTER TABLE `wrk_mouvement` ENGINE = MYISAM");
	$req = $con->execute("ALTER TABLE `wrk_acheminement` ADD `designation` VARCHAR( 200 ) NULL ");
	$req = $con->execute("UPDATE `adm_supervision_parametrage` SET `valeur` = '1.33' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD'");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
        
	echo "Patch 1.34..........................";
	$req = $con->execute("INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'acheminement-sans-export', NULL, '', CURRENT_TIMESTAMP)");
	$req = $con->execute("UPDATE `adm_supervision_parametrage` SET `valeur` = '1.34' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD'");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	
	/* View */
	echo "Import view.........................";
	$req = $con->execute("CREATE VIEW `v_mouvement_retard` AS select `m`.`id_mouvement` AS `id_mouvement`,`m`.`ref_produit` AS `ref_produit`,`m`.`heure_prise` AS `heure_prise`,`m`.`type` AS `type`,`m`.`code_emplacement` AS `code_emplacement`,`m`.`groupe` AS `groupe`,timestampdiff(SECOND,addtime(`m`.`heure_prise`,`n`.`delais`),now()) AS `secondes` 
							from ((`wrk_mouvement` `m` 
							join `wrk_arrivage_produit` `ap` on((`ap`.`br_sap` = convert(`m`.`ref_produit` using utf8)))) 
							join `ref_nature` `n` on((`n`.`id_nature` = `ap`.`id_nature`)))");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Maj jour feries */
	echo "Maj jours feries....................";
	$req = $con->execute("INSERT INTO `holiday_table` (`holiday_table_id`, `holiday_date`, `week_day`, `holiday_name`, `Country_codes`) VALUES (2, '2017-12-25 00:00:00', 'Monday', 'noel', 'ALL'),
						(3, '2018-04-02 00:00:00', 'Monday', 'paque', 'ALL'),
						(4, '2018-05-01 00:00:00', 'Tuesday', 'travail', 'ALL'),
						(5, '2018-05-08 00:00:00', 'Tuesday', '1945', 'ALL'),
						(6, '2018-05-10 00:00:00', 'Tuesday', 'ascension', 'ALL'),
						(7, '2018-07-14 00:00:00', 'Saturday', 'fetnat', 'ALL'),
						(8, '2018-08-15 00:00:00', 'Wednesday', 'Assomption', 'ALL')");
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	/* Maj emplacements*/
	echo "Maj emplacements....................";
	$req = $con->execute("INSERT INTO `ref_emplacement` (`id`, `code_emplacement`, `libelle`, `updated_at`, `created_at`) VALUES
						(1, 'A3 - Informatique', 'A3 - Informatique', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(2, 'Attente decision RF', 'Attente decision RF', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(3, 'Attente Douane', 'Attente Douane', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(4, 'Attente Anomalies', 'Attente Anomalies', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(5, 'Attente Airbus Helicoptere', 'Attente Airbus Helicoptere', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(6, 'Attente Reconditionnement', 'Attente Reconditionnement', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(7, 'Attente Labo S64', 'Attente Labo S64', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(8, 'CE', 'CE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(9, 'Erreur transporteur', 'Erreur transporteur', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(10, 'Expedition Gle', 'Expedition Gle', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(11, 'F1', 'F1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(12, 'F1 - Magnetoscopie', 'F1 - Magnetoscopie', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(13, 'F1 A400 GTL', 'F1 A400 GTL', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(14, 'F1 AR/DP BE', 'F1 AR/DP BE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(15, 'F1 Attente BR Tulipe', 'F1 Attente BR Tulipe', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(16, 'F1 attente depart TTH', 'F1 attente depart TTH', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(17, 'F1 COMMISSION', 'F1 COMMISSION', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(18, 'F1 Courrier F1 S5', 'F1 Courrier F1 S5', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(19, 'F1 DEPART', 'F1 DEPART', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(20, 'F1 GRAISSAGE', 'F1 GRAISSAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(21, 'F1 MECANOLAV', 'F1 MECANOLAV', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(22, 'F1 MONTAGE', 'F1 MONTAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(23, 'F1 Tulipes attente BR', 'F1 Tulipes attente BR', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(24, 'F1 Tulipes attente Usinage', 'F1 Tulipes attente Usinage', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(25, 'F101 PIECES PRIMAIRES', 'F101 PIECES PRIMAIRES', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(26, 'F1801 INTEGREX', 'F1801 INTEGREX', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(27, 'F1801 PREREGLAGE', 'F1801 PREREGLAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(28, 'F1803 PEINTURE AJUSTAGE', 'F1803 PEINTURE AJUSTAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(29, 'F1804 CONTROLE', 'F1804 CONTROLE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(30, 'F2 - 2101', 'F2 - 2101', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(31, 'F2 - 2102', 'F2 - 2102', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(32, 'F2 - 2103', 'F2 - 2103', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(33, 'F2 - 2209', 'F2 - 2209', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(34, 'F2 - 23xx', 'F2 - 23xx', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(35, 'F2 - 2401', 'F2 - 2401', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(36, 'F2 - 2402', 'F2 - 2402', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(37, 'F2 - 2503', 'F2 - 2503', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(38, 'F2 - 2504', 'F2 - 2504', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(39, 'F2 - 33xx', 'F2 - 33xx', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(40, 'F2 - 3903 TONNEAU', 'F2 - 3903 TONNEAU', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(41, 'F2 - 6404', 'F2 - 6404', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(42, 'F2 - 777', 'F2 - 777', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(43, 'F2 - CONTROLE', 'F2 - CONTROLE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(44, 'F2 - DEGRAISSAGE', 'F2 - DEGRAISSAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(45, 'F2 - Depart S/T', 'F2 - Depart S/T', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(46, 'F2 - DESYN/VIS', 'F2 - DESYN/VIS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(47, 'F2 - Gestion', 'F2 - Gestion', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(48, 'F2 - MAGASIN', 'F2 - MAGASIN', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(49, 'F2 - MX MODEL', 'F2 - MX MODEL', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(50, 'F2 ARRIVEE', 'F2 ARRIVEE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(51, 'F2 EXPE', 'F2 EXPE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(52, 'F2 INTER', 'F2 INTER', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(53, 'F3 - 3102', 'F3 - 3102', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(54, 'F3 - 3103', 'F3 - 3103', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(55, 'F3 - 3104', 'F3 - 3104', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(56, 'F3 - 3105A', 'F3 - 3105A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(57, 'F3 - 3105B', 'F3 - 3105B', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(58, 'F3 - 3106', 'F3 - 3106', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(59, 'F3 - 3107', 'F3 - 3107', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(60, 'F3 - 3110', 'F3 - 3110', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(61, 'F3 - 3901', 'F3 - 3901', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(62, 'F3 - 3902', 'F3 - 3902', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(63, 'F3 - 3903A', 'F3 - 3903A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(64, 'F3 - 39XX', 'F3 - 39XX', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(65, 'F3 - ATTENTE', 'F3 - ATTENTE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(66, 'F3 - EMBALLAGE', 'F3 - EMBALLAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(67, 'F3 - MAG 0300 A', 'F3 - MAG 0300 A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(68, 'F3 - MAG 0300 B', 'F3 - MAG 0300 B', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(69, 'F3 - MAG F31', 'F3 - MAG F31', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(70, 'F3 - MAG F39', 'F3 - MAG F39', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(71, 'F3 ARRIVEE', 'F3 ARRIVEE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(72, 'F3 DEPART', 'F3 DEPART', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(73, 'F44', 'F44', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(74, 'F45', 'F45', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(75, 'F4D', 'F4D', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(76, 'F5', 'F5', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(77, 'F5 - BE', 'F5 - BE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(78, 'F5 - CLINIQUE', 'F5 - CLINIQUE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(79, 'F5 - CONTROLE FINAL', 'F5 - CONTROLE FINAL', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(80, 'F5 - EMBALLAGE', 'F5 - EMBALLAGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(81, 'F5 - MAGASIN 5A', 'F5 - MAGASIN 5A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(82, 'F5 - MAGASIN 5M', 'F5 - MAGASIN 5M', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(83, 'F5 - PEINTURE', 'F5 - PEINTURE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(84, 'F5 - Retour ss-ens', 'F5 - Retour ss-ens', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(85, 'F5 Attente decision dpt', 'F5 Attente decision dpt', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(86, 'F6', 'F6', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(87, 'F6 - DD/Cockpit', 'F6 - DD/Cockpit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(88, 'F6 - Door Damper', 'F6 - Door Damper', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(89, 'F6 - Freins', 'F6 - Freins', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(90, 'F6 - Gare', 'F6 - Gare', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(91, 'F6 - HELICES Mil.', 'F6 - HELICES Mil.', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(92, 'F6 - HELICES OEM', 'F6 - HELICES OEM', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(93, 'F6 - Helico', 'F6 - Helico', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(94, 'F6 - Magasin', 'F6 - Magasin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(95, 'F6 - MAGNETO', 'F6 - MAGNETO', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(96, 'F6 - Pales', 'F6 - Pales', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(97, 'F6 - THSA', 'F6 - THSA', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(98, 'F9', 'F9', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(99, 'F9 LABO', 'F9 LABO', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(100, 'F9 MAGASIN', 'F9 MAGASIN', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(101, 'F9 TTH', 'F9 TTH', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(102, 'HOUGHTON', 'HOUGHTON', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(103, 'INFIRMERIE', 'INFIRMERIE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(104, 'Liste residuel', 'Liste residuel', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(105, 'LLC', 'LLC', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(106, 'Local courrier', 'Local courrier', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(107, 'Local FIVES', 'Local FIVES', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(108, 'Magasin General', 'Magasin General', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(109, 'R?ception centrale', 'R?ception centrale', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(110, 'Reception Emballages', 'Reception Emballages', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(111, 'RECEPTION Gle', 'RECEPTION Gle', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(112, 'RECONDITIONNEMENT', 'RECONDITIONNEMENT', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(113, 'S1 - MAINTENANCE', 'S1 - MAINTENANCE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(114, 'S3 - ACHATS', 'S3 - ACHATS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(115, 'S5 - PROTO', 'S5 - PROTO', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(116, 'S65 PFL GT', 'S65 PFL GT', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(117, 'S65 Urgences', 'S65 Urgences', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(118, 'S8 - ENTRETIEN', 'S8 - ENTRETIEN', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(119, 'S9 - RECHANGE', 'S9 - RECHANGE', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
						(120, 'Zone TKMF', 'Zone TKMF', '0000-00-00 00:00:00', '0000-00-00 00:00:00')");
	$req = $con->execute("UPDATE ref_emplacement SET `created_at`= NOW()");					
	printf( "%c%s%s%c[0m\n", 27, $color, $text, 27 );
	
	
	$fin=microtime(true);
	$duree=$fin-$debut;
	$duree=SUBSTR($duree, 0, 4);
    
	echo "\r\n";
	echo "_________________________________________\n";
	echo "\n";
	echo "Migration des donnees terminee\n";
	echo "Duree du script : ".$duree." secondes \n";
	echo "\n";
	
  }
}
