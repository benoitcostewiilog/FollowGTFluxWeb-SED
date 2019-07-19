<?php

/**
 * interlocuteurs actions.
 *
 * @package    MobileStockV3
 * @subpackage interlocuteurs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class interlocuteursActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->interlocuteurs = Doctrine_Core::getTable('RefInterlocuteur')
                ->createQuery('a')
                ->execute();
    }

    public function executeListAjax(sfWebRequest $request) {
        $interlocuteurs = Doctrine_Core::getTable('RefInterlocuteur')
                ->createQuery('a')
                ->execute();

        return $this->renderPartial('list', array('interlocuteurs' => $interlocuteurs));
    }

    public function executeNew(sfWebRequest $request) {

        $this->emplacements = Doctrine_core::getTable('RefEmplacement')
                ->createQuery('a')
                ->execute(); 
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $nom = $request->getParameter('nom');
        $prenom = $request->getParameter('prenom');
        $mail = $request->getParameter('mail');
        $emplacement = $request->getParameter('emplacement');
        $statut = 0;
        $statut = $this->build($nom,$prenom,$mail, null,$emplacement);
        if($statut) {
            return $this->renderText($statut);
        }
        return $this->renderText('');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($interlocuteur = Doctrine_Core::getTable('RefInterlocuteur')->find(array($request->getParameter('id'))), sprintf('Object ref_interlocuteur does not exist (%s).', $request->getParameter('id')));
        $this->interlocuteur = $interlocuteur;
        $this->emplacements = Doctrine_core::getTable('RefEmplacement')->createQuery('a')->execute();
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($interlocuteur = Doctrine_Core::getTable('RefInterlocuteur')->find(array($request->getParameter('id'))), sprintf('Object ref_interlocuteur does not exist (%s).', $request->getParameter('id')));

    
        $nom = $request->getParameter('nom');
        $prenom = $request->getParameter('prenom');
        $mail = $request->getParameter('mail');
        $emplacement = $request->getParameter('emplacement');
        $statut = 0;
        if ($this->build($nom,$prenom,$mail, $interlocuteur,$emplacement)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($interlocuteur = Doctrine_Core::getTable('RefInterlocuteur')->find(array($request->getParameter('id'))), sprintf('Object ref_interlocuteur does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            $interlocuteur->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build($nom,$prenom,$mail, RefInterlocuteur $interlocuteur = null, $emplacement) {
        if ($nom !== '') {
           
            if ($interlocuteur == null) {
                $interlocuteur = new RefInterlocuteur();
                $interlocuteur->setCreatedAt(date('Y-m-d H:i:s'));
            }
            $interlocuteur->setNom($nom);
            $interlocuteur->setPrenom($prenom);  
            $interlocuteur->setMail($mail);
            $interlocuteur->setIdEmplacement($emplacement);
            $interlocuteur->save();
            
            return $interlocuteur->getId();
        }
        return false;
    }



}
