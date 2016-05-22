<?php

use Orm\Model;

class Model_Article extends Model {

    protected static $_properties = array(
        'id',
        'category_id',
        'user_id',
        'editor_id',
        'name',
        'url_title',
        'description',
        'keywords',
        'status' => array(
            'default' => 'A',
        ),
        'deleted' => array(
            'default' => 0,
        ),
        'completion' => array(
            'default' => 'NC',
        ),
        'created_at',
        'updated_at',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_has_one = array(
        'detail' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Article_Detail',
            'key_to' => 'article_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );
    protected static $_has_many = array(
        'dates' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Date',
            'key_to' => 'article_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );

    public static function validate($factory) {
        $val = Validation::forge($factory);
        $val->add_field('category_id', 'Category Id', 'required|valid_string[numeric]');
        $val->add_field('name', 'Name', 'required|max_length[255]');
        //$val->add_field('description', 'Description', 'required');
        //$val->add_field('keywords', 'Keywords', 'required');
        //$val->add_field('image', 'Image', 'required|max_length[255]');

        return $val;
    }

    public function getDetail() {

        if ($this->detail === null) {
            $this->detail = new Model_Article_Detail();
            $this->save();
        }
        return $this->detail;
    }

}
