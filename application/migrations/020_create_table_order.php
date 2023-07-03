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
class Migration_create_table_order extends CI_Migration {


	public function up()
	{ 
		$table = "order";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'id_joki'      => [
				'type' => 'INT(11)',
			],
			'tanggal'      => [
				'type' => 'DATE',
			],
			'email'      => [
				'type' => 'VARCHAR(100)',
			],
			'password'      => [
				'type' => 'VARCHAR(100)',
			],
			'request_hero'      => [
				'type' => 'TEXT',
			],
			'catatan'      => [
				'type' => 'TEXT',
			],
			'nickname'      => [
				'type' => 'VARCHAR(100)',
			],
			'login_via'      => [
				'type' => 'VARCHAR(100)',
			],
			'id_paket'      => [
				'type' => 'INT(11)',
			],
			'nomor_whatsapp'      => [
				'type' => 'VARCHAR(20)',
			],
			'bukti_pembayaran'      => [
				'type' => 'VARCHAR(100)',
			],
			'id_bukti_pengerjaan'      => [
				'type' => 'VARCHAR(100)',
			],
			'status_orderan'      => [
				'type' => 'TINYINT(4)',
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
		$table = "order";
		if ($this->db->table_exists($table))
		{
			$this->db->query(drop_foreign_key($table, 'api_key'));
			$this->dbforge->drop_table($table);
		}
	}

}
