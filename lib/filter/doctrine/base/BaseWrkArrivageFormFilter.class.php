<?php

/**
 * WrkArrivage filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWrkArrivageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_fournisseur'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefFournisseur'), 'add_empty' => true)),
      'id_transporteur' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefTransporteur'), 'add_empty' => true)),
      'id_chauffeur'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefChauffeur'), 'add_empty' => true)),
      'lettre_voiture'  => new sfWidgetFormFilterInput(),
      'nb_colis'        => new sfWidgetFormFilterInput(),
      'nb_palette'      => new sfWidgetFormFilterInput(),
      'immatriculation' => new sfWidgetFormFilterInput(),
      'rep_signature'   => new sfWidgetFormFilterInput(),
      'id_nature'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefNature'), 'add_empty' => true)),
      'br_sap'          => new sfWidgetFormFilterInput(),
      'statut'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'commentaire'     => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_fournisseur'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefFournisseur'), 'column' => 'id_fournisseur')),
      'id_transporteur' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefTransporteur'), 'column' => 'id_transporteur')),
      'id_chauffeur'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefChauffeur'), 'column' => 'id_chauffeur')),
      'lettre_voiture'  => new sfValidatorPass(array('required' => false)),
      'nb_colis'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nb_palette'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'immatriculation' => new sfValidatorPass(array('required' => false)),
      'rep_signature'   => new sfValidatorPass(array('required' => false)),
      'id_nature'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefNature'), 'column' => 'id_nature')),
      'br_sap'          => new sfValidatorPass(array('required' => false)),
      'statut'          => new sfValidatorPass(array('required' => false)),
      'commentaire'     => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('wrk_arrivage_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkArrivage';
  }

  public function getFields()
  {
    return array(
      'id_arrivage'     => 'Number',
      'id_fournisseur'  => 'ForeignKey',
      'id_transporteur' => 'ForeignKey',
      'id_chauffeur'    => 'ForeignKey',
      'lettre_voiture'  => 'Text',
      'nb_colis'        => 'Number',
      'nb_palette'      => 'Number',
      'immatriculation' => 'Text',
      'rep_signature'   => 'Text',
      'id_nature'       => 'ForeignKey',
      'br_sap'          => 'Text',
      'statut'          => 'Text',
      'commentaire'     => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
