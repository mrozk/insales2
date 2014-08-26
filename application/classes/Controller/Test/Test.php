<?php
/**
 * Created by PhpStorm.
 * User: mrozk
 * Date: 18.05.14
 * Time: 11:58
 */

class Controller_Test_Test extends Controller {
    public function action_index()
    {
        $this->response->body('hello, world!');
    }
}