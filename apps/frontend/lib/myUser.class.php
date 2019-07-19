<?php

class myUser extends sfGuardSecurityUser
{
	public function isFirstRequest($boolean = null)
	{
		if (is_null($boolean))
		{
			return $this->getAttribute('first_request', true);
		}
		else
		{
			$this->setAttribute('first_request', $boolean);
		}
	}

	public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
	{
		$options['timeout'] = 18000;
		parent::initialize($dispatcher, $storage, $options);
	}

	public function effaceMessageFlash()
	{
		$this->setFlash('message',null);
		$this->setFlash('erreur',null);
	}

	public function setFlashTraduit($type, $message, $redirection = true, $varMessage = array())
	{
		$this->effaceMessageFlash();
		$message = sfContext::getInstance()->getI18N()->__($message, $varMessage, 'flash');
		$this->setFlash($type, $message, $redirection );
	}
}
