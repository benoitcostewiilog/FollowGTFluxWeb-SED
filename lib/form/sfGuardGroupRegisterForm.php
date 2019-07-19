<?php

class sfGuardGroupRegisterForm extends sfGuardGroupForm {

    public function configure() {
        //charge le dictionnaire de traduction des formulaires
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('formulaires');
        parent::configure();
        //desactivation du champ utilisateurs
        unset($this['users_list']);
        //Les champs nom et description deviennent obligatoires
        $this->validatorSchema['name']->setOption('required', true);
        $this->validatorSchema['description']->setOption('required', true);

        $this->widgetSchema['name'] = new sfWidgetFormInput(array('label' => 'Nom du groupe'), array('class' => 'form-control'));

        $this->widgetSchema['description'] = new sfWidgetFormInput(array('label' => 'Description'), array('class' => 'form-control'));

        //formulaire d'ajout de widget
        $this->widgetSchema['widget_list'] = new sfWidgetFormChoice(array('choices' => RefWidgetTable::getInstance()->findAll()->toKeyValueArray('id_widget', 'name'), 'multiple' => true,));
        $this->validatorSchema['widget_list'] = new sfValidatorChoice(array('choices' => array_keys(RefWidgetTable::getInstance()->findAll()->toKeyValueArray('id_widget', 'name')), 'multiple' => true, 'required' => false));
        $this->widgetSchema['widget_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    }

    /*  personnalise le formulaire en fonction des permissions utilisateurs */

    public function personnalise($user, $id_user = null) {
        if ($user->hasCredential('gestion des utilisateurs niveau 2')) {
            //la liste comporte toute les permissions, le validateur reste tel quel
            $this->widgetSchema['permissions_list'] = new sfWidgetFormChoice(array('choices' => sfGuardPermissionTable::getAllPermissions(), 'multiple' => true,));
        }
        if ($user->hasCredential('gestion des utilisateurs niveau 1')) {
            //la liste comporte toute les permissions non avanc�e
            $this->widgetSchema['permissions_list'] = new sfWidgetFormChoice(array('choices' => sfGuardPermissionTable::getBasicsPermissions(), 'multiple' => true,));
            //modification du validateur pour verifier la contrainte
            $this->validatorSchema['permissions_list'] = new sfValidatorChoice(array('choices' => array_keys(sfGuardPermissionTable::getBasicsPermissions()), 'multiple' => true, 'required' => false));
        }
        // if (isset($id_user) && $user->getGuardUser()->getId() == $id_user) 	{}
        //initialise une double liste pour les permissions
        $this->widgetSchema['permissions_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');
    }

    public function configureWidget($idGroup) {
        //Recupere les widgets trie par ordre
        $this->widgetSchema['widget_list'] = new sfWidgetFormChoice(array('choices' => RefWidgetTable::getInstance()->getAllWidgetSortByOrdre($idGroup)->toKeyValueArray('id_widget', 'name'), 'multiple' => true,));
        $this->validatorSchema['widget_list'] = new sfValidatorChoice(array('choices' => array_keys(RefWidgetTable::getInstance()->findAll()->toKeyValueArray('id_widget', 'name')), 'multiple' => true, 'required' => false));
        $this->widgetSchema['widget_list']->setOption('renderer_class', 'sfWidgetFormSelectDoubleList');

        $widgets = array_keys(WrkGroupWidgetTable::getInstance()->findBy('group_id', $idGroup)
                        ->toKeyValueArray('id_widget', 'group_id'));
        $this->setDefault('widget_list', $widgets);
    }

}
