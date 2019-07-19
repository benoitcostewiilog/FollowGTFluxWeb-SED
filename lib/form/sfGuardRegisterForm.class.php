<?php
class sfGuardRegisterForm extends sfGuardUserForm
{
  public function configure()
  {
    parent::configure();
	//charge le dictionnaire de traduction des formulaires
	$this->widgetSchema->getFormFormatter()->setTranslationCatalogue('formulaires');
	//desactivation des champs non modifiable
	unset(
      $this['created_at'], $this['updated_at'],
      $this['algorithm'], $this['salt'],
	  $this['last_login'], $this['permissions_list'], $this['is_super_admin']
    );

	$this->widgetSchema['username'] = new sfWidgetFormInput(array('label' => 'Nom d\'utilisateu'), array('class' => 'form-control'));

	//modification du champs pour le mot de passe
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array('label' => 'Mot de passe'), array('class' => 'form-control'));
	// validation pour le mot de passe: 6 car min et 20 car max
	$this->validatorSchema['password'] = new sfValidatorString(array('min_length' => 6, 'max_length' => 20),
																array(  'min_length' => '"%value%" is incorrect, must be at least %min_length% characters.',
																		'max_length' => '"%value%" is incorrect, must not exceed %max_length% characters.',) );
	$this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array('label' => 'Confirmation'), array('class' => 'form-control'));
	$this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->widgetSchema->moveField('password_again', 'after', 'password');
	//le mdp et la confirmation doivent etre egaux
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The 2 passwords must be equal')));

    	//modification du champs pour le mot de passe nomade
    $this->widgetSchema['password_nomade'] = new sfWidgetFormInput(array('label' => 'Mot de passe nomade'), array('class' => 'form-control'));
	// validation pour le mot de passe: 1 car min et 20 car max
	$this->validatorSchema['password_nomade'] = new sfValidatorString();
	$this->validatorSchema['password_nomade']->setOption('required', false);

  }

  /*  personnalise le formulaire en fonction des permissions utilisateurs */
  public function personnalise($user, $id_user = null)
  {


	if ($user->hasCredential('gestion des utilisateurs niveau 1')){

		//modifie la liste deroulante groupe pour ne faire apparaitre que les groupe inferieurs
		//$this->widgetSchema['groups_list']  = new sfWidgetFormChoice(array('choices' => sfGuardGroupTable::getGroupsWithBasicsRights(),  'multiple' => false, ));
		$this->widgetSchema['groups_list']  = new sfWidgetFormChoice(array('choices' => sfGuardGroupTable::getAllGroups(),  'multiple' => true, ));
		//ajout d'un validateur qui verifie la contrainte + laisser multiple a true sinon plantage
		//$this->validatorSchema['groups_list']=  new sfValidatorChoice(array('choices' => array_keys(sfGuardGroupTable::getGroupsWithBasicsRights()),  'multiple' => true, ));
		$this->validatorSchema['groups_list']=  new sfValidatorChoice(array('choices' => array_keys(sfGuardGroupTable::getAllGroups()),  'multiple' => true, ));
	}
	if ($user->hasCredential('gestion des utilisateurs niveau 2')){
		// la liste deroulante devient unique et comporte tous les groupes
		$this->widgetSchema['groups_list'] =  new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup'));
		//laisser multiple a true sinon plantage
		$this->validatorSchema['groups_list']=  new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => true));
	}

  }

}