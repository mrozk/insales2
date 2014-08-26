<?php defined('SYSPATH') or die('No direct script access.');

class Model_Test_Products extends Model {

    protected $_tableArticles = 'articles';

    public function all_products(){
        $sql = "SELECT * FROM ". $this->_tableArticles;

        return DB::query(Database::SELECT, $sql)
            ->execute();
    }
}