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
class Migration_insert_point_price extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_function = array(
            array('id' => 1, 'rank_id' => 6,'price' => 6000),
            array('id' => 2, 'rank_id' => 7,'price' => 7000),
            array('id' => 3, 'rank_id' => 8,'price' => 8000),
            array('id' => 4, 'rank_id' => 9,'price' => 9000),
            array('id' => 5, 'rank_id' => 10,'price' => 10000),
            array('id' => 6, 'rank_id' => 11,'price' => 11000),
        );
        $this->db->insert_batch('point_price', $data_function); 
	}


	public function down()
	{
		
	}

}