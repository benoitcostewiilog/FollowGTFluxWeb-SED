<?php

class sfGuardPermissionTable extends PluginsfGuardPermissionTable
{
	public static function getBasicsPermissions()
	{
		$q = Doctrine_Query::create()->from('sfGuardPermission s')
		->andwhere("name <> 'gestion des utilisateurs niveau 2'");
		return self::toTable($q->execute());
	}

	public static function getAllPermissions()
	{
		$q = Doctrine_Query::create()->from('sfGuardPermission s');
		return self::toTable($q->execute());
	}

	public static function toTable($collection)
	{
		$object_table = array();
		foreach ($collection as $object):
			$object_table[strval($object->getId())] = $object->getName();
		endforeach;
		return $object_table;
	}

}