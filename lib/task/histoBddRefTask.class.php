<?php

class histoBddRefTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'histoBddRef';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [histoBddRef|INFO] task historize references tables into historizations tables.
Call it with:

  [php symfony histoBddRef|INFO]
EOF;

  }

  protected function execute($arguments = array(), $options = array())
  {

  }
}
