<?php

namespace Fuel\Migrations;

class Create_upload_types
{
	public function up()
	{
		\DBUtil::create_table('upload_types', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'types' => array('constraint' => 50, 'type' => 'varchar'),
			'types_order' => array('constraint' => 5, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('upload_types');
	}
}