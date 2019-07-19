<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
class BasesfGuardAuthActions extends sfActions {

    public function executeSignin($request) {
        $user = $this->getUser();
        if ($user->isAuthenticated()) {
            return $this->redirect('@homepage');
        }

        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
        $this->form = new $class();
        //ajout de cette condition pour eviter le bug du jeton timeout
        if ($request->isMethod('post') && !$request->hasParameter('signin'))
            return;

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('signin'));

            $bloquer = false;
            $signin = $request->getParameter('signin');

            $username = $signin["username"];
            if ($username && $username != "" && $username != null) {
                $userTmp = sfGuardUserTable::getInstance()->findOneBy("username", $username);
                if ($userTmp != null) {
                    $loginFailed = $userTmp->getLoginFailed() >= 0 ? $userTmp->getLoginFailed() : 0;
                    $userTmp->setLoginFailed($loginFailed + 1);
                    $userTmp->save();
                    $left = (sfGuardUserTable::LOGIN_FAILED_LIMIT - $userTmp->getLoginFailed());
                    if ($left <= 0) {
                        $this->message = "Ce compte est bloqué";
                        if ($left < 0) {
                            $bloquer = true;
                        }
                    } else {
                        $this->message = "Il reste " . $left . " tentative(s) de connexion avant le blocage du compte";
                    }
                }
            }

            if (!$bloquer && $this->form->isValid()) {


                $signin = $request->getParameter('signin');
                $username = $signin["username"];
                if ($username && $username != "" && $username != null) {
                    $userTmp = sfGuardUserTable::getInstance()->findOneBy("username", $username);
                    if ($userTmp != null) {
                        $userTmp->setLoginFailed(0);
                        $userTmp->save();
                    }
                }

                $values = $this->form->getValues();
                $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

                // always redirect to a URL set in app.yml
                // or to the referer
                // or to the homepage
                $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
                session_set_cookie_params(9999, "/", "www.mobilestock.fr", FALSE);
                session_cache_limiter("nocache");
                session_save_path(sfConfig::get('sf_cache_dir'));
                session_start();

                $application = $this->getUser()->getGuardUser()->getRedirection();

                if ($application) {
                    self::generateMenus();
                    $modules = $this->getUser()->getGuardUser()->getRedirectionModule();

                    $user = sfGuardUserTable::getInstance()->find($this->getUser()->getGuardUser()->getId());

                    if ($user->getPasswordUpdated() == false) {
                        return $this->redirect(sfContext::getInstance()->getConfiguration()->generateApplicationURL($application, "sf_guard_editPassword", array('sf_culture' => $this->getUser()->getCulture())));
                    } else {

                        return $this->redirect(sfContext::getInstance()->getConfiguration()->generateApplicationURL($application, $modules, array('sf_culture' => $this->getUser()->getCulture())));
                    }
                } else {
                    return $this->redirect('@sf_guard_signout');
                }
            }
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->getResponse()->setHeaderOnly(true);
                $this->getResponse()->setStatusCode(401);

