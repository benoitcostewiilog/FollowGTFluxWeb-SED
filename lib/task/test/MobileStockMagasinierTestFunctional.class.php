<?php

class MobileStockMagasinierTestFunctional extends sfTestFunctional
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

	public function getPremierEmplacementNonVide(){
		$q = Doctrine_Query::create()->from('RefEmplacement r');
		foreach ($q->execute() as $res){
			if ($res->getContenu()->count()>0) {
				return $res;
			}
		}
	}
	public function getPremierContenantEmplacement($emplacement)
	{
		$q = Doctrine_Query::create()->from('RefContenant r')
		->addwhere('r.id_emplacement = ?', $emplacement->getIdEmplacement());
		foreach ($q->execute() as $res){
			if ($res->estVide() == false) {
				return $res->getCodeContenant();
			}
		}
	}
	public function getPremierProduitContenantEmplacement($contenant)
	{
		$q = Doctrine_Query::create()->from('RefArticle r')
		->innerjoin('r.RefContenu refcu')->addwhere('refcu.code_contenant = ?', $contenant);
		$res = 	$q->fetchOne();
		return $res->getRefProduit();
	}
	public function getQuantiteProduit($produit, $contenant)
	{
		echo "produit".$produit;
		echo "contenant".$contenant;
		$q = Doctrine_Query::create()->from('RefArticle r')
			->addwhere('r.ref_produit = ?', $produit)->execute();
		//$leProduit=$q->execute();
		$quantite=0;
		echo "requete : ".$q;
		foreach ($q->getFirst()->getRefContenu() as $res){
			if($res->getCodeContenant() == $contenant)
			{
				$quantite = $quantite+$res->getQuantite();
				echo "quantite".$quantite;
			}
		}
		return $quantite;

	}
}

