<?php

/**
 * WrkAcheminement form base class.
 *
 * @method WrkAcheminement getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWrkAcheminementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_acheminement'         => new sfWidgetFormInputHidden(),
      'num_acheminement'        => new sfWidgetFormInputText(),
      'suffix_colis'            => new sfWidgetFormInputText(),
      'nb_colis'                => new sfWidgetFormInputText(),
      'tracking'                => new sfWidgetFormInputText(),
      'ref_produit'             => new sfWidgetFormInputText(),
      'code_emplacement_prise'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacementPrise'), 'add_empty' => false)),
      'code_emplacement_depose' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacementDepose'), 'add_empty' => false)),
      'delais'                  => new sfWidgetFormInputText(),
      'id_utilisateur'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefDestinataireAcheminement'), 'add_empty' => true)),
      'date_fait'               => new sfWidgetFormInputText(),
      'statut'                  => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_acheminement'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_acheminement')), 'empty_value' => $this->getObject()->get('id_acheminement'), 'required' => false)),
      'num_acheminement'        => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'suffix_colis'            => new sfValidatorInteger(array('required' => false)),
      'nb_colis'                => new sfValidatorInteger(array('required' => false)),
      'tracking'                => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'ref_produit'             => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'code_emplacement_prise'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacementPrise'), 'required' => false)),
      'code_emplacement_depose' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacementDepose'), 'required' => false)),
      'delais'                  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'id_utilisateur'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefDestinataireAcheminement'), 'required' => false)),
      'date_fait'               => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'statut'                  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
      'updated_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wrk_acheminement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkAcheminement';
  }

}
