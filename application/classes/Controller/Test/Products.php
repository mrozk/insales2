<?php
/**
 * Created by PhpStorm.
 * User: mrozk
 * Date: 18.05.14
 * Time: 11:58
 */

class Controller_Test_Products extends Controller_Template {

    public $template = 'index';

    public function action_index()
    {
        $books = Model::factory('Test_Products')->all_products();

        $this->template->content = View::factory('products', array(
                'books'=>$books,));
    }

}