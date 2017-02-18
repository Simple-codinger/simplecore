<?php
	namespace simpleinventory\simplecore;
	class config{
		private static $_config = array(
			"ldapServerPrefix" => "server\\",
			"ldapServer" => "",
			"SessionNameUser" => "simpleInventoryUser",
			"notAuthorizedPage" => "login.php",
			"databaseConfig" => array(
										'dbname' => 'simple_inventory',
										'user' => 'root',
										'password' => '',
										'host' => '127.0.0.1')
			);

		public static function getConfiguration($key){
			return self::$_config[$key];
		}
	}
?>
