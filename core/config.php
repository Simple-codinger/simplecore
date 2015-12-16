<?php
	namespace simplecore\core;
	class config{
		private static $_config = array(
			"ldapServerPrefix" => "server\\",
			"ldapServer" => "",
			"SessionNameUser" => "simplecoreUser",
			"notAuthorizedPage" => "login.php",
			"databaseConfig" => array(
										'dbname' => 'simplecore',
										'user' => 'root',
										'password' => '',
										'host' => '127.0.0.1')
			);

		public static function getConfiguration($key){
			return self::$_config[$key];
		}
	}
?>
