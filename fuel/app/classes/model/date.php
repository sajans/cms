<?php

use Orm\Model;

class Model_Date extends Model {

    protected static $_properties = array(
        'id',
        'article_id',
        'title',
        'summary',
        'date',
        'date_keywords',
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
    protected static $_belongs_to = array(
        'article' => array(
            'key_from' => 'article_id',
            'model_to' => 'Model_Article',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
    );

    public static function validate($factory) {
        $val = Validation::forge($factory);
        $val->add_field('title', 'Title', 'required|max_length[255]');
        $val->add_field('summary', 'Summary', 'required');
        $val->add_field('date', 'Date', 'required');
        $val->add_field('date_keywords', 'Date Keywords', 'required');

        return $val;
    }
    
        public static function validateEdit($factory) {
        $val = Validation::forge($factory);
        $val->add_field('title', 'Title', 'required|max_length[255]');
       // $val->add_field('summary', 'Summary', 'required');
        $val->add_field('date', 'Date', 'required');
       // $val->add_field('date_keywords', 'Date Keywords', 'required');

        return $val;
    }

    public static function getFields() {
        $result = array();
        $sep = " ";
        $ignore = array('id', 'article_id', 'created_at', 'updated_at');
        foreach (self::$_properties as $property) {
            if (!in_array($property, $ignore)) {
                $labelArray = explode("_", $property);
                $label = "";
                for ($i = 0; $i < count($labelArray); $i++) {
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

}
