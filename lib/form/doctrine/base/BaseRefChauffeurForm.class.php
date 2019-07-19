<?php

/**
 * RefChauffeur form base class.
 *
 * @method RefChauffeur getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRefChauffeurForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_chauffeur'    => new sfWidgetFormInputHidden(),
      'nom'             => new sfWidgetFormInputText(),
      'prenom'          => new sfWidgetFormInputText(),
      'num_doc_id'      => new sfWidgetFormInputText(),
      'id_transporteur' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefTransporteur'), 'add_empty' => true)),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_chauffeur'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_chauffeur')), 'empty_value' => $this->getObject()->get('id_chauffeur'), 'required' => false)),
      'nom'             => new sfValidatorString(array('max_length' => 45)),
      'prenom'          => new sfValidatorString(array('max_length' => 45)),
      'num_doc_id'      => new sfValidatorString(array('max_length' => 45)),
      'id_transporteur' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefTransporteur'), 'required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ref_chauffeur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefChauffeur';
  }

}
