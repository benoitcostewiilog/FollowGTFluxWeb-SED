<?php

/**
 * AdmParametrage form base class.
 *
 * @method AdmParametrage getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAdmParametrageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_parametrage'  => new sfWidgetFormInputHidden(),
      'nom_parametrage' => new sfWidgetFormInputText(),
      'actif'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_parametrage'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_parametrage')), 'empty_value' => $this->getObject()->get('id_parametrage'), 'required' => false)),
      'nom_parametrage' => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'actif'           => new sfValidatorString(array('max_length' => 45, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('adm_parametrage[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdmParametrage';
  }

}
