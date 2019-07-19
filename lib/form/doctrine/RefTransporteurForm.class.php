<?php

/**
 * RefTransporteur form.
 *
 * @package    dev.mobilestock.fr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RefTransporteurForm extends BaseRefTransporteurForm
{
  public function configure()
  {

  	//redefinition des widgets
  	$this->widgetSchema['code_transp']  = new sfWidgetFormInputText();
  	$this->validatorSchema['code_transp']  = new sfValidatorString();
  	$this->widgetSchema['code_transp']->setLabel('Code transporteur');

  }
}
