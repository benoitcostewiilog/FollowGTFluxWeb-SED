<?php

/**
 * WrkMouvement filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWrkMouvementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_utilisateur'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'heure_prise'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'ref_produit'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WrkArrivageProduit'), 'add_empty' => true)),
      'br_sap'           => new sfWidgetFormFilterInput(),
      'code_emplacement' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacement'), 'add_empty' => true)),
      'retry'            => new sfWidgetFormFilterInput(),
      'type'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'groupe'           => new sfWidgetFormFilterInput(),
      'commentaire'      => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_utilisateur'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'heure_prise'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'ref_produit'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WrkArrivageProduit'), 'column' => 'id_arrivage_produit')),
      'br_sap'           => new sfValidatorPass(array('required' => false)),
      'code_emplacement' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefEmplacement'), 'column' => 'code_emplacement')),
      'retry'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'             => new sfValidatorPass(array('required' => false)),
      'groupe'           => new sfValidatorPass(array('required' => false)),
      'commentaire'      => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('wrk_mouvement_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkMouvement';
  }

  public function getFields()
  {
    return array(
      'id_mouvement'     => 'Number',
      'id_utilisateur'   => 'Number',
      'heure_prise'      => 'Date',
      'ref_produit'      => 'ForeignKey',
      'br_sap'           => 'Text',
      'code_emplacement' => 'ForeignKey',
      'retry'            => 'Number',
      'type'             => 'Text',
      'groupe'           => 'Text',
      'commentaire'      => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
