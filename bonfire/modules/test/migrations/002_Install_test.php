<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_test extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'test_abc' => array(
				'type' => 'DATETIME',
				'default' => '0000-00-00 00:00:00',
				
			),
			'test_qwerty1' => array(
				'type' => 'VARCHAR',
				'constraint' => 15,
				
			),
			'test_qwerty' => array(
				'type' => 'VARCHAR',
				'constraint' => 15,
				
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('test');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('test');

	}

	//--------------------------------------------------------------------

}