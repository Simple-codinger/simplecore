<?php
namespace simplecore\core\db\driver;
	interface iDriver
	{
		public function connect(array $params, $username = null, $password = null, array $driverOptions = array());
	}
?>
