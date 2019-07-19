<?php

/**
 * sfGuardUser form.
 *
 * @package    chronos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
  	$this->widgetSchema['role'] = new sfWidgetFormInputText(array());

  	$this->widgetSchema['tel'] = new sfWidgetFormInputText(array());

  	$this->widgetSchema['adresse'] = new sfWidgetFormInputText(array());

  	$this->widgetSchema['codep'] = new sfWidgetFormInputText(array());

  	$this->widgetSchema['ville'] = new sfWidgetFormInputText(array());

  	$this->widgetSchema['photo'] = new sfWidgetFormInputFile(array());
	
	$this->validatorSchema['adresse'] = new sfValidatorString(array('required' =>false));
	$this->validatorSchema['tel'] = new sfValidatorString(array('required' =>false));
	$this->validatorSchema['codep'] = new sfValidatorString(array('required' =>false));
	$this->validatorSchema['ville'] = new sfValidatorString(array('required' =>false));
	$this->validatorSchema['role'] = new sfValidatorString(array('required' =>false));
  }
}
