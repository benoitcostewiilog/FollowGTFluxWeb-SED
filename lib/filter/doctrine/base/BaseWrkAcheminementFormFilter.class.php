<?php

/**
 * WrkAcheminement filter form base class.
 *
 * @package    MobileStockV3
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWrkAcheminementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'num_acheminement'        => new sfWidgetFormFilterInput(),
      'suffix_colis'            => new sfWidgetFormFilterInput(),
      'nb_colis'                => new sfWidgetFormFilterInput(),
      'tracking'                => new sfWidgetFormFilterInput(),
      'ref_produit'             => new sfWidgetFormFilterInput(),
      'code_emplacement_prise'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacementPrise'), 'add_empty' => true)),
      'code_emplacement_depose' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefEmplacementDepose'), 'add_empty' => true)),
      'delais'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_utilisateur'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RefDestinataireAcheminement'), 'add_empty' => true)),
      'date_fait'               => new sfWidgetFormFilterInput(),
      'statut'                  => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'num_acheminement'        => new sfValidatorPass(array('required' => false)),
      'suffix_colis'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nb_colis'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tracking'                => new sfValidatorPass(array('required' => false)),
      'ref_produit'             => new sfValidatorPass(array('required' => false)),
      'code_emplacement_prise'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefEmplacementPrise'), 'column' => 'code_emplacement')),
      'code_emplacement_depose' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefEmplacementDepose'), 'column' => 'code_emplacement')),
      'delais'                  => new sfValidatorPass(array('required' => false)),
      'id_utilisateur'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RefDestinataireAcheminement'), 'column' => 'id_destinataire_acheminement')),
      'date_fait'               => new sfValidatorPass(array('required' => false)),
      'statut'                  => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('wrk_acheminement_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WrkAcheminement';
  }

  public function getFields()
  {
    return array(
      'id_acheminement'         => 'Number',
      'num_acheminement'        => 'Text',
      'suffix_colis'            => 'Number',
      'nb_colis'                => 'Number',
      'tracking'                => 'Text',
      'ref_produit'             => 'Text',
      'code_emplacement_prise'  => 'ForeignKey',
      'code_emplacement_depose' => 'ForeignKey',
      'delais'                  => 'Text',
      'id_utilisateur'          => 'ForeignKey',
      'date_fait'               => 'Text',
      'statut'                  => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
    );
  }
}
