<?php
class PublicController extends Controller
{
	function leftPanelAction()
	{		
		return $this->view();
	}
	
	function rightPanelAction()
	{
		return $this->view();
	}
}
