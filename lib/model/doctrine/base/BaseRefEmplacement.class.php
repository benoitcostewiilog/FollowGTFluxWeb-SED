<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('RefEmplacement', 'doctrine');

/**
 * BaseRefEmplacement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $code_emplacement
 * @property string $libelle
 * @property timestamp $updated_at
 * @property timestamp $created_at
 * @property Doctrine_Collection $WrkMouvement
 * @property Doctrine_Collection $RefInterlocuteur
 * @property Doctrine_Collection $WrkAcheminement
 * @property Doctrine_Collection $WrkInventaire
 * 
 * @method string              getCode_emplaCement() Returns the current record's "code_emplacement" value
 * @method string              getLibeLLe()          Returns the current record's "libelle" value
 * @method timestamp           getUpdated_at()       Returns the current record's "updated_at" value
 * @method timestamp           getCreated_at()       Returns the current record's "created_at" value
 * @method Doctrine_Collection getWrkMouvement()     Returns the current record's "WrkMouvement" collection
 * @method Doctrine_Collection getRefInterlocuteur() Returns the current record's "RefInterlocuteur" collection
 * @method Doctrine_Collection getWrkAcheminement()  Returns the current record's "WrkAcheminement" collection
 * @method Doctrine_Collection getWrkInventaire()    Returns the current record's "WrkInventaire" collection
 * @method RefEmplacement      setCode_emplaCement() Sets the current record's "code_emplacement" value
 * @method RefEmplacement      setLibeLLe()          Sets the current record's "libelle" value
 * @method RefEmplacement      setUpdated_at()       Sets the current record's "updated_at" value
 * @method RefEmplacement      setCreated_at()       Sets the current record's "created_at" value
 * @method RefEmplacement      setWrkMouvement()     Sets the current record's "WrkMouvement" collection
 * @method RefEmplacement      setRefInterlocuteur() Sets the current record's "RefInterlocuteur" collection
 * @method RefEmplacement      setWrkAcheminement()  Sets the current record's "WrkAcheminement" collection
 * @method RefEmplacement      setWrkInventaire()    Sets the current record's "WrkInventaire" collection
 * 
 * @package    MobileStockV3
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRefEmplacement extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ref_emplacement');
        $this->hasColumn('code_emplacement', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('libelle', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 100,
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
        $this->hasColumn('created_at', 'timestamp', 25, array(
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
        $this->hasMany('WrkMouvement', array(
             'local' => 'code_emplacement',
             'foreign' => 'code_emplacement'));

        $this->hasMany('RefInterlocuteur', array(
             'local' => 'code_emplacement',
             'foreign' => 'id_emplacement'));

        $this->hasMany('WrkAcheminement', array(
             'local' => 'code_emplacement',
             'foreign' => 'code_emplacement_prise'));

        $this->hasMany('WrkInventaire', array(
             'local' => 'code_emplacement',
             'foreign' => 'code_emplacement'));
    }
}