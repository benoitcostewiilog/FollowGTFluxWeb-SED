<?php

/**
 * WrkExpeditionProduit form base class.
 *
 * @method WrkExpeditionProduit getObject() Returns the current form's model object
 *
 * @package    MobileStockV3
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWrkExpeditionProduitForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_expedition_produit' => new sfWidgetFormInputHidden(),
      'id_expedition'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkExpedition'), 'add_empty' => false)),
      'ref_produit'           => new sfWidgetFormInputText(),
      'br_sap'                => new sfWidgetFormInputText(),
      'id_nature'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_expedition_produit' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_expedition_produit')), 'empty_value' => $this->getObject()->get('id_expedition_produit'), 'required' => false)),
      'id_expedition'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WrkExpedition'), 'required' => false)),
      'ref_produit'           => new sfValidatorString(array('max_length' => 45)),
      'br_sap'                => new sfValidatorString(array('max_length' => 45)),
      'id_nature'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wrk_expedition_produit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkExpeditionProduit';
  }

}
