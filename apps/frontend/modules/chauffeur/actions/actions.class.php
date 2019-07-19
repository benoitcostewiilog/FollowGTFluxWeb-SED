<?php

/**
 * chauffeur actions.
 *
 * @package    MobileStockV3
 * @subpackage chauffeur
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class chauffeurActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->ref_chauffeurs = Doctrine_Core::getTable('RefChauffeur')
                ->createQuery('a')
                ->select('a.*,t.*')
                ->innerJoin('a.RefTransporteur t')
                ->execute();
    }

    public function executeListAjax(sfWebRequest $request) {
        $ref_chauffeurs = Doctrine_Core::getTable('RefChauffeur')
                ->createQuery('a')
                ->select('a.*,t.*')
                ->innerJoin('a.RefTransporteur t')
                ->execute();

        return $this->renderPartial('list', array('ref_chauffeurs' => $ref_chauffeurs));
    }

    public function executeNew(sfWebRequest $request) {
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $nom = $request->getParameter('nom');
        $prenom = $request->getParameter('prenom');
        $docId = $request->getParameter('docId');
        $idTransporteur = $request->getParameter('transporteur');

        $statut = $this->build($nom, $prenom, $docId, $idTransporteur);
        if($statut) {
             return $this->renderText($statut);
         }
         return $this->renderText('');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($ref_chauffeur = Doctrine_Core::getTable('RefChauffeur')->find(array($request->getParameter('idChauffeur'))), sprintf('Object ref_chauffeur does not exist (%s).', $request->getParameter('idChauffeur')));
        $this->ref_chauffeur = $ref_chauffeur;
        $this->transporteurs = RefTransporteurTable::getInstance()->findAll();
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($ref_chauffeur = Doctrine_Core::getTable('RefChauffeur')->find(array($request->getParameter('idChauffeur'))), sprintf('Object ref_chauffeur does not exist (%s).', $request->getParameter('idChauffeur')));

        $nom = $request->getParameter('nom');
        $prenom = $request->getParameter('prenom');
        $docId = $request->getParameter('docId');
        $idTransporteur = $request->getParameter('transporteur');

        $statut = 0;
        if ($this->build($nom, $prenom, $docId, $idTransporteur, $ref_chauffeur)) {
            $statut = 1;
        }
        return $this->renderText($statut);
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($ref_chauffeur = Doctrine_Core::getTable('RefChauffeur')->find(array($request->getParameter('idChauffeur'))), sprintf('Object ref_chauffeur does not exist (%s).', $request->getParameter('idChauffeur')));
        $statut = 1;
        try {
            $ref_chauffeur->delete();
        } catch (Exception $e) {
            $statut = 0;
        }


        return $this->renderText($statut);
    }

    public function executePrint(sfWebRequest $request) {
        $this->forward404Unless($this->ref_chauffeur = Doctrine_Core::getTable('RefChauffeur')->find(array($request->getParameter('idChauffeur'))), sprintf('Object ref_chauffeur does not exist (%s).', $request->getParameter('idChauffeur')));
        $this->setLayout(false);
        $this->setTemplate('print');
        $this->date = date('d/m/Y');
        sfConfig::set('sf_web_debug', false);
    }

    public function build($nom, $prenom, $docId, $idTransporteur, RefChauffeur $chauffeur = null) {
        if ($nom !== '' && $prenom !== '' && $idTransporteur !== '') {
            $transporteur = RefTransporteurTable::getInstance()->find($idTransporteur);
            if ($transporteur) {
                if (!$this->checkUnique($nom, $prenom, $idTransporteur, $chauffeur)) {
                    return false;
                }
                if ($chauffeur == null) {
                    $chauffeur = new RefChauffeur();
                    $chauffeur->setCreatedAt(date('Y-m-d H:i:s'));
                }
                $chauffeur->setNom($nom);
                $chauffeur->setPrenom($prenom);
                $chauffeur->setNumDocId($docId);
                $chauffeur->setIdTransporteur($idTransporteur);
                $chauffeur->save();
                return $chauffeur->getIdChauffeur();
            }
        }
        return false;
    }

    public function checkUnique($nom, $prenom, $idTransporteur, RefChauffeur $chauffeur = null) {
        if ($chauffeur === null || ($chauffeur !== null && ($chauffeur->getNom() !== $nom || $chauffeur->getPrenom() !== $prenom || $chauffeur->getIdTransporteur() !== $idTransporteur ))) {
            $chauffeurs = RefChauffeurTable::getInstance()->createQuery()
                    ->select('c.*')
                    ->from('RefChauffeur c')
                    ->where('c.nom = ?', $nom)
                    ->andWhere('c.prenom = ?', $prenom)
                    ->andWhere('c.id_transporteur = ?', $idTransporteur)
                    ->execute();

            if (count($chauffeurs) > 0) {
                return false;
            }
        }
        return true;
    }

}
