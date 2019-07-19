--	Patch base de donnees
--  --------------------------------
--	    Version : patch-v1.41
--	Commentaire : modification champ updated_at nouvelle version mysql
--  --------------------------------

ALTER TABLE `sf_guard_user` ADD `password_updated` INT(1) NOT NULL DEFAULT '0' AFTER `password`; 
ALTER TABLE `ref_interlocuteur` ADD `id_emplacement` VARCHAR(255) NULL DEFAULT NULL AFTER `mail`; 

ALTER TABLE `wrk_arrivage` ADD `id_contact_PFF` INT(11) NULL DEFAULT NULL AFTER `id_interlocuteur`, ADD INDEX (`id_contact_PFF`) ; 

ALTER TABLE `wrk_arrivage` ADD `id_user` INT(11) NULL DEFAULT NULL AFTER `id_contact_PFF`; 

UPDATE `adm_supervision_parametrage` SET `valeur` = '1.41' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;