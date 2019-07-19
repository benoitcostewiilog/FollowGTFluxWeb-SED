<?php

/**
 * WrkMouvement form base class.
 *
 * @method WrkMouvement getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWrkMouvementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_mouvement'     => new sfWidgetFormInputHidden(),
      'id_utilisateur'   => new sfWidgetFormInputText(),
      'heure_prise'      => new sfWidgetFormDateTime(),
      'ref_produit'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkArrivageProduit'), 'add_empty' => true)),
      'br_sap'           => new sfWidgetFormInputText(),
      'code_emplacement' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacement'), 'add_empty' => false)),
      'retry'            => new sfWidgetFormInputText(),
      'type'             => new sfWidgetFormInputText(),
      'groupe'           => new sfWidgetFormInputText(),
      'commentaire'      => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_mouvement'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_mouvement')), 'empty_value' => $this->getObject()->get('id_mouvement'), 'required' => false)),
      'id_utilisateur'   => new sfValidatorInteger(array('required' => false)),
      'heure_prise'      => new sfValidatorDateTime(array('required' => false)),
      'ref_produit'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WrkArrivageProduit'), 'required' => false)),
      'br_sap'           => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'code_emplacement' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacement'), 'required' => false)),
      'retry'            => new sfValidatorInteger(array('required' => false)),
      'type'             => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'groupe'           => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'commentaire'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wrk_mouvement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkMouvement';
  }

}
