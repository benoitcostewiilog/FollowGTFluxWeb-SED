<?php

class MobileStockReceptionTestFunctional extends sfTestFunctional
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

	public function getCodeTransporteur($name)
	{
		$q = Doctrine_Query::create()
			->from('refTransporteur r')
			->where('r.desig_transp = ?', $name);
		$res = 	$q->fetchOne();
		return $res->getCodeTransp();;
	}

	public function getCodeFournisseur($name)
	{
		$q = Doctrine_Query::create()
			->from('refFournisseur r')
			->where('r.designation_four = ?', $name);
		$res = 	$q->fetchOne();
		return $res->getCodeFour();
	}
	public function getQuantiteApprouve($num_ligne, $num_commande) {

		$q = Doctrine_Query::create()
			->from('RefLigComFour r')
			->where('r.num_ligne = ?', $num_ligne)
			->andWhere('r.num_commande = ?', $num_commande);
		$res = 	$q->fetchOne();
		return $res->getQuantiteApprouve();
	}

	public function getQuantiteRejete($num_ligne, $num_commande) {

		$q = Doctrine_Query::create()
			->from('RefLigComFour r')
			->where('r.num_ligne = ?', $num_ligne)
			->andWhere('r.num_commande = ?', $num_commande);
		$res = 	$q->fetchOne();
		return $res->getQuantiteRejete();
	}

	/* recupere le code c'un nouveau contenant */
	public function getNouveauCodeContenant()
	{
		return Doctrine::getTable('RefContenant')->nouveauCodeContenant();
	}

	/* recupere le dernier code contenant en BDD */
	public function getTraveeQuaiReception(){

		$q = Doctrine_Query::create()
			->from('RefTravee r')
			->where('r.type_travee = "reception"');
		$res = 	$q->fetchOne();
		return $res->getNumTravee();


	}

	/* renvoie le nombre de cmr en cours de livraison */
	public function getNbCmrEnLivraison(){
		return Doctrine::getTable('RefCmr')->getCmrEnCours()->count();
	}

	/* retounre le premier contenant de la base */
	public function getPremierContenantHomogene(){
		$q = Doctrine_Query::create()->from('RefContenant r')->where('type_contenant = "homogene"');
		return $q->execute()->getFirst();
	}

	/* retounre le premier emplacement de type reserve avec du contenu*/
	public function getPremierEmpReserve(){
		$q = Doctrine_Query::create()->from('RefEmplacement r')->where('type_emplacement = "reserve"')
			->innerJoin('r.RefContenant rc');
		return $q->execute()->getFirst();
	}

	/* retourne la premiere reference en base*/
	public function getPremiereReference(){
		$q = Doctrine_Query::create()->from('RefARticle r');
		return $q->execute()->getFirst();
	}

	/* retourne la premiere reference en base*/
	public function getPlotDeVracSansMission(){

		$q = Doctrine_Query::create()->from('RefContenant r')->where('type_contenant = "heterogene"');
		foreach ($q->execute() as $plot){
			if(!$plot->missionRangementVracEnCours()) return $plot;
		}
		return null;
	}

	/* retourne une commande en etat en cours ou encore non livrée du fournisseur passé en parametre*/
	public function getCommandeResteALivrer($fournisseur){

		$q = Doctrine_Query::create()->from('RefCommandeFour r')->where('code_four = ?',$fournisseur)
			->leftJoin('r.RefLivraisonCommande rlc')->where('rlc.etat <> "clos"')->orWhere('rlc.etat IS NULL');
		return $q->fetchOne();
	}



}

