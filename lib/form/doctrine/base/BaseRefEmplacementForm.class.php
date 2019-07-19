<?php

/**
 * RefEmplacement form base class.
 *
 * @method RefEmplacement getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRefEmplacementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'code_emplacement' => new sfWidgetFormInputHidden(),
      'libelle'          => new sfWidgetFormInputText(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'code_emplacement' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('code_emplacement')), 'empty_value' => $this->getObject()->get('code_emplacement'), 'required' => false)),
      'libelle'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ref_emplacement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefEmplacement';
  }

}
