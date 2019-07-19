<?php

class MobileStockCaristeTestFunctionnal extends sfTestFunctional
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

	public function getEmplacement($id) {
		$q = Doctrine_Query::create()
			->from('RefEmplacement r')
			->where('r.id_emplacement = ?', $id);
		return $q->fetchOne();
	}
	/*retourne la 1er mssion cloturé*/
	public function getMissionEnCours() {
		$q = Doctrine_Query::create()
			->from('RefMission r')
			->where('r.etat = "en cours"');
		return $q->fetchOne();
	}
	/*retourne la 1er mssion du type en etat initiale*/
	public function getMissionTypeInitiale($type) {
		$q = Doctrine_Query::create()
			->from('RefMission r')
			->where('r.etat = "initiale"')->andWhere('r.type_mission=?', $type);
		return $q->fetchOne();
	}

	/*retourne la 1er mssion du type en etat initiale*/
	public function getEmplacementReserveVide() {
		$q = Doctrine_Query::create()
			->from('RefEmplacement r')
			->leftJoin('r.RefContenant rc')
			->where('rc.code_contenant is null')->andWhere('r.type_emplacement="reserve"');
		return $q->fetchOne();
	}

	/*retourne la 1er mssion du type en etat initiale*/
	public function getEmplacementReserveNonVide() {
		$q = Doctrine_Query::create()
			->from('RefEmplacement r')
			->innerJoin('r.RefContenant rc')
			->innerJoin('rc.RefContenu rco')
			->where('rco.quantite > 0')->andWhere('r.type_emplacement="reserve"');
		return $q->fetchOne();
	}

	/* retourne le premier contenant sur un picking trouvé */
	public function getContenantPicking(){

		$q = Doctrine_Query::create()->from('RefContenant r')
			->innerJoin('r.RefEmplacement re')->where('type_emplacement = "picking"');
		return $q->fetchOne();

	}

	/* retourne le premier contenant sur un emp de reserve trouvé */
	public function getContenantReserve(){

		$q = Doctrine_Query::create()->from('RefContenant r')
			->innerJoin('r.RefEmplacement re')->where('type_emplacement = "reserve"');
		return $q->fetchOne();

	}

}

