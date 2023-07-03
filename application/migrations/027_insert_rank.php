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
class Migration_insert_rank extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_function = array(
            array('id' => 1, 'name' => 'Warior'),
            array('id' => 2, 'name' => 'Master'),
            array('id' => 3, 'name' => 'Grand Master'),
            array('id' => 4, 'name' => 'Epic'),
            array('id' => 5, 'name' => 'Legend'),
            array('id' => 6, 'name' => 'Mythic 5'),
            array('id' => 7, 'name' => 'Mythic 4'),
            array('id' => 8, 'name' => 'Mythic 3'),
            array('id' => 9, 'name' => 'Mythic 2'),
            array('id' => 10, 'name' => 'Mythic 1'),
            array('id' => 11, 'name' => 'Mythical Glory'),
        );
        $this->db->insert_batch('rank', $data_function); 
	}


	public function down()
	{
		
	}

}