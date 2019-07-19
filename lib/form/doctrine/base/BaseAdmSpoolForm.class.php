<?php

/**
 * AdmSpool form base class.
 *
 * @method AdmSpool getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAdmSpoolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_spool'   => new sfWidgetFormInputHidden(),
      'code_etiq'  => new sfWidgetFormInputText(),
      'nb_etiq'    => new sfWidgetFormInputText(),
      'parametres' => new sfWidgetFormInputText(),
      'imprimante' => new sfWidgetFormInputText(),
      'imprimee'   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_spool'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_spool')), 'empty_value' => $this->getObject()->get('id_spool'), 'required' => false)),
      'code_etiq'  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nb_etiq'    => new sfValidatorPass(),
      'parametres' => new sfValidatorString(array('max_length' => 200)),
      'imprimante' => new sfValidatorString(array('max_length' => 200)),
      'imprimee'   => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('adm_spool[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdmSpool';
  }

}
