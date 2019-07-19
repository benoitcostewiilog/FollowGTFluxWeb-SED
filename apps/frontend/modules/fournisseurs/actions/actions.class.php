<?php

/**
 * fournisseurs actions.
 *
 * @package    MobileStockV3
 * @subpackage fournisseurs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fournisseursActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->fournisseurs = Doctrine_Core::getTable('RefFournisseur')
                ->createQuery('a')
                ->execute();
    }

    public function executeListAjax(sfWebRequest $request) {
        $fournisseurs = Doctrine_Core::getTable('RefFournisseur')
                ->createQuery('a')
                ->execute();

        return $this->renderPartial('list', array('fournisseurs' => $fournisseurs));
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $libelle = $request->getParameter('libelle');
        $statut = 0;
        $statut = $this->build($libelle);
        if($statut) {
            return $this->renderText($statut);
        }
        return $this->renderText('');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($fournisseur = Doctrine_Core::getTable('RefFournisseur')->find(array($request->getParameter('id'))), sprintf('Object ref_fournisseur does not exist (%s).', $request->getParameter('id')));
        $this->fournisseur = $fournisseur;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($fournisseur = Doctrine_Core::getTable('RefFournisseur')->find(array($request->getParameter('id'))), sprintf('Object ref_fournisseur does not exist (%s).', $request->getParameter('id')));

        $libelle = $request->getParameter('libelle');

        $statut = 0;
        if ($this->build($libelle, $fournisseur)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($fournisseur = Doctrine_Core::getTable('RefFournisseur')->find(array($request->getParameter('id'))), sprintf('Object ref_fournisseur does not exist (%s).', $request->getParameter('id')));
        $statut = 1;
        try {
            $fournisseur->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function build($libelle, RefFournisseur $fournisseur = null) {
        if ($libelle !== '') {
            if ($fournisseur === null || ($fournisseur !== null && $fournisseur->getLibelle() !== $libelle)) {
                if (!$this->checkLibelleUnique($libelle)) {
                    return false;
                }
            }
            if ($fournisseur == null) {
                $fournisseur = new RefFournisseur();
                $fournisseur->setCreatedAt(date('Y-m-d H:i:s'));
            }
            $fournisseur->setLibelle($libelle);
            $fournisseur->save();
            
            return $fournisseur->getIdFournisseur();
        }
        return false;
    }

    public function checkLibelleUnique($libelle) {
        $fournisseur = RefFournisseurTable::getInstance()->findByLibelle($libelle);

        if (count($fournisseur)>0) {
            return false;
        }
        return true;
    }

}
