<?php

/**
 * emplacements actions.
 *
 * @package    MobileStockV3
 * @subpackage emplacements
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class emplacementsActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->ref_emplacements = Doctrine_Core::getTable('RefEmplacement')
                ->createQuery('a')
                ->execute();
    }

    public function executeListAjax(sfWebRequest $request) {
        $ref_emplacements = Doctrine_Core::getTable('RefEmplacement')
                ->createQuery('a')
                ->execute();

        return $this->renderPartial('list', array('ref_emplacements' => $ref_emplacements));
    }

    public function executeNew(sfWebRequest $request) {
        
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));
        $code_emplacement = $request->getParameter('code_emplacement');
        $libelle = $request->getParameter('libelle');
        $statut = 0;
        if ($this->build($code_emplacement, $libelle)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($ref_emplacement = Doctrine_Core::getTable('RefEmplacement')->find(array($request->getParameter('code_emplacement'))), sprintf('Object ref_emplacement does not exist (%s).', $request->getParameter('code_emplacement')));
        $this->ref_emplacement = $ref_emplacement;
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($ref_emplacement = Doctrine_Core::getTable('RefEmplacement')->find(array($request->getParameter('code_emplacement'))), sprintf('Object ref_emplacement does not exist (%s).', $request->getParameter('code_emplacement')));

        $code_emplacement = $request->getParameter('code_emplacement');
        $libelle = $request->getParameter('libelle');

        $statut = 0;
        if ($this->build($code_emplacement, $libelle, $ref_emplacement)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($ref_emplacement = Doctrine_Core::getTable('RefEmplacement')->find(array($request->getParameter('code_emplacement'))), sprintf('Object ref_emplacement does not exist (%s).', $request->getParameter('code_emplacement')));
        $statut = 1;
        try {
            $ref_emplacement->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function executeCheckCode(sfWebRequest $request) {
        $code_emplacement = $request->getParameter('code_emplacement');
        $ref_emplacement = Doctrine_Core::getTable('RefEmplacement')->find($code_emplacement);
        $statut = 1;
        if ($ref_emplacement) {
            $statut = 0;
        }
        return $this->renderText($statut);
    }

    public function build($code_emplacement, $libelle, RefEmplacement $emplacement = null) {
        $code_emplacement = trim($code_emplacement);
        if ($code_emplacement !== '' && $libelle !== '') {
            if ($emplacement == null) {
                $ref_emplacement = Doctrine_Core::getTable('RefEmplacement')->find($code_emplacement);
                if ($ref_emplacement) {
                    return false;
                }
                $emplacement = new RefEmplacement();
                $emplacement->setCreatedAt(date('Y-m-d H:i:s'));
            }
            $emplacement->setCodeEmplacement($code_emplacement);
            $emplacement->setLibelle($libelle);
            $emplacement->save();
            return true;
        }
        return false;
    }

}
