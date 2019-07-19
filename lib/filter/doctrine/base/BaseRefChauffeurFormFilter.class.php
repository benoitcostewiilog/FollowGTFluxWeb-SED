<?php

/**
 * RefChauffeur filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRefChauffeurFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'num_doc_id'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_transporteur' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefTransporteur'), 'add_empty' => true)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'nom'             => new sfValidatorPass(array('required' => false)),
      'prenom'          => new sfValidatorPass(array('required' => false)),
      'num_doc_id'      => new sfValidatorPass(array('required' => false)),
      'id_transporteur' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefTransporteur'), 'column' => 'id_transporteur')),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('ref_chauffeur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefChauffeur';
  }

  public function getFields()
  {
    return array(
      'id_chauffeur'    => 'Text',
      'nom'             => 'Text',
      'prenom'          => 'Text',
      'num_doc_id'      => 'Text',
      'id_transporteur' => 'ForeignKey',
      'updated_at'      => 'Date',
      'created_at'      => 'Date',
    );
  }
}
