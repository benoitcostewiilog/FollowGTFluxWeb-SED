--	Patch base de donnees 
--  --------------------------------
--	    Version : patch-v1.37
--	Commentaire : 
--  --------------------------------


INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'nonconforme', NULL, '', CURRENT_TIMESTAMP); 
ALTER TABLE `wrk_mouvement` ADD `anomalie` VARCHAR(255) NULL AFTER `signature`; 

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'encours', NULL, '', CURRENT_TIMESTAMP); 
INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'arrivage-urgence-ecriture', NULL, '', CURRENT_TIMESTAMP); 


ALTER TABLE `sf_guard_user` ADD `login_failed` INT NOT NULL DEFAULT '0' ; 

UPDATE `adm_supervision_parametrage` SET `valeur` = '1.37' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;