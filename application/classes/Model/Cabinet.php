<?php defined('SYSPATH') or die('No direct script access.');

class Model_Cabinet extends Model {

    public function get_insales( $insales_id )
    {
        $query = DB::select()->from('insales_users')->where('insales_id', '=', $insales_id)->execute();
        return $query;
    }


    public function action_enter()
    {

    }

}