<?php

namespace back\Models;

use back\Models\DB\DB;

class User extends Model{
	
	protected static $tableName = 'users';
	
	protected static $fillable = [
		'name',
		'email',
		'phone',
		'date',
		'status'
	];
}
