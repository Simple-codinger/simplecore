<?php
	namespace trainMan\core;
	class config{
		private static $_config = array(
			"ldapServerPrefix" => "mdom1\\",
			"ldapServer" => "172.20.1.1",
			"SessionNameUser" => "trainManUser",
			"notAuthorizedPage" => "login.php",
			"databaseConfig" => array(
										'dbname' => 'trainMan',
										'user' => 'root',
										'password' => 'geheim',
										'host' => '172.20.104.216')
			);

		public static function getConfiguration($key){
			return self::$_config[$key];
		}
	}
?>
