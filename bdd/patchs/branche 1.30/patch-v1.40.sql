--	Patch base de donnees
--  --------------------------------
--	    Version : patch-v1.40
--	Commentaire : modification champ updated_at nouvelle version mysql
--  --------------------------------

CREATE TABLE IF NOT EXISTS `wrk_urgence` (
  `id_urgence` int(11) NOT NULL AUTO_INCREMENT,
  `id_fournisseur` int(11) NOT NULL,
  `id_transporteur` int(11) NOT NULL,
  `id_chauffeur` int(11) DEFAULT NULL,
  `lettre_voiture` varchar(100) DEFAULT NULL,
  `nb_colis` int(11) DEFAULT NULL,
  `nb_palette` int(11) DEFAULT NULL,
  `immatriculation` varchar(45) DEFAULT NULL,
  `tracking_four` varchar(255) DEFAULT NULL,
  `commande_achat` varchar(255) DEFAULT NULL,
  `rep_signature` text,
  `br_sap` varchar(100) DEFAULT NULL,
  `statut` varchar(100) NOT NULL DEFAULT 'conforme',
  `commentaire` text,
  `urgent` tinyint(1) NOT NULL DEFAULT '0',
  `date_livraison_debut` datetime DEFAULT NULL,
  `date_livraison_fin` datetime DEFAULT NULL,
  `id_interlocuteur` int(11) DEFAULT NULL,
`id_arrivage` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_urgence`),
  KEY `fk_arrivage_transporteur_idx` (`id_transporteur`),
  KEY `fk_arrivage_fournisseur_idx` (`id_fournisseur`),
  KEY `id_interlocuteur` (`id_interlocuteur`)
);

ALTER TABLE `wrk_urgence` ADD INDEX(`id_arrivage`); 
ALTER TABLE `wrk_urgence` ADD CONSTRAINT `fk_urgence_fournisseur_idx` FOREIGN KEY (`id_arrivage`) REFERENCES `wrk_arrivage`(`id_arrivage`) ON DELETE SET NULL ON UPDATE SET NULL; 

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'urgence-ecriture', NULL, '', CURRENT_TIMESTAMP); 
INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'urgence', NULL, '', CURRENT_TIMESTAMP); 



UPDATE `adm_supervision_parametrage` SET `valeur` = '1.40' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;