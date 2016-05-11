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

    public static function validate($factory) {
        $val = Validation::forge($factory);
        $val->add_field('title', 'Title', 'required|max_length[255]');
        $val->add_field('summary', 'Summary', 'required');
        //$val->add_field('date', 'Date', 'required|valid_string[numeric]');
        $val->add_field('date', 'Date', 'required');
        //$val->add_field('date_keywords', 'Date Keywords', 'required');

        return $val;
    }

}
