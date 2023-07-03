<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_api_limits
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_pendapatan extends CI_Migration {


	public function up()
	{ 
		$table = "pendapatan";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'tanggal'      => [
				'type' => 'DATETIME',
			],	
			'id_order'      => [
				'type' => 'INT(11)',
			],
			'id_user'      => [
				'type' => 'INT(11)',
			],
			'total_pendapatan'      => [
				'type' => 'INT(11)',
			],
			'status'      => [
				'type' => 'INT(11)',
			],
			'is_deleted' => [
				'type' => 'TINYINT(4)',
			],
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);
	 
	}


	public function down()
	{
		$table = "pendapatan";
		if ($this->db->table_exists($table))
		{
			$this->db->query(drop_foreign_key($table, 'api_key'));
			$this->dbforge->drop_table($table);
		}
	}

}
