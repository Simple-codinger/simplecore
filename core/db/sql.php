<?php
/*Author Gierisch Vincent, PersNr.: 4974, Tel.: 2350*/
/* Thanks to Sebastian Kraemer for supporting me*/
	namespace trainMan\core\db;
	use PDO;
	class sql{
		private static $_userTable = "user";


		public static function getUser($username){
			global $dDb;
			$temp = &$dDb->getConnection()->prepare("SELECT * FROM ".self::$_userTable." WHERE `username` = :username AND `deleteInfo` = 0");
			$temp->bindParam(':username', $username, PDO::PARAM_STR);
			$temp->execute();
			$assoc = $temp->fetchAll(PDO::FETCH_ASSOC);
			return @$assoc[0];
		}

	}
?>