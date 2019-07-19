--	Patch base de donnees
--  --------------------------------
--	    Version : patch-v1.38
--	Commentaire : modification champ updated_at nouvelle version mysql
--  --------------------------------

CREATE TRIGGER sync_user_insert  AFTER INSERT ON sf_guard_user FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM sf_guard_user) , nbRow=(SELECT COUNT(*) FROM sf_guard_user), updatedAt=NOW()  WHERE name="sf_guard_user";

CREATE TRIGGER sync_user_update AFTER UPDATE ON sf_guard_user FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM sf_guard_user) , nbRow=(SELECT COUNT(*) FROM sf_guard_user), updatedAt=NOW() WHERE name="sf_guard_user";


CREATE TRIGGER sync_emplacement_insert  AFTER INSERT ON ref_emplacement FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM ref_emplacement) , nbRow=(SELECT COUNT(*) FROM ref_emplacement), updatedAt=NOW()  WHERE name="ref_emplacement";

CREATE TRIGGER sync_emplacement_update AFTER UPDATE ON ref_emplacement FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM ref_emplacement) , nbRow=(SELECT COUNT(*) FROM ref_emplacement), updatedAt=NOW() WHERE name="ref_emplacement";

CREATE TRIGGER sync_parametrage_insert  AFTER INSERT ON adm_supervision_parametrage FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM adm_supervision_parametrage) , nbRow=(SELECT COUNT(*) FROM adm_supervision_parametrage), updatedAt=NOW()  WHERE name="adm_supervision_parametrage";

CREATE TRIGGER sync_parametrage_update AFTER UPDATE ON adm_supervision_parametrage FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM adm_supervision_parametrage) , nbRow=(SELECT COUNT(*) FROM adm_supervision_parametrage), updatedAt=NOW() WHERE name="adm_supervision_parametrage";

CREATE TRIGGER sync_mouvement_insert  AFTER INSERT ON wrk_mouvement FOR EACH ROW
UPDATE tables SET lastUpdated=(SELECT MAX(updated_at) FROM wrk_mouvement) , nbRow=(SELECT COUNT(*) FROM wrk_mouvement), updatedAt=NOW()  WHERE name="wrk_mouvement";




ALTER TABLE `wrk_mouvement` ADD `sync_id` VARCHAR( 50 ) NULL DEFAULT NULL ,
ADD UNIQUE (
`sync_id`
);

ALTER TABLE `adm_supervision_parametrage` ADD `sync_id` VARCHAR( 50 ) NULL DEFAULT NULL ,
ADD UNIQUE (
`sync_id`
);

ALTER TABLE `ref_emplacement` ADD `sync_id` VARCHAR( 50 ) NULL DEFAULT NULL ,
ADD UNIQUE (
`sync_id`
);


ALTER TABLE `sf_guard_user` ADD `sync_id` VARCHAR( 50 ) NULL DEFAULT NULL ,
ADD UNIQUE (
`sync_id`
);


ALTER TABLE `wrk_groupe` ADD `sync_id` VARCHAR( 50 ) NULL DEFAULT NULL ,
ADD UNIQUE (
`sync_id`
);

ALTER TABLE `wrk_inventaire` ADD `sync_id` VARCHAR( 50 ) NULL DEFAULT NULL ,
ADD UNIQUE (
`sync_id`
);

UPDATE `adm_supervision_parametrage` SET `valeur` = '1.39' WHERE `adm_supervision_parametrage`.`nom` = 'version_BDD' ;