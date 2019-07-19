<?php

/**
 * AdmParametrage filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAdmParametrageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom_parametrage' => new sfWidgetFormFilterInput(),
      'actif'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nom_parametrage' => new sfValidatorPass(array('required' => false)),
      'actif'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('adm_parametrage_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdmParametrage';
  }

  public function getFields()
  {
    return array(
      'id_parametrage'  => 'Number',
      'nom_parametrage' => 'Text',
      'actif'           => 'Text',
    );
  }
}
