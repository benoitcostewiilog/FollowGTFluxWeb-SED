<?php

/**
 * WrkArrivageProduit filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWrkArrivageProduitFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_arrivage'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkArrivage'), 'add_empty' => true)),
      'ref_produit'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'br_sap'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkMouvement'), 'add_empty' => true)),
      'id_nature'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'add_empty' => true)),
      'id_utilisateur'      => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_arrivage'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WrkArrivage'), 'column' => 'id_arrivage')),
      'ref_produit'         => new sfValidatorPass(array('required' => false)),
      'br_sap'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WrkMouvement'), 'column' => 'id_mouvement')),
      'id_nature'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefNature'), 'column' => 'id_nature')),
      'id_utilisateur'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('wrk_arrivage_produit_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkArrivageProduit';
  }

  public function getFields()
  {
    return array(
      'id_arrivage_produit' => 'Number',
      'id_arrivage'         => 'ForeignKey',
      'ref_produit'         => 'Text',
      'br_sap'              => 'ForeignKey',
      'id_nature'           => 'ForeignKey',
      'id_utilisateur'      => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
