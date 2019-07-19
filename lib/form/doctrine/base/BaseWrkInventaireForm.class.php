<?php

/**
 * WrkInventaire form base class.
 *
 * @method WrkInventaire getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWrkInventaireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_inventaire'    => new sfWidgetFormInputHidden(),
      'id_utilisateur'   => new sfWidgetFormInputText(),
      'heure_prise'      => new sfWidgetFormDateTime(),
      'ref_produit'      => new sfWidgetFormInputText(),
      'code_emplacement' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacement'), 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_inventaire'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_inventaire')), 'empty_value' => $this->getObject()->get('id_inventaire'), 'required' => false)),
      'id_utilisateur'   => new sfValidatorInteger(array('required' => false)),
      'heure_prise'      => new sfValidatorDateTime(array('required' => false)),
      'ref_produit'      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'code_emplacement' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacement'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wrk_inventaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkInventaire';
  }

}
