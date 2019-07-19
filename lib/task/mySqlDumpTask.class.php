<?php

/*
 Dumps database
*/
class mySQLDumpTask extends sfBaseTask
{

  protected function configure(){
    $this->addArguments(array(   
        new sfCommandArgument('filename', sfCommandArgument::REQUIRED, 'Nom du fichier'),  
     ));
    $this->addOptions(array(
        new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, ''),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
        new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
        new sfCommandOption('mode', null, sfCommandOption::PARAMETER_REQUIRED, '1=mysqldump/2=mysql', '1'),
    ));
    $this->namespace= '';
    $this->name = 'mySqlDump';
    $this->briefDescription = 'Dumps db et Zip du fichier';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $databaseConnection = $databaseManager->getDatabase( $options['connection'] );
    $mode = $options['mode'] ;
    $username = $databaseConnection->getParameter( 'username' );
    $password = $databaseConnection->getParameter( 'password' );
    $dsnInfo = $this->parseDsn( $databaseConnection->getParameter( 'dsn' ) );


    $fileName = $arguments['filename'];
  	if ($mode==1) {
  		//Dump de la bdd
  		$tmpFile = $fileName.".sql";
  		$cmd ='mysqldump '.$dsnInfo['dbname'].' --user='.$username.' --password='.$password.' --host='.$dsnInfo['host'].' > '.$tmpFile;
  		system($cmd);
  		//Windows
  		$zip = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'Dump'.DIRECTORY_SEPARATOR.$fileName;
  		system ("rar a $zip $tmpFile ");
  		//Unix
  		//$zip = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'Dump'.DIRECTORY_SEPARATOR.$fileName.".tgz";
  		//system ("tar -zcvf $zip $tmpFile ");
  		chmod('0777',$tmpFile);
  		unlink($tmpFile);
  	}else{
  		//Recharge la bdd
  		$tmpFile = $fileName.".sql";
  		//Windows
  		$zip = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'Dump'.DIRECTORY_SEPARATOR.$fileName.".rar";
  		system ("rar e $zip ");
  		//Unix
  		//$zip = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'Dump'.DIRECTORY_SEPARATOR.$fileName.".tgz";
  		//system ("tar -xzvf $zip ");
  		$cmd ='mysql '.$dsnInfo['dbname'].' --user='.$username.' --password='.$password.' --host='.$dsnInfo['host'].' < '.$tmpFile;
  		system($cmd);
  		chmod('0777',$tmpFile);
  		unlink($tmpFile);
  	}

}

  private function parseDsn( $dsn )
  {
   $dsnArray = array();
   $dsnArray['phptype'] = substr($dsn, 0, strpos($dsn, ':'));
   preg_match('/dbname=(\w+)/', $dsn, $dbname);
   $dsnArray['dbname'] = $dbname[1];
   preg_match('/host=(\w+)/', $dsn, $host);
   $dsnArray['host'] = $host[1];
   return $dsnArray;
  }
}