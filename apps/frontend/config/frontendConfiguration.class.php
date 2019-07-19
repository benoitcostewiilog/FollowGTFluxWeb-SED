<?php

class frontendConfiguration extends sfApplicationConfiguration
{
	
  protected $applicationRoutingFrontend = null;
  
  public function configure()
  {
     sfConfig::set('sf_web_images_dir_name', 'img');
  }
    /* Génère le lien vers l'application symfony souhaité */
  public function generateApplicationUrl($application, $name, $parameters = array())
  {
  	sfContext::getInstance()->getLogger()->info("App : ".$application." | Route : ".$name);

	$request = sfContext::getInstance()->getRequest();
	$basePath = $request->getUriPrefix().$request->getRelativeUrlRoot();
	//Ajouter un slash si non présent
	if(substr($basePath, -1) != '/') $basePath .= '/';
	return  $basePath
	        . (($env = sfConfig::get('sf_environment')) != 'prod' ? $application . '_' . $env : $application)
	        . '.php' .$this->getApplicationRouting($application)->generate($name, $parameters);
  }

  public function getApplicationRouting($application)
  {
        if(!$this->applicationRoutingFrontend) {
            $this->applicationRoutingFrontend = new sfPatternRouting(new sfEventDispatcher());
            $config = new sfRoutingConfigHandler();
            $routes = $config->evaluate(array(sfConfig::get('sf_apps_dir') . '/frontend/config/routing.yml'));
            $this->applicationRoutingFrontend->setRoutes($routes);

        }      
        switch ($application) {
            case "frontend":
                return $this->applicationRoutingFrontend;
        }
  }
}
