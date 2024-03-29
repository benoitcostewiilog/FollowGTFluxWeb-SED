<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('WrkInventaire', 'doctrine');

/**
 * BaseWrkInventaire
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_inventaire
 * @property integer $id_utilisateur
 * @property timestamp $heure_prise
 * @property string $ref_produit
 * @property string $code_emplacement
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property RefEmplacement $RefEmplacement
 * 
 * @method integer        getId_InventaIre()    Returns the current record's "id_inventaire" value
 * @method integer        getId_utIlIsateur()   Returns the current record's "id_utilisateur" value
 * @method timestamp      getHeure_prise()      Returns the current record's "heure_prise" value
 * @method string         getRef_pRoduit()      Returns the current record's "ref_produit" value
 * @method string         getCode_emplaCement() Returns the current record's "code_emplacement" value
 * @method timestamp      getCreated_at()       Returns the current record's "created_at" value
 * @method timestamp      getUpdated_at()       Returns the current record's "updated_at" value
 * @method RefEmplacement getRefEmplacement()   Returns the current record's "RefEmplacement" value
 * @method WrkInventaire  setId_InventaIre()    Sets the current record's "id_inventaire" value
 * @method WrkInventaire  setId_utIlIsateur()   Sets the current record's "id_utilisateur" value
 * @method WrkInventaire  setHeure_prise()      Sets the current record's "heure_prise" value
 * @method WrkInventaire  setRef_pRoduit()      Sets the current record's "ref_produit" value
 * @method WrkInventaire  setCode_emplaCement() Sets the current record's "code_emplacement" value
 * @method WrkInventaire  setCreated_at()       Sets the current record's "created_at" value
 * @method WrkInventaire  setUpdated_at()       Sets the current record's "updated_at" value
 * @method WrkInventaire  setRefEmplacement()   Sets the current record's "RefEmplacement" value
 * 
 * @package    MobileStockV3
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWrkInventaire extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('wrk_inventaire');
        $this->hasColumn('id_inventaire', 'integer', 11, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 11,
             ));
        $this->hasColumn('id_utilisateur', 'integer', 11, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 11,
             ));
        $this->hasColumn('heure_prise', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('ref_produit', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 45,
             ));
        $this->hasColumn('code_emplacement', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('RefEmplacement', array(
             'local' => 'code_emplacement',
             'foreign' => 'code_emplacement'));
    }
}