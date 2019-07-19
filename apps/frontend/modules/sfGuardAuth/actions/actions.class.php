<?php

/* On doit inclure manuellement
  l'action du plugin car l'autoloading ne fonctionne pas dans ce cas. */
require_once(sfConfig::get('sf_plugins_dir') .
        '/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/* l'action dérive de celle fournie par le module afin d'hériter de ses actions propres. */

class sfGuardAuthActions extends BasesfGuardAuthActions {
    /* action listant tous les utilisateurs */

    public function executeListe($request) {
        $this->utilisateurs = Doctrine::getTable('SfGuardUser')->createQuery('a')->execute();
    }

    /* action listant tous les utilisateurs */

    public function executeEditPassword($request) {
        
    }

    public function executeUpdatePassword($request) {
        $user = $this->getUser();

        $user = sfGuardUserTable::getInstance()->find($this->getUser()->getGuardUser()->getId());

        $user->setPassword($request->getParameter('password'));
        $user->setPasswordUpdated(true);
        $user->save();

        return $this->renderText(true);
    }

    /* action affichant le formulaire nouvel utilisateur */

    public function executeNouveau($request) {
        // Passe le formulaire à la vue.
        $this->form = new sfGuardRegisterForm();
        $this->form->personnalise($this->getUser());
    }

    /* action permettant d'enregistrer un nouvel utilisateur */

    public function executeCreer($request) {
        $this->form = new sfGuardRegisterForm();
        $this->form->personnalise($this->getUser());
        $this->valideFormulaire($request, $this->form);
        $this->setTemplate('nouveau');
    }

    /* action affichant le formulaire d'un utilisateur existant */

    public function executeEditer(sfWebRequest $request) {
        $this->forward404Unless($utilisateur = Doctrine::getTable('SfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object SfGuardUser does not exist (%s).', $request->getParameter('id')));
        //si on force par URL l'edition d'un chef de quai ou d'un SU => 404
        //$this->forward404Unless($this->getUser()->getGuardUser()->verifieDroit($request->getParameter('id')));
        $this->form = new sfGuardRegisterForm($utilisateur);
        $this->form->personnalise($this->getUser(), $request->getParameter('id'));
    }

    /* action modifiant un utilisateur existant */

    public function executeModifier($request) {
        $this->forward404Unless($utilisateur = Doctrine::getTable('SfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object SfGuardUser does not exist (%s).', $request->getParameter('id')));
        //si on force par URL la modification d'un chef de quai ou d'un SU => 404
        //$this->forward404Unless($this->getUser()->getGuardUser()->verifieDroit($request->getParameter('id')));
        $this->form = new sfGuardRegisterForm($utilisateur);
        //	$this->form->personnalise($this->getUser(),$request->getParameter('id'));

        $this->valideFormulaire($request, $this->form);
        $this->redirect('@gestion-des-utilisateurs');
    }

    /* action supprimant un utilisateur */

    public function executeSupprimer(sfWebRequest $request) {
        //la suppression est protegée grace à un jeton
        //$request->checkCSRFProtection();
        // interdir la suppression de l'utilisateur connecte
        if ($this->getUser()->getGuardUser()->getId() != $request->getParameter('id')) {
            $this->forward404Unless($utilisateur = Doctrine::getTable('SfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object SfGuardUser does not exist (%s).', $request->getParameter('id')));
            $utilisateur->delete();
        }
        //url_for('gestion-des-utilisateurs');
        return $this->renderText('ok');

        //return	$this->redirect('sfGuardAuth/liste');
        //	$this->redirect('@gestion-des-utilisateurs');
    }

    // action faisant l'extraction
    public function executeExtract(sfWebRequest $request) {
        $this->setLayout(false);
        //recupere les utilisateurs
        $this->utilisateurs = Doctrine::getTable('SfGuardUser')->createQuery('a')->execute();


        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="export.xls"');
    }

    /* valide le formulaire et serialise l'objet en base
      se charge egalement de verifier les droits */

    protected function valideFormulaire(sfWebRequest $request, sfForm $form) {
        //	if ($request->isMethod('post')) {
        $this->form->bind($request->getParameter('sf_guard_user'), $request->getFiles($this->form->getName()));
        // si les donnees du formulaire sont valides */
        //if ($this->form->isValid()) {
        // Cas d'un nouvel utilisateur
        if ($form->getObject()->isNew()) {
            $sf_guard_user = $this->form->save();
        }
        // cas de la mise a jour d'un utilisateur
        else {
            $utilisateur = Doctrine::getTable('SfGuardUser')->find(array($request->getParameter('id')));
            $utilisateur = $this->form->save();
        }

        $this->redirect('@gestion-des-utilisateurs');

        //}
        /* Sinon le formulaire ainsi que l'erreur sera ré-affiché */
        //}
    }

    // Action qui permet de controler de le nom d'utilisateur est unique
    public function executeControleNomUser(sfWebRequest $request) {
        // On recupere les parametre saisis
        $nom = $request->getPostParameter('name');
        $id = $request->getPostParameter('id');

        // Si l'id n'est pas vide c'est qu'il s'agit d'une modification
        if ($id != "") {
            // On verifie que le nom d'utilisateur n'existe pas deja a part pour le nom que l'on modifie
            $controleNom = Doctrine::getTable('SfGuardUser')->controlNomUtilisateur($nom, $id);
        }
        // Sinon c'est un ajout
        else {
            // On verifie juste que le nom est unique
            $controleNom = Doctrine::getTable('SfGuardUser')->controlNomUtilisateur($nom, null);
        }

        // On compte le nombre de ligne renvoyés
        $nb = count($controleNom);
        // Si c'est nul on renvoi une chaine vide
        if ($nb == 0)
            return $this->renderText("");
        // Sinon on precise que le nom existe deja
        else
            return $this->renderText("Le nom \"" . $nom . "\" existe déja !");
    }

    // Fonction qui permet de controler que le mail est unique
    public function executeControleMailUser(sfWebRequest $request) {
        // On recupere les parametre saisis
        $mail = $request->getPostParameter('mail');
        $id = $request->getPostParameter('id');

        // Si l'id n'est pas vide c'est qu'il s'agit d'une modification
        if ($id != "") {
            // On verifie que le mail n'existe pas deja a pars pour l'utilateur que l'on modifie
            $controleMail = Doctrine::getTable('SfGuardUser')->controlMailUtilisateur($mail, $id);
        }
        // Sinon c'est un ajout
        else {
            // On verifie juste que le mail est unique
            $controleMail = Doctrine::getTable('SfGuardUser')->controlMailUtilisateur($mail, null);
        }

        // On compte le nombre de ligne renvoyés
        $nb = count($controleMail);
        // Si c'est nul on renvoi une chaine vide
        if ($nb == 0)
            return $this->renderText("");
        // Sinon on precise que le mail existe deja
        else
            return $this->renderText("Le mail \"" . $mail . "\" existe déja !");
    }

    // extrait la liste des utilisateurs sous excel
    public function executeExcel(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;
        $this->utilisateurs = Doctrine::getTable('SfGuardUser')->createQuery('a')->execute();
        $this->getResponse()->setContentType('application/vnd.ms-excel;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="liste_utilisateurs.xls"');
    }

    // extrait la liste des utilisateurs sous word
    public function executeWord(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = false;
        $this->utilisateurs = Doctrine::getTable('SfGuardUser')->createQuery('a')->execute();
        $this->getResponse()->setContentType('application/vnd.ms-word;charset=utf-8');
        $this->getResponse()->setHttpHeader('Content-Disposition:attachment', 'inline;filename="liste_utilisateurs.doc"');
    }

    // extrait la liste des utilisateurs sous word
    public function executePrint(sfWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate('export');
        $this->date = date('d/m/Y');
        $this->print = true;
        sfConfig::set('sf_web_debug', false);
        $this->utilisateurs = Doctrine::getTable('SfGuardUser')->createQuery('a')->execute();
    }

    // si l'utilisateur est déloggué à cause de l'expiration de la session on doit le rediriger vers la page de login d'aéroMobile
    public function executeLogOut(sfWebRequest $request) {

        return $this->redirect(sfContext::getInstance()->getConfiguration()->generateApplicationURL('mobilestock', 'homepage', array('sf_culture' => $this->getUser()->getCulture())));
    }

    /* action permettant d'enregistrer un nouvel utilisateur */

    public function executeDebloquer($request) {
        $this->forward404Unless($utilisateur = Doctrine::getTable('SfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object SfGuardUser does not exist (%s).', $request->getParameter('id')));


        $utilisateur->setLoginFailed(0);
        $utilisateur->save();
        return $this->renderText(true);
    }

}
