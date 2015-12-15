<?php
/*Author Gierisch Vincent*/
/* Thanks to Sebastian Kraemer for supporting me*/
	namespace simplecore\core\db;
	use PDO;
	use simplecore\core\system as system;

	class sql{
		private static $_userTable = "user";

		public static function getUser($username){
			$temp = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".self::$_userTable." WHERE `username` = :username AND `deleteInfo` = 0");
			$temp->bindParam(':username', $username, PDO::PARAM_STR);
			$temp->execute();
			$assoc = $temp->fetchAll(PDO::FETCH_ASSOC);
			return @$assoc[0];
		}

		public static function setUser($persNr, $username, $firstname, $lastname){
			$temp = system::getClassInstance("database")->getConnection()->prepare("INSERT INTO ".self::$_userTable."(personalnumber, username, firstname, lastname) VALUES (:persNr, :username, :firstname, :lastname)");
			$temp->bindParam(':persNr', $persNr, PDO::PARAM_STR);
			$temp->bindParam(':username', $username, PDO::PARAM_STR);
			$temp->bindParam(':firstname', $firstname, PDO::PARAM_STR);
			$temp->bindParam(':lastname', $lastname, PDO::PARAM_STR);
			return $temp->execute();
		}

		public static function getAllUser(){
			$temp = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".self::$_userTable." WHERE `deleteInfo` = 0");
			$temp->execute();
			return $temp->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function deleteUser($persNr){
			$temp = system::getClassInstance("database")->getConnection()->prepare("UPDATE ".self::$_userTable." SET `deleteInfo` = 1 WHERE `personalnumber` = :persNr");
			$temp->bindParam(':persNr', $persNr, PDO::PARAM_STR);
			return $temp->execute();
		}

		public static function doUserExists($persNr){
			$temp = system::getClassInstance("database")->getConnection()->prepare("SELECT COUNT(id) as count FROM ".self::$_userTable." WHERE `deleteInfo` = 0 AND `personalnumber` = :persNr");
			$temp->bindParam(':persNr', $persNr, PDO::PARAM_STR);
			$temp->execute();
			return $temp->fetchAll(PDO::FETCH_ASSOC)[0]["count"];
		}
	}
?>
