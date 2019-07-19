<?php

class majtrackingTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    //   $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'MobileStockV3'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'majtracking';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [majtracking|INFO] task does things.
Call it with:

  [php symfony majtracking|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    
    $con = Doctrine_Manager::getInstance()->connection();
    
    
    /* Mis à jour statut Tracking colis acheminement*/
    $req = $con->execute("UPDATE wrk_colis_acheminement wc, wrk_mouvement wm
                            SET wc.statut = CASE 
                            WHEN (SELECT count(*) AS nbMvt FROM `wrk_mouvement` WHERE `ref_produit` LIKE wc.tracking) = 0 THEN 'initial'
                            WHEN (SELECT count(*) AS nbMvt FROM `wrk_mouvement` WHERE `ref_produit` LIKE wc.tracking) < 2 THEN 'en cours'
                            WHEN (SELECT count(*) AS nbMvt FROM `wrk_mouvement` WHERE `ref_produit` LIKE wc.tracking) >= 2 THEN 'déposé'
                            END
                            WHERE wc.statut <> 'déposé'");
    
    
    /* Mis à jour statut acheminement */
	echo "Hello";
	$req = $con->execute("SELECT * FROM wrk_acheminement WHERE statut <> 'déposé'");
	$listeAcheminement =  $req->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($listeAcheminement as $acheminement) {
		
		$statut = 'intial';
		
		$req = $con->execute("SELECT count(*) AS nbStatut FROM wrk_colis_acheminement wca 
							  WHERE wca.statut = 'en cours' AND wca.id_acheminement = '".$acheminement['id_acheminement']."'");
		$nbStatut = $req->fetch(PDO::FETCH_ASSOC);
        
        if($nbStatut['nbStatut'] <= $acheminement['nb_colis'] && $nbStatut['nbStatut'] != 0){
            $statut = 'en cours';
        }
				
		$req = $con->execute("SELECT count(*) AS nbStatut FROM wrk_colis_acheminement wca 
							  WHERE wca.statut = 'déposé' AND wca.id_acheminement = '".$acheminement['id_acheminement']."'");
		$nbStatut = $req->fetch(PDO::FETCH_ASSOC);
		
		if($nbStatut['nbStatut']  == $acheminement['nb_colis']){
            $statut = 'déposé';
        }
         
		$req = $con->execute("UPDATE wrk_acheminement SET statut = '".$statut."' WHERE id_acheminement = '".$acheminement['id_acheminement']."'");	
	} 
  }
}
