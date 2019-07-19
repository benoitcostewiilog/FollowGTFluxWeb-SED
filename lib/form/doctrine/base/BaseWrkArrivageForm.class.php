<?php

/**
 * WrkArrivage form base class.
 *
 * @method WrkArrivage getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWrkArrivageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_arrivage'     => new sfWidgetFormInputHidden(),
      'id_fournisseur'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefFournisseur'), 'add_empty' => false)),
      'id_transporteur' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefTransporteur'), 'add_empty' => false)),
      'id_chauffeur'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefChauffeur'), 'add_empty' => true)),
      'lettre_voiture'  => new sfWidgetFormInputText(),
      'nb_colis'        => new sfWidgetFormInputText(),
      'nb_palette'      => new sfWidgetFormInputText(),
      'immatriculation' => new sfWidgetFormInputText(),
      'rep_signature'   => new sfWidgetFormTextarea(),
      'id_nature'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'add_empty' => true)),
      'br_sap'          => new sfWidgetFormTextarea(),
      'statut'          => new sfWidgetFormTextarea(),
      'commentaire'     => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_arrivage'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_arrivage')), 'empty_value' => $this->getObject()->get('id_arrivage'), 'required' => false)),
      'id_fournisseur'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefFournisseur'), 'required' => false)),
      'id_transporteur' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefTransporteur'), 'required' => false)),
      'id_chauffeur'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefChauffeur'), 'required' => false)),
      'lettre_voiture'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'nb_colis'        => new sfValidatorInteger(array('required' => false)),
      'nb_palette'      => new sfValidatorInteger(array('required' => false)),
      'immatriculation' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'rep_signature'   => new sfValidatorString(array('required' => false)),
      'id_nature'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'required' => false)),
      'br_sap'          => new sfValidatorString(array('required' => false)),
      'statut'          => new sfValidatorString(),
      'commentaire'     => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wrk_arrivage[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkArrivage';
  }

}
