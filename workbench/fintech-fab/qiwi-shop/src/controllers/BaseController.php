<?php

namespace FintechFab\QiwiShop\Controllers;


use Controller;
use View;

class BaseController extends Controller
{

	private $sLayoutFolderName = 'default';

	protected function setupLayout()
	{
		if (!is_null($this->layout)) {
			$this->sLayoutFolderName = $this->layout;
			$this->layout = View::make('ff-qiwi-shop::layouts.' . $this->layout);
		}
	}

}