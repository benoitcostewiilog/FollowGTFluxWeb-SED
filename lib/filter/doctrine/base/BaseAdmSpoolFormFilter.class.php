<?php

/**
 * AdmSpool filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAdmSpoolFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'code_etiq'  => new sfWidgetFormFilterInput(),
      'nb_etiq'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'parametres' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'imprimante' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'imprimee'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'code_etiq'  => new sfValidatorPass(array('required' => false)),
      'nb_etiq'    => new sfValidatorPass(array('required' => false)),
      'parametres' => new sfValidatorPass(array('required' => false)),
      'imprimante' => new sfValidatorPass(array('required' => false)),
      'imprimee'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('adm_spool_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdmSpool';
  }

  public function getFields()
  {
    return array(
      'id_spool'   => 'Text',
      'code_etiq'  => 'Text',
      'nb_etiq'    => 'Text',
      'parametres' => 'Text',
      'imprimante' => 'Text',
      'imprimee'   => 'Boolean',
    );
  }
}
