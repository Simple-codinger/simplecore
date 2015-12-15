<?php
	namespace simplecore\core;
	class config{
		private static $_config = array(
			"ldapServerPrefix" => "server\\",
			"ldapServer" => "",
			"SessionNameUser" => "simplecoreUser",
			"notAuthorizedPage" => "login.php",
			"databaseConfig" => array(
										'dbname' => '',
										'user' => '',
										'password' => '',
										'host' => '')
			);

		public static function getConfiguration($key){
			return self::$_config[$key];
		}
	}
?>
