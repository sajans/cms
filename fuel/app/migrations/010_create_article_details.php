<?php

namespace Fuel\Migrations;

class Create_article_details
{
	public function up()
	{
		\DBUtil::create_table('article_details', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'mother_tongue' => array('constraint' => 50, 'type' => 'varchar'),
			'eye_colour' => array('constraint' => 50, 'type' => 'varchar'),
			'spouse' => array('constraint' => 100, 'type' => 'varchar'),
			'childreen' => array('constraint' => 2, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('article_details');
	}
}