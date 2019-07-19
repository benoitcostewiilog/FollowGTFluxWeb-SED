<?php

class interfaceSortanteTask extends sfBaseTask
{
  protected function configure()
  {
   	// add your own arguments here
  	$this->addArguments(array(   new sfCommandArgument('interface', sfCommandArgument::REQUIRED, 'Interface desiree'),  ));
  	
  	$this->addOptions(array(
	  	new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, ''),
	  	new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
	  	new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = '';
    $this->name             = 'interfaceSortante';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [interfaceSortante|INFO] task does things.
Call it with:

  [php symfony interfaceSortante|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
 

  }
}
