--	Patch base de donnees 
--  --------------------------------
--	    Version : patch-v1.35
--	Commentaire : ajout champ signature sur les mouvements et paramètrage pour la destination d'un produit
--  --------------------------------

ALTER TABLE `wrk_mouvement` ADD `signature` TEXT NULL AFTER `quantite`;
ALTER TABLE `wrk_mouvement` ADD `photos` TEXT NULL AFTER `quantite`;

INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'popup_emplacement_destination_invalide', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP);

INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'popup_emplacement_destination_invalide', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP);
INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'signature_ecran_prise', NULL, '0', '0000-00-00 00:00:00', CURRENT_TIMESTAMP);
INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'signature_ecran_depose', NULL, '1', '0000-00-00 00:00:00', CURRENT_TIMESTAMP);

INSERT INTO `adm_supervision_parametrage` (`id`, `nom`, `description`, `valeur`, `created_at`, `updated_at`) VALUES (NULL, 'url_server_sails', NULL, 'http://localhost:1337', '0000-00-00 00:00:00', CURRENT_TIMESTAMP);

UPDATE `adm_supervision_parametrage` SET `valeur` = '1.35' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;