<?php

require_once 'C://wamp//apps//symfony-1.4.8//lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

define('SF_ROOT_DIR', dirname(__FILE__).'/../');

sfConfig::add(array(
  'sf_images_dir'     => SF_ROOT_DIR.'/../web/img',
  'sf_web_dir'        => SF_ROOT_DIR.'/../web',
  'sf_javascript_dir' => SF_ROOT_DIR.'/../web/js',
  'sf_stylesheet_dir' => SF_ROOT_DIR.'/../web/css',
  'sf_font_dir'       => SF_ROOT_DIR.'/../web/fonts',
));

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
	$this->enablePlugins('sfDoctrineGuardPlugin');
  	$this->enablePlugins('sfFormExtraPlugin');
  }
}
