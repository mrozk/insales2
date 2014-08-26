
<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_InsalesUser extends ORM
{
    protected $_table_columns = array(
                                        'id' =>  array (),
                                        'token' =>  array (),
                                        'shop' => array (),
                                        'insales_id' => array (),
                                        'passwd' => array (),
                                        'delivery_variant_id' => array (),
                                        'settings' => array ()
    );

}