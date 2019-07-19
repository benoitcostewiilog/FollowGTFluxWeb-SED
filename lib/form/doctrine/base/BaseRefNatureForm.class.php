<?php

/**
 * RefNature form base class.
 *
 * @method RefNature getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRefNatureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_nature'  => new sfWidgetFormInputHidden(),
      'libelle'    => new sfWidgetFormInputText(),
      'delais'     => new sfWidgetFormTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_nature'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_nature')), 'empty_value' => $this->getObject()->get('id_nature'), 'required' => false)),
      'libelle'    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'delais'     => new sfValidatorTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ref_nature[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefNature';
  }

}
