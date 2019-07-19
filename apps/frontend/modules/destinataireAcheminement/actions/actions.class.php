<?php

/**
 * destinataireAcheminement actions.
 *
 * @package    MobileStockV3
 * @subpackage destinataireAcheminement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class destinataireAcheminementActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->destinataires = Doctrine_Core::getTable('RefDestinataireAcheminement')
      ->createQuery('a')
      ->execute();
  }

  public function executeListAjax(sfWebRequest $request) {
    $destinataires = Doctrine_Core::getTable('RefDestinataireAcheminement')
      ->createQuery('a')
      ->execute();

    return $this->renderPartial('list', array('destinataires' => $destinataires));
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new RefDestinataireAcheminementForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $destinataire = $request->getParameter('destinataire');
    $statut = 0;
    if ($this->build($destinataire)) {
        $statut = 1;
    }
    return $this->renderText($statut);
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($ref_destinataire_acheminement = Doctrine_Core::getTable('RefDestinataireAcheminement')->find(array($request->getParameter('id'))), sprintf('Object ref_destinataire_acheminement does not exist (%s).', $request->getParameter('id')));
    $this->destinataire = $ref_destinataire_acheminement;
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($ref_destinataire_acheminement = Doctrine_Core::getTable('RefDestinataireAcheminement')->find(array($request->getParameter('id'))), sprintf('Object ref_destinataire_acheminement does not exist (%s).', $request->getParameter('id')));
    
    $destinataire = $request->getParameter('destinataire');
    
    $statut = 0;
    
    if ($this->build($destinataire, $ref_destinataire_acheminement)) {
        $statut = 1;
    }
    return $this->renderText($statut);

  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($destinataire = Doctrine_Core::getTable('RefDestinataireAcheminement')->find(array($request->getParameter('id'))), sprintf('Object ref_fournisseur does not exist (%s).', $request->getParameter('id')));
    $statut = 1;
    try {
        $destinataire->delete();
    } catch (Exception $e) {
        $statut = 0;
    }

    return $this->renderText($statut);
  }

  public function build($destinataire, RefDestinataireAcheminement $objDestinataire = null) {
    if ($destinataire !== '') {
        if ($objDestinataire === null || ($objDestinataire !== null && $objDestinataire->getDestinataire() !== $destinataire)) {
            if (!$this->checkLibelleUnique($destinataire)) {
                return false;
            }
        }
        if ($objDestinataire == null) {
            $objDestinataire = new RefDestinataireAcheminement();
            $objDestinataire->setCreatedAt(date('Y-m-d H:i:s'));
        }
        $objDestinataire->setDestinataire($destinataire);
        $objDestinataire->setUpdatedAt(date('Y-m-d H:i:s'));
        $objDestinataire->save();
        return true;
    }
    return false;
  }

  public function checkLibelleUnique($destinataire) {
      
    $destinataire = RefDestinataireAcheminementTable::getInstance()->findByDestinataire($destinataire);

    if (count($destinataire)>0) {
        return false;
    }
    return true;
   }
   
}
