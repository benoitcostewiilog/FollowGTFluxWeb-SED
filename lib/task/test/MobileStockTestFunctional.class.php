<?php

class MobileStockTestFunctional extends sfTestFunctional
{
  public function loadData()
  {
    Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');
    return $this;
  }

  /*fonction permettant de s'authentifier lors d'un test fonctionnel*/
	public function signin($username, $password) {
		    return $this->
      get('/fr/login')->
      click('connexion', array( 'signin' => array( 'username' => $username,
                                                 'password' => $password  ) ) );
	}
	public function signout() {
		return $this->get('/fr/logout');
	}

	/*retourne l'objet utilisateur a partir de son nom*/
	public function getUserByName($name)
	{
		$q = Doctrine_Query::create()
			->from('sfGuardUser s')
			->where('s.username = ?', $name);
 		return $q->fetchOne();
	}

	/*retourne l'objet group a partir de son nom*/
	public function getGroupByName($name)
	{
		$q = Doctrine_Query::create()
			->from('sfGuardgroup s')
			->where('s.name = ?', $name);
 		return $q->fetchOne();
	}

	/*retourne l'objet permissions a partir de son nom*/
	public function getPermissionByName($name)
	{
		$q = Doctrine_Query::create()
			->from('sfGuardPermission s')
			->where('s.name = ?', $name);
 		return $q->fetchOne();
	}
	/*enregistrement d'un mouvement dans l'historique*/
	public function ajouteMouvement()
	{
		$type="Creation";
		$operateur='thomas';
		$refProduit='105';
		$code_contenant='1054';
		$qte_avant=0;
		$qte_apres=20;
		$ordre = "mission fictive";
		$emp_avant="TRAPIC1.0";
		$emp_apres="TRAPIC1.0";
		return Doctrine::getTable('AdmCodeContenant')->ajouteMouvement($type, $operateur, $refProduit, $code_contenant, $qte_avant, $qte_apres, $emp_avant, $emp_apres, $ordre );
	}
	/*retourne le code transporteur a partir de son nom*/
	public function getCodeTransporteur($name)
	{
		$q = Doctrine_Query::create()
			->from('refTransporteur r')
			->where('r.desig_transp = ?', $name);
		$res = 	$q->fetchOne();
 		return $res->getCodeTransp();;
	}

	/*retourne le code transporteur a partir de son nom*/
	public function getCodeFournisseur($name)
	{
		$q = Doctrine_Query::create()
			->from('RefFournisseur r')
			->where('r.designation_four = ?', $name);
		$res = 	$q->fetchOne();
		return $res->getCodeFour();;
	}

		/*retourne le code produit a partir de son nom*/
	public function getCodeProduit($name)
	{
		$q = Doctrine_Query::create()
			->from('refArticle r')
			->where('r.designation_prod = ?', $name);
		$res = 	$q->fetchOne();
 		return $res->getRefProduit();;
	}

	/* recupere l'ordonnancement */
	public function getOrdonnancement($id_cariste, $num_travee){

		$q = Doctrine_Query::create()->from('AdmOrdoCariste a')
			->where('a.num_travee = ?', $num_travee)->andWhere('a.id_cariste = ?', $id_cariste);
		$res = 	$q->fetchOne();
		return $res->getIdOrdonnancement();
	}

	/* recupere la travee suivant son nom */
	public function getTravee($design_travee){

		$q = Doctrine_Query::create()->from('RefTravee r')
			->where('r.design_travee = ?', $design_travee);
		$res = 	$q->fetchOne();
		return $res->getNumTravee();
	}

	/* renvoi la 1er mission du type passé en parametre */
	public function getMission($type){

		$q = Doctrine_Query::create()->from('RefMission r')
			->where('r.type_mission = ?', $type);
		$res = 	$q->fetchOne();
		return $res;
	}
	public function getTypeEmplacement($id_emplacement){

		$q = Doctrine_Query::create()->from('RefEmplacement r')
			->where('r.id_emplacement = ?', $id_emplacement);
		$res = 	$q->fetchOne();
		return $res->getTypeEmplacement();
	}
	public function getPremierEmplacement($codeProduit){

		$q = Doctrine_Query::create()->from('RefContenant r')
			->innerjoin('r.RefContenu refcu')->addwhere('refcu.ref_produit = ?', $codeProduit)->orderBy('r.id_emplacement');
		$res = 	$q->fetchOne();
		return $res->getRefEmplacement()->getIdEmplacement();
	}
	public function getPremierTypeEmplacement($codeProduit){

		$q = Doctrine_Query::create()->from('RefContenant r')
			->innerjoin('r.RefContenu refcu')->addwhere('refcu.ref_produit = ?', $codeProduit)->orderBy('r.id_emplacement');
		$res = 	$q->fetchOne();
		return $res->getRefEmplacement()->getTypeEmplacement();
	}
	public function getPremierTypeEmplacementTravee($codeTravee){
		$q = Doctrine_Query::create()->from('RefTravee r')
			->innerjoin('r.RefEmplacement refemp')->addwhere('r.num_travee = ?', $codeTravee);
		$res = 	$q->fetchOne();
		return $res->getRefEmplacement()->getFirst()->getTypeEmplacement();
	}
	public function getPremierEmplacementTravee($codeTravee){
		$q = Doctrine_Query::create()->from('RefEmplacement r')
			->addwhere('r.num_travee = ?', $codeTravee);
		$res = 	$q->fetchOne();
		return $res->getIdEmplacement();
	}
	public function getPremierContenantEmplacementTravee($idEmplacement){
		$q = Doctrine_Query::create()->from('RefContenant r')
			->addwhere('r.id_emplacement = ?', $idEmplacement);
		$res = 	$q->fetchOne();
		return $res->getCodeContenant();
	}
}