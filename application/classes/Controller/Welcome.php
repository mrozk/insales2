<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
        Notice::add( Notice::ERROR,'Доступ только из админпанели магазина insales' );
	}
} // End Welcome
