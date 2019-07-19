--	Patch base de donnees
--  --------------------------------
--	    Version : patch-v1.38
--	Commentaire : modification champ updated_at nouvelle version mysql
--  --------------------------------


UPDATE `ref_fournisseur` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `ref_chauffeur` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `ref_emplacement_acheminement` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `ref_nature` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `ref_transporteur` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `ref_widget` SET `created_at` = NOW(), `updated_at` = NOW();

UPDATE `wrk_arrivage` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `wrk_arrivage_produit` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `wrk_expedition` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `wrk_expedition_produit` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `wrk_mouvement` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `wrk_groupe` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `wrk_acheminement` SET `created_at` = NOW(), `updated_at` = NOW();
UPDATE `ref_emplacement` SET `created_at` = NOW(), `updated_at` = NOW();






ALTER TABLE `ref_fournisseur` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `ref_chauffeur` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `ref_emplacement_acheminement` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `ref_nature` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `ref_transporteur` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `ref_widget` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `wrk_arrivage` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `wrk_arrivage_produit` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `wrk_expedition` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `wrk_expedition_produit` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `wrk_mouvement` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `wrk_groupe` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `wrk_acheminement` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `wrk_arrivage` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `wrk_arrivage_produit` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `ref_fournisseur` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 

ALTER TABLE `ref_chauffeur` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `ref_emplacement_acheminement` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `ref_nature` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `ref_transporteur` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `ref_widget` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `wrk_expedition` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `wrk_expedition_produit` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `wrk_mouvement` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `wrk_groupe` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `wrk_acheminement` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 

ALTER TABLE `ref_emplacement` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
ALTER TABLE `ref_emplacement` CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `wrk_groupe` CHANGE `retry` `retry` INT(4) NULL; 

UPDATE `adm_supervision_parametrage` SET `valeur` = '1.38' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;