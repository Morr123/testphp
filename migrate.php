<?php

require __DIR__.'/vendor/autoload.php';

use migrations\CreateUsersTable;

//TODO Auto get classes
if(!isset($argv[1]) || $argv[1] === 'up'){
	CreateUsersTable::up();
}else if($argv[1] === 'down'){
	CreateUsersTable::down();
}else{
	throw new \Exception('Please use "up" or "down" argument');
}
