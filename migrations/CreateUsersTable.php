<?php

namespace migrations;

use back\Models\DB\DB;

class CreateUsersTable{
	
	public static function up(){
		DB::execute('
			CREATE TABLE users(
				id int NOT NULL AUTO_INCREMENT,
				name       VARCHAR(255),
				email      VARCHAR(50),
				phone      VARCHAR(12),
				date       DATE,
				status     SMALLINT,
				PRIMARY KEY (id)
			)
		');
	}
	
	public static function down(){
		DB::execute('DROP TABLE IF EXISTS users');
	}

}
