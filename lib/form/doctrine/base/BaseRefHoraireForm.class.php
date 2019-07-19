<?php

/**
 * RefHoraire form base class.
 *
 * @method RefHoraire getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRefHoraireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_horaire'  => new sfWidgetFormInputHidden(),
      'jour'        => new sfWidgetFormInputText(),
      'fermer'      => new sfWidgetFormInputCheckbox(),
      'heure_debut' => new sfWidgetFormTime(),
      'heure_fin'   => new sfWidgetFormTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_horaire'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_horaire')), 'empty_value' => $this->getObject()->get('id_horaire'), 'required' => false)),
      'jour'        => new sfValidatorInteger(),
      'fermer'      => new sfValidatorBoolean(),
      'heure_debut' => new sfValidatorTime(array('required' => false)),
      'heure_fin'   => new sfValidatorTime(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ref_horaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefHoraire';
  }

}
