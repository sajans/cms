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
    protected static $_many_many = array(
        'uploads' => array(
            'key_from' => 'id',
            'key_through_from' => 'article_id',
            'table_through' => 'upload_articles',
            'key_through_to' => 'upload_id',
            'model_to' => 'Model_Upload',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
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

    public static function validateEdit($factory) {
        $val = Validation::forge($factory);
        //$val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('description', 'Description', 'required');
        //$val->add_field('keywords', 'Keywords', 'required');
        //$val->add_field('image', 'Image', 'required|max_length[255]');

        return $val;
    }

    public static function getFields() {
        $result = array();
        $sep = " ";
        $ignore = array('id', 'category_id', 'user_id', 'editor_id', 'name', 'keywords', 'url_title', 'status', 'deleted', 'completion', 'created_at', 'updated_at');
        foreach (self::$_properties as $key => $property) {
            $labelArray = array();
            if (is_array($property)) {
                if (!in_array($key, $ignore)) {
                    $labelArray = explode("_", $key);
                }
            } else {
                if (!in_array($property, $ignore)) {
                    $labelArray = explode("_", $property);
                }
            }
            $label = "";
            $countlabelArray = count($labelArray);
            if ($countlabelArray >= 1) {
                for ($i = 0; $i < $countlabelArray; $i++) {
                    if ($i != 0) {
                        $label .=$sep;
                    }
                    $label .= ucfirst($labelArray[$i]);
                }
                $result[$property] = $label;
            }
        }
        return $result;
    }

    public function getDetail() {

        if ($this->detail === null) {
            $this->detail = new Model_Article_Detail();
            $this->save();
        }
        return $this->detail;
    }

    public function getUploads($type = null, $limit = null) {

        if ($type) {
            if (count($this->uploads) >= 1) {
                foreach ($this->uploads as $key => $upload) {
                    $k = $key;
                    if ($upload->type_id != $type) {
                        unset($this->uploads[$key]);
                    }
                }
            }
        }
        if ($limit) {
            if (count($this->uploads) >= 1) {
                $uploads = $this->uploads[$k];
            } else {
                $uploads = null;
            }
        }
       //echo "<pre>"; var_dump($uploads); exit;
        return $uploads;
    }

}
