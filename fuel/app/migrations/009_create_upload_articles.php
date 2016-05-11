<?php

namespace Fuel\Migrations;

class Create_upload_articles
{
	public function up()
	{
		\DBUtil::create_table('upload_articles', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'upload_id' => array('constraint' => 11, 'type' => 'int'),
			'article_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('upload_articles');
	}
}