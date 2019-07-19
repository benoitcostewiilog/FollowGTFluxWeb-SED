<?php
/*
Personnalisation du formulaire d'authentification de sf Guard
*/
class LoginForm extends BasesfGuardFormSignin
{
  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInput(array('label' => 'Identifiant :'), array('class' => 'form-control', 'placeholder' => 'Identifiant')),
      'password' => new sfWidgetFormInput(array('type' => 'password','label' => 'Mot de passe :'), array('class' => 'form-control', 'placeholder' => 'Mot de passe')),
      'remember' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'username' => new sfValidatorString(),
      'password' => new sfValidatorString(),
      'remember' => new sfValidatorBoolean(),
    ));

    $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());

    $this->widgetSchema->setNameFormat('signin[%s]');
  }
}