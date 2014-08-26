<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Main extends Controller_Admin_Layout{

    // Главная страница
    public function action_index()
    {
        $this->template->set('content', View::factory('admin/dashboard'));
    }

} // End Main