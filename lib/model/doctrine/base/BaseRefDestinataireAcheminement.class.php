<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('RefDestinataireAcheminement', 'doctrine');

/**
 * BaseRefDestinataireAcheminement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_destinataire_acheminement
 * @property string $destinataire
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Doctrine_Collection $WrkAcheminement
 * 
 * @method integer                     getId_destInataIre_achemInement() Returns the current record's "id_destinataire_acheminement" value
 * @method string                      getDestinataire()                 Returns the current record's "destinataire" value
 * @method timestamp                   getCreated_at()                   Returns the current record's "created_at" value
 * @method timestamp                   getUpdated_at()                   Returns the current record's "updated_at" value
 * @method Doctrine_Collection         getWrkAcheminement()              Returns the current record's "WrkAcheminement" collection
 * @method RefDestinataireAcheminement setId_destInataIre_achemInement() Sets the current record's "id_destinataire_acheminement" value
 * @method RefDestinataireAcheminement setDestinataire()                 Sets the current record's "destinataire" value
 * @method RefDestinataireAcheminement setCreated_at()                   Sets the current record's "created_at" value
 * @method RefDestinataireAcheminement setUpdated_at()                   Sets the current record's "updated_at" value
 * @method RefDestinataireAcheminement setWrkAcheminement()              Sets the current record's "WrkAcheminement" collection
 * 
 * @package    MobileStockV3
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRefDestinataireAcheminement extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ref_destinataire_acheminement');
        $this->hasColumn('id_destinataire_acheminement', 'integer', 11, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 11,
             ));
        $this->hasColumn('destinataire', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 45,
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
        $this->hasMany('WrkAcheminement', array(
             'local' => 'id_destinataire_acheminement',
             'foreign' => 'id_utilisateur'));
    }
}