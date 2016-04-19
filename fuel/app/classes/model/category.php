<?php
use Orm\Model;

class Model_Category extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'keywords',
		'meta',
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('keywords', 'Keywords', 'required');
		$val->add_field('meta', 'Meta', 'required');

		return $val;
	}

}
