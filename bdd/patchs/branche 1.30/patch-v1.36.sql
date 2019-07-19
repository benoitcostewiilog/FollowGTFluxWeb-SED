--	Patch base de donnees 
--  --------------------------------
--	    Version : patch-v1.36
--	Commentaire : 
--  --------------------------------

CREATE TABLE IF NOT EXISTS `ref_interlocuteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `ref_interlocuteur` ADD `created_at` DATETIME NULL DEFAULT NULL ,
ADD `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL ;

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'referentiels-interlocuteur', NULL, '', CURRENT_TIMESTAMP); 
ALTER TABLE `wrk_arrivage` ADD `tracking_four` VARCHAR(255) NULL AFTER `immatriculation`, ADD `commande_achat` VARCHAR(255) NULL AFTER `tracking_four`; 

ALTER TABLE `wrk_arrivage` ADD `urgent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `commentaire`, ADD `date_livraison_debut` DATETIME NULL DEFAULT NULL AFTER `urgent`, ADD `date_livraison_fin` DATETIME NULL DEFAULT NULL AFTER `date_livraison_debut`, ADD `id_interlocuteur` INT NULL AFTER `date_livraison_fin`, ADD INDEX (`id_interlocuteur`) ; 
UPDATE `adm_supervision_parametrage` SET `valeur` = '1.36' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;