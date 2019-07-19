<?php

/* On doit inclure manuellement
  l'action du plugin car l'autoloading ne fonctionne pas dans ce cas. */
require_once(sfConfig::get('sf_plugins_dir') .
        '/sfDoctrineGuardPlugin/modules/sfGuardGroup/lib/BasesfGuardGroupActions.class.php');

/* l'action dérive de celle fournie par le module afin d'hériter de ses actions propres. */

class sfGuardGroupActions extends BasesfGuardGroupActions {
    /* action listant tous les groupes */

    public function executeListe($request) {
        $this->groupes = Doctrine::getTable('SfGuardGroup')->createQuery('a')->execute();
    }

    /* action affichant le formulaire nouveau groupe */

    public function executeNouveau($request) {
        /* Passe le formulaire à la vue. */
        $this->form = new sfGuardGroupRegisterForm();
        $this->form->personnalise($this->getUser());
    }

    /* action creant le nouveau groupe */

    public function executeCreer($request) {
        $this->form = new sfGuardGroupRegisterForm();
        $this->form->personnalise($this->getUser());
        $this->valideFormulaire($request, $this->form);
        $this->setTemplate('nouveau');
    }

    /* action affichant le formulaire d'un groupe existant */

    public function executeEditer(sfWebRequest $request) {
        $this->forward404Unless($groupe = Doctrine::getTable('SfGuardGroup')->find(array($request->getParameter('id'))), sprintf('Object SfGuardGroup does not exist (%s).', $request->getParameter('id')));
        //si on force par URL l'edition d'un groupe superieur => 404
        $this->forward404Unless($this->getUser()->getGuardUser()->verifieDroitGroupe($request->getParameter('id')));
        $this->form = new sfGuardGroupRegisterForm($groupe);
        $this->form->personnalise($this->getUser());

        //recuperation des widgets liee
      
          $this->form->configureWidget($groupe->getId());

    }

    /* action modifiant un groupe */

    public function executeModifier($request) {
        $this->forward404Unless($groupe = Doctrine::getTable('SfGuardGroup')->find(array($request->getParameter('id'))), sprintf('Object SfGuardGroup does not exist (%s).', $request->getParameter('id')));
        //si on force par URL l'edition d'un groupe superieur => 404
        $this->forward404Unless($this->getUser()->getGuardUser()->verifieDroitGroupe($request->getParameter('id')));
        $this->form = new sfGuardGroupRegisterForm($groupe);
        $this->form->personnalise($this->getUser());
        $this->valideFormulaire($request, $this->form);
        $this->setTemplate('editer');
    }

    // action faisant l'extraction
    public function executeExtract(sfWebRequest $request) {
        $this->setLayout(false);
        //recupere les groupes
        $this->groupes = Doctrine::getTable('SfGuardGroup')->createQuery('a')->execute();


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="exportParametrage.xls"');
    }

    /* action supprimant un groupe */

    public function executeSupprimer(sfWebRequest $request) {
        //protege contre une requete ne provenant pas d'un lien
        //	$request->checkCSRFProtection();
        $this->forward404Unless($groupe = Doctrine::getTable('SfGuardGroup')->find(array($request->getParameter('id'))), sprintf('Object SfGuardGroup does not exist (%s).', $request->getParameter('id')));
        $groupe->delete();
        $this->redirect('@gestion-des-groupes');
    }

    /* valide le formulaire et serialise l'objet en base */

    protected function valideFormulaire(sfWebRequest $request, sfForm $form) {
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('sf_guard_group'));
            $widgets = $this->form->getValue('widget_list');
            /* ...et que les données sont valides */
            if ($this->form->isValid()) {
                /* Si nouveau, On crée le groupe */
                if ($form->getObject()->isNew()) {
                    $groupe = $this->form->save();
                }
                /* Sinon on met a jour le groupe */ else {
                    $groupe = Doctrine::getTable('SfGuardGroup')->find(array($request->getParameter('id')));
                    $groupe = $this->form->save();

                    //suppression des anciens widget
                    $oldWidget = WrkGroupWidgetTable::getInstance()->findByGroupId($groupe->getId());
                    $oldWidget->delete();
                }

                //sauvegade des nouveaux widgets
                $nb = 1;
                foreach ($widgets as $widget) {
                    $widgetGroup = new WrkGroupWidget();
                    $widgetGroup->setGroupId($groupe->getId());
                    $widgetGroup->setIdWidget($widget);
                    $widgetGroup->setOrdre($nb++);
                    $widgetGroup->setCreatedAt(date('Y-m-d H:i:s'));
                    $widgetGroup->save();
                }

                $this->redirect('@gestion-des-groupes');
            }
            /* Sinon le formulaire ainsi que l'erreur sera ré-affiché */
        }
    }

    // Action qui permet de controler si le nom du groupe existe déja
    public function executeControlNomGroupe(sfWebRequest $request) {

        // On récupère le nom et l'id du groupe
        $nom = $request->getPostParameter('name');
        $id = $request->getPostParameter('id');

        if ($id != "") {
            // Modification :::: Comme l'id n'est pas vide, on vérifie que le nom n'existe pas déja à part pour l'id passé en parametre
            $controleNom = Doctrine::getTable('sfGuardGroup')->controlNomGroupe($nom, $id);
        } else {
            // Ajout :::: L'id est vide donc on verifie si le nom n'existe pas déja dans toute la table
            $controleNom = Doctrine::getTable('sfGuardGroup')->controlNomGroupe($nom, null);
        }
        // On récupère le nombre de lignes retournées par la requete
        $nb = count($controleNom);

        // Si la requète n'a rien retourné, le nom du groupe passé en paramètre n'existe pas déja
        if ($nb == 0)
            return $this->renderText("");
        else
            return $this->renderText("Le nom \"" . $nom . "\" existe déja !");
    }

    // extrait la liste des groupes sous excel
    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;
        $this->groupes = Doctrine::getTable('SfGuardGroup')->createQuery('a')->execute();
        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="liste_groupes.xls"');
    }

    // extrait la liste des groupes sous word
    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;
        $this->groupes = Doctrine::getTable('SfGuardGroup')->createQuery('a')->execute();
        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="liste_groupes.doc"');
    }

    // extrait la liste des groupes sous word
    public function executePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = true;
        sfConfig::set('sf_web_debug', false);
        $this->groupes = Doctrine::getTable('SfGuardGroup')->createQuery('a')->execute();
    }

}
