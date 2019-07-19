<?php

/**
 * RefFerie form base class.
 *
 * @method RefFerie getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRefFerieForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_ferie' => new sfWidgetFormInputHidden(),
      'date'     => new sfWidgetFormDate(),
      'libelle'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_ferie' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_ferie')), 'empty_value' => $this->getObject()->get('id_ferie'), 'required' => false)),
      'date'     => new sfValidatorDate(),
      'libelle'  => new sfValidatorString(array('max_length' => 30)),
    ));

    $this->widgetSchema->setNameFormat('ref_ferie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefFerie';
  }

}
