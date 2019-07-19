<?php

class tacheTempTask extends sfBaseTask
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
        $this->name             = 'tacheTemp';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [tacheTemp|INFO] task does things.
Call it with:

  [php symfony tacheTemp|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
      
    }
}