                return sfView::NONE;
            }
            $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());
            $module = sfConfig::get('sf_login_module');
            if ($this->getModuleName() != $module) {
                return $this->redirect($module . '/' . sfConfig::get('sf_login_action'));
            }
            $this->getResponse()->setStatusCode(401);
        }
    }

    public function executeSignout($request) {
        $this->getUser()->signOut();
        $signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());
        $this->redirect('' != $signoutUrl ? $signoutUrl : '@homepage');
    }

    public function executeSecure($request) {
        $this->getResponse()->setStatusCode(403);
    }

    public function executePassword($request) {
        throw new sfException('This method is not yet implemented.');
    }

    private function generateMenus() {
        $permissions_du_groupe = $this->getUser()->getGuardUser()->getAllPermissions();
        $tab_ecran_menu = array();
        foreach ($permissions_du_groupe as $permission):
            if ($permission->getName() == 'aer_gestion des utilisateurs niveau 1' || $permission->getName() == 'aer_gestion des utilisateurs niveau 2')
                $tab_ecran_menu[] = 'gestion des utilisateurs';
            else
                $tab_ecran_menu[] = $permission->getName();
        endforeach;
        foreach (sfConfig::get('app_sf_guard_plugin_liste_appli') as $application) {
            $tab_infos = array();
            switch ($application) {
                case "app_frontend":
                    $tab_infos = self::getTabMenuFrontend();
                    break;
            }
            $menuString = self::generateHtmlStringMenu($tab_infos[0], $tab_infos[1], $tab_infos[2], $tab_ecran_menu, substr($application, 4));
            $repertoire = sfConfig::get('sf_apps_dir') . DIRECTORY_SEPARATOR . substr($application, 4) . DIRECTORY_SEPARATOR . "templates"
                    . DIRECTORY_SEPARATOR . 'menus' . DIRECTORY_SEPARATOR . 'menu' . $this->getUser()->getGuardUser()->getId() . '.php';
            $fp = fopen($repertoire, "w");
            if ($fp) {
                if (fputs($fp, $menuString)) {
                    $this->logMessage('Fermeture fichier', 'info');
                    $this->logMessage($menuString, 'info');
                    fclose($fp);
                } else {
                    $this->logMessage('Echec fermeture fichier', 'info');
                }
            } else {
                $this->logMessage('Echec Creation fichier', 'info');
            }
        }
    }

    private function getTabMenuFrontend() {
        $tab_titre_menu = array('Accueil', 'Borne d\'accueil', 'Arrivages', 'Urgences', 'Réceptions', 'Expéditions', 'Acheminement', 'Mouvements', 'Non-Conformités', 'En-cours', 'Inventaires', 'Arrivages/BR', 'Statistiques', 'Référentiels', 'Paramétrages');
        $tab_img_menu = array('fa fa-th-large', 'fa fa-laptop', 'fa fa-truck', 'fa fa-exclamation-circle', 'fa fa-mail-reply', 'fa fa-mail-forward', 'fa fa-bolt ', 'fa fa-retweet', 'fa fa-warning', 'fa fa-clock-o', 'fa fa-bell-o', 'fa fa-random', 'fa fa-bar-chart', 'fa fa-list', 'fa fa-wrench');
        $tab_accueil = array('accueil' => 'Accueil');
        $tab_borne = array('borne-arrivage' => 'Arrivages', 'borne-expedition' => 'Expéditions');
        $tab_arrivage = array('arrivage' => 'Arrivages');
        $tab_urgence = array('urgence' => 'Urgences');
        $tab_reception = array('reception' => 'Réceptions');
        $tab_expedition = array('expedition' => 'Expéditions');
        $tab_acheminement = array('acheminement' => 'Acheminement');
        $tab_mouvement = array('mouvements' => 'Historique');
        $tab_nc = array('nonconforme' => 'Non-Conformités');
        $tab_ec = array('encours' => 'En-cours');
        $tab_inventaire = array('inventaires' => 'Inventaire');
        $tab_parametrage = array('gestion des groupes' => 'Groupes', 'gestion des utilisateurs' => 'Utilisateurs', 'parametrage' => 'Paramétrage général');
        $tab_asso = array('association-br' => 'Arrivages/BR');
        $tab_stat = array('statistiques-retard' => 'Globales', 'statistiques-globale' => 'Tracking en retard');
        $tab_referentiels = array('referentiels-fournisseur' => 'Fournisseurs', 'referentiels-transporteur' => 'Transporteurs', 'referentiels-chauffeur' => 'Chauffeurs', 'referentiels-interlocuteur' => 'Interlocuteurs', 'referentiels-emplacement' => 'Emplacements', 'referentiels-nature' => 'Nature de colis');

        return array($tab_titre_menu, $tab_img_menu, array($tab_accueil, $tab_borne, $tab_arrivage, $tab_urgence, $tab_reception, $tab_expedition, $tab_acheminement, $tab_mouvement, $tab_nc, $tab_ec, $tab_inventaire, $tab_asso, $tab_stat, $tab_referentiels, $tab_parametrage));
    }

    private function generateHtmlStringMenu($tab_titre_menu, $tab_img_menu, $tab_menus, $tab_ecran_menu, $application) {
        $contenu = '';
        for ($i = 0; $i < sizeof($tab_menus); $i++) {
            $diffTmp = array_intersect(array_keys($tab_menus[$i]), $tab_ecran_menu);
            $diff = array_values($diffTmp);
            $nbElement = count($diff);
            if ($nbElement != 0) {
                if ($nbElement == 1) {
                    $url = sfProjectConfiguration::getActive()->generateApplicationUrl($application, Str_replace(' ', '-', $diff[0]), array('sf_culture' => 'fr'));
                    $contenu .= "<li><a href=\"" . $url . "\"><i class=\"" . $tab_img_menu[$i] . "\"></i><span class=\"nav-label\">" . $tab_titre_menu[$i] . "</span></a></li>";
                } else {
                    $contenu .= "<li><a><i class=\"" . $tab_img_menu[$i] . "\"></i><span class=\"nav-label\">" . $tab_titre_menu[$i] . "</span> <span class=\"fa arrow\"></span></a>";
                    $contenu .= "<ul class=\"nav nav-second-level\">";
                    for ($j = 0; $j < $nbElement; $j++) {
                        $url = sfProjectConfiguration::getActive()->generateApplicationUrl($application, Str_replace(' ', '-', $diff[$j]), array('sf_culture' => 'fr'));
                        if (is_array($tab_menus[$i][$diff[$j]])) {
                            $contenu .= "<li><a><i class=\"" . '' . "\"></i><span class=\"nav-label\">" . $tab_menus[$i][$diff[$j]]['nom'] . "</span> <span class=\"fa arrow\"></span></a>";
                            $contenu .= "<ul class=\"nav nav-third-level\">";
                            foreach ($tab_menus[$i][$diff[$j]] as $key => $value) {
                                if ($value != $tab_menus[$i][$diff[$j]]['nom']) {
                                    $url = sfProjectConfiguration::getActive()->generateApplicationUrl($application, Str_replace(' ', '-', $key), array('sf_culture' => 'fr'));
                                    $contenu .= "<li><a href=\"" . $url . "\">" . $value . "</a></li>";
                                }
                            }
                            $contenu .= "</ul>";
                            $contenu .= "</li>";
                        } else {
                            $contenu .= "<li><a href=\"" . $url . "\">" . $tab_menus[$i][$diff[$j]] . "</a></li>";
                        }
                    }
                    $contenu .= "</ul></li>";
                }
            }
        }
        return $contenu;
    }

}
