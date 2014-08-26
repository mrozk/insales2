<?php defined('SYSPATH') or die('No direct script access.');

class Model_Install extends Model {

    public function add_user( $token, $shop, $insales_id, $password )
    {
        if (!isset($HTTP_RAW_POST_DATA))
            $HTTP_RAW_POST_DATA = file_get_contents("php://input");

        return $HTTP_RAW_POST_DATA;

    }

    public static function insert($table = NULL, array $columns = NULL)
    {
        return new Database_Query_Builder_Insert($table, $columns);
    }
}
