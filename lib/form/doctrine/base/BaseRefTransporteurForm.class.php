<?php

/**
 * RefTransporteur form base class.
 *
 * @method RefTransporteur getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRefTransporteurForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_transporteur' => new sfWidgetFormInputHidden(),
      'libelle'         => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_transporteur' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_transporteur')), 'empty_value' => $this->getObject()->get('id_transporteur'), 'required' => false)),
      'libelle'         => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ref_transporteur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefTransporteur';
  }

}
