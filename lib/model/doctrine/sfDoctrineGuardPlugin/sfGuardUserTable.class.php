<?php

class sfGuardUserTable extends PluginsfGuardUserTable {

        const  LOGIN_FAILED_LIMIT =3;
    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardUserTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('sfGuardUser');
    }
    


    /* retourne l'objet utilisateur en fonction de son id */

    public static function getUtilisateur($id) {
        $q = Doctrine_Query::create()->from('sfGuardUser s')->andwhere("id = ?", $id);
        ;
        return $q->fetchOne();
    }

    /* retourne la liste des utilisateurs faisant partie du groupe passé en parametre */

    public static function getListeGroupe($groupe) {
        $q = Doctrine_Query::create()->from('sfGuardUser s');
        $q->innerJoin('s.sfGuardUserGroup sug');
        $q->innerJoin('sug.Group sg');
        $q->where("sg.name = ?", $groupe);
        ;
        return $q->execute();
    }

    /* retourne la liste des utilisateurs faisant partie du groupe passé en parametre */

    public static function getRequeteListeGroupe($groupe1, $groupe2) {
        $q = Doctrine_Query::create()->from('sfGuardUser s');
        $q->innerJoin('s.sfGuardUserGroup sug');
        $q->innerJoin('sug.sfGuardGroup sg');
        $q->where("sg.name = ?", $groupe1);
        $q->orWhere("sg.name = ?", $groupe2);
        return $q;
    }

    /* retourne la liste des cariste sous forme de tableau pour la liste deroulante
      le parametre blanc definit si la liste comportant un enregistrement blanc au debut */

    public static function getListeCariste($blanc = false) {
        return self::toTable(self::getListeGroupe('cariste'), $blanc);
    }

    /* transforme la collection sfGuardUser en tableau */

    public static function toTable($collection, $vide = false) {
        $object_table = array();
        if ($vide)
            $object_table[null] = null;
        foreach ($collection as $object):
            $object_table[strval($object->getId())] = $object->getUsername();
        endforeach;
        return $object_table;
    }

    /* retourne la liste des opérateurs (cariste et magasinier) */

    public static function getListeOperateurs() {
        $caristes = self::getListeGroupe('Cariste');
        $magasiniers = self::getListeGroupe('Magasinier');
        return $caristes->merge($magasiniers);
    }

    /* retourne la liste des opérateurs (cariste et magasinier) */

    public static function getRequeteListeOperateurs() {
        $reqOpe = self::getRequeteListeGroupe('Cariste', 'Magasinier');
        return $reqOpe;
    }

    /* retourne la liste des opérateurs (cariste et magasinier) */

    public static function getTableListeOperateurs($blanc = false) {
        return self::toTable(self::getListeOperateurs(), $blanc);
    }

    /* retourne la liste des opérateurs ayant effectué au moins une mission */

    public static function getListeOperateursMission($blanc) {
        $q = Doctrine_Query::create()->select('s.*')->from('SfGuardUser s, RefMission r')
                        ->where('s.id = r.id_utilisateur')->groupBy('s.id');
        return self::toTable($q->execute(), $blanc);
    }

    /* retourne la liste des opérateurs etant dans les groupe passé sous forme de tableau */

    public static function getListeOperateursDesGroupes($groupes = array()) {
        $tabIdGroup = array();
        foreach ($groupes as $key => $actif) {
            $tabIdGroup[] = $key;
        }
        $q = Doctrine_Query::create()->from('SfGuardUser s')
                        ->innerJoin('s.sfGuardUserGroup sug')->whereIn('sug.group_id', $tabIdGroup);
        return $q->execute();
    }

    /* retourne la liste des utilisteur ayant au moins effectué une mission cariste (stats cariste)
      ou une mission magasinier (stats magasiniers) */

    public static function getListeOperateursAvecMission($groupe) {
        if ($groupe == "cariste")
            $missions = array('Rangement P.C.', 'Reappro Picking', 'Preparation reserve', 'Preparation reception', 'Preparation masse');
        if ($groupe == "magasinier")
            $missions = array('Rangement vrac', 'Colisage', 'Preparation picking');

        $q = Doctrine_Query::create()->select('s.*')->from('SfGuardUser s, RefMission r')
                ->where('s.id = r.id_utilisateur')->whereIn('r.type_mission', $missions)
                ->groupBy('s.id');

        //prendre en compte les missions historisés
        $q2 = Doctrine_Query::create()->select('s.*')->from('SfGuardUser s, HisMission r')
                ->where('s.id = r.id_utilisateur')->whereIn('r.type_mission', $missions)
                ->groupBy('s.id');

        return $q->execute()->merge($q2->execute());
    }

    // Permet de controler que le nom d'utilisateur n'existe pas deja
    public function controlNomUtilisateur($nom, $id) {
        $req = Doctrine_Query::CREATE()->from('sfGuardUser');
        $req->addWhere('username = ?', $nom);
        if ($id) {
            $req->addWhere('id != ?', $id);
        }
        return $req->execute();
    }

    // Permet de controler que le mail n'existe pas deja
    public function controlMailUtilisateur($mail, $id) {
        $req = Doctrine_Query::CREATE()->from('sfGuardUser');
        $req->addWhere('email_address = ?', $mail);
        if ($id) {
            $req->addWhere('id != ?', $id);
        }
        return $req->execute();
    }

    /* Renvoi la liste des applications auquelle l'utilisateur à accès */

    public static function getApplicationUtilisateur($groupe) {
        //on recup les permissions appli du grp associé au user
        $q = Doctrine_Query::create()->from('sfGuardPermission s');
        $q->innerJoin('s.sfGuardGroupPermission sug');
        $q->innerJoin('sug.Group sg');
        $q->where("sg.name = ?", $groupe[0]);
        $q->andWhere("s.name LIKE ?", 'app_%');

        $permissions = array();
        foreach ($q->execute() as $permission):
            $permissions[] = $permission->getName();
        endforeach;

        return $permissions;
    }
    public static function getModulesUtilisateur($groupe) {
        //on recup les permissions appli du grp associé au user
        $q = Doctrine_Query::create()->from('sfGuardPermission s');
        $q->innerJoin('s.sfGuardGroupPermission sug');
        $q->innerJoin('sug.Group sg');
        $q->where("sg.name = ?", $groupe[0]);
        $q->andWhere("s.name NOT LIKE ?", 'app_%');

        $permissions = array();
        foreach ($q->execute() as $permission):
            $permissions[] = $permission->getName();
        endforeach;

        return $permissions;
    }

    public function getAllGroupWithUser() {
        $groups = $this->createQuery()
                ->select('g.*')
                ->from('sfGuardGroup g')
                ->innerJoin('g.sfGuardUserGroup ug')
                ->execute();
        $groupsArray = array();
        foreach ($groups as $group) {
            $groupArray = array('groupName' => $group->getName(), 'users' => array());
            $users = $this->createQuery()
                    ->select('u.*')
                    ->from('sfGuardUser u')
                    ->innerJoin('u.sfGuardUserGroup ug')
                    ->where('ug.group_id=?', $group->getId())
                    ->execute();
            foreach ($users as $user) {
                $groupArray['users'][$user->getId()] = array(
                    'userName' => $user->getUsername(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName());
            }
            $groupsArray[$group->getId()] = $groupArray;
        }
        return $groupsArray;
    }

    public function getEmailAddressFromIds($idUsersArray) {
        $emails = $this->createQuery()
                ->select('u.email_address')
                ->from('sfGuardUser u')
                ->whereIn('u.id', $idUsersArray)
                ->execute();
        $emailsArray = array();
        foreach ($emails as $email) {
            if ($email->getEmailAddress()) {
                $emailsArray[] = $email->getEmailAddress();
            }
        }
        return $emailsArray;
    }

}
