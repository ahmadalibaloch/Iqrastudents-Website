<?php
class DefaultLayout extends Layout
{
	function beforeLoad()
	{
		$logdUser = User::getLoggedIn();
		$this->set('logdUser', $logdUser);
		$this->set('title', 'Iqra Students Organization');
		$this->set('left', '');
		$this->set('body', '');
		$this->set('right', '');

		$this->addJs(APP_URL.'js/jquery-ui-1.8.18.custom.min.js');
		$this->addCss(APP_URL.'css/jquery-ui-1.8.18.custom.css');

		$r = time();
		$this->addJs(APP_URL.'js/app.js?'.$r);
		$this->addCss(APP_URL.'css/app.css?'.$r);
	}

	function afterLoad()
	{
		if($logdUser = User::getLoggedIn())
		{
			$this->set('left', DefaultController::fetch('leftPanelAction'));
			$this->set('right', DefaultController::fetch('rightPanelAction'));
		}
		else
		{
			$this->set('left', PublicController::fetch('leftPanelAction'));
			$this->set('right', PublicController::fetch('rightPanelAction'));
		}
	}
}
