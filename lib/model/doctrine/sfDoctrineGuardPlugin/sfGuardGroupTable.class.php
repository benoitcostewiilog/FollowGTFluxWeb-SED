<?php

class sfGuardGroupTable extends PluginsfGuardGroupTable
{
	/* fonction qui retourne tous les groupe n'ayant pas les droits utilisateurs et groupes */
	public static function getGroupsWithBasicsRights()
	{
		//selectionne tout les groupes ayant des droits avance
		$sq = Doctrine_Query::create()->from('sfGuardGroupPermission ggp')
			->innerJoin('ggp.Permission gp')
			->andwhere("name IN('gestion des utilisateurs niveau 1',
                                 'gestion des utilisateurs niveau 2',
                                 'gestion des groupes')");
		//construit le NOT IN en ignorant ces groupes
		$groupesProscrit = $sq->execute();
		$IdGroupeProscrit = "s.id not in (";
		foreach ($groupesProscrit as $groupe):
			$IdGroupeProscrit.= $groupe->getGroupId().',' ;
		endforeach;
		$IdGroupeProscrit = substr($IdGroupeProscrit, 0, strlen($IdGroupeProscrit)-1);
		$IdGroupeProscrit.=')';
		//requete finale qui selectionne tout les groupes sauf ceux proscrit
		$q = Doctrine_Query::create()->from('sfGuardGroup s')->andwhere($IdGroupeProscrit);
		return self::toTable($q->execute());

		/*LA REQUETE
		select ggp.group_id , gg.name
		from sf_guard_group_permission ggp
		inner join sf_guard_group gg on ggp.group_id = gg.id
		where ggp.group_id not in (select ggp2.group_id
									from sf_guard_group_permission ggp2, sf_guard_permission gp
									where ggp2.permission_id = gp.id
									and gp.name IN('gestion des utilisateurs niveau 1',
													'gestion des utilisateurs niveau 2',
													'gestion des groupes')
                 )
		*/
	}

	public static function getAllGroups()
	{
		$q = Doctrine_Query::create()->from('sfGuardGroup s');
		return self::toTable($q->execute());
	}

	/*construit une table � partir d'une collection*/
	public static function toTable($collection)
	{
		$object_table = array();
		foreach ($collection as $object):
			$object_table[strval($object->getId())] = $object->getName();
		endforeach;
		return $object_table;
	}

	/* retourne les groupes de tout les operateur  */
	public static function getGroupesDesOperateurs()
	{
		$tabGroupe = array('Receptionneur', 'Cariste', 'Magasinier');
		$q = Doctrine_Query::create()->from('sfGuardGroup s')
			->whereIn('s.name', $tabGroupe);
		return $q->execute();
	}

	// Fonction qui permet de verifier si le nom du groupe existe d�ja dans la table sfGuardGroup
	public function controlNomGroupe($nom, $id) {
		$req=Doctrine_Query::CREATE()->from('sfGuardGroup');
		$req->addWhere('name = ?',$nom);
		if($id) {
			$req->addWhere('id != ?',$id);
		}
		return $req->execute();
	}

}