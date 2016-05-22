<?php

class Model_Article_Detail extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'article_id',
        'mother_tongue',
        'eye_colour',
        'spouse',
        'childreen',
        'created_at',
        'updated_at',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_table_name = 'article_details';
    protected static $_belongs_to = array(
        'article' => array(
            'key_from' => 'article_id',
            'model_to' => 'Model_Article',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
    );

    public static function getFields() {
        $result = array();
        $sep = " ";
        $ignore = array('id','article_id','created_at', 'updated_at');
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
