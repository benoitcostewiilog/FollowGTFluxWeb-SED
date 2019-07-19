<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AdmParametrage', 'doctrine');

/**
 * BaseAdmParametrage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_parametrage
 * @property string $nom_parametrage
 * @property string $actif
 * 
 * @method integer        getId_parametrage()  Returns the current record's "id_parametrage" value
 * @method string         getNom_parametrage() Returns the current record's "nom_parametrage" value
 * @method string         getActif()           Returns the current record's "actif" value
 * @method AdmParametrage setId_parametrage()  Sets the current record's "id_parametrage" value
 * @method AdmParametrage setNom_parametrage() Sets the current record's "nom_parametrage" value
 * @method AdmParametrage setActif()           Sets the current record's "actif" value
 * 
 * @package    MobileStockV3
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAdmParametrage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('adm_parametrage');
        $this->hasColumn('id_parametrage', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('nom_parametrage', 'string', 25, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('actif', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 45,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}