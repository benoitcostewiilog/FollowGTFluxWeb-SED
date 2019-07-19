<?php

class declaContenantTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'declaContenant';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [declaContenant|INFO] task does things.
Call it with:

  [php symfony declaContenant|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    

  }
}
