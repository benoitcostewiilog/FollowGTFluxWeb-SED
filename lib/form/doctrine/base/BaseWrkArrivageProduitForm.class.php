<?php

/**
 * WrkArrivageProduit form base class.
 *
 * @method WrkArrivageProduit getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWrkArrivageProduitForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_arrivage_produit' => new sfWidgetFormInputHidden(),
      'id_arrivage'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkArrivage'), 'add_empty' => true)),
      'ref_produit'         => new sfWidgetFormInputText(),
      'br_sap'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkMouvement'), 'add_empty' => false)),
      'id_nature'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'add_empty' => true)),
      'id_utilisateur'      => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_arrivage_produit' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_arrivage_produit')), 'empty_value' => $this->getObject()->get('id_arrivage_produit'), 'required' => false)),
      'id_arrivage'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WrkArrivage'), 'required' => false)),
      'ref_produit'         => new sfValidatorString(array('max_length' => 45)),
      'br_sap'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WrkMouvement'))),
      'id_nature'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'required' => false)),
      'id_utilisateur'      => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wrk_arrivage_produit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkArrivageProduit';
  }

}
