<?php
/*Author Gierisch Vincent, PersNr.: 4974, Tel.: 2350*/
/* Thanks to Sebastian Kraemer for supporting me*/
	namespace trainMan\core\db;
	use PDO;
	use trainMan\core\system as system;
	
	class sql{
		private static $_userTable = "user";
		private static $_responsibleTable = "responsible";
		private static $_departmentTable = "department";
		private static $_department_responsibleTable = "department_responsible";


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

		public static function getAllResponsibles(){
			$temp = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".self::$_responsibleTable." WHERE `deleteInfo` = 0");
			$temp->execute();
			return $temp->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getResponsiblesFromDepartment($dep_id){
			$temp = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".self::$_responsibleTable." r INNER JOIN ".self::$_department_responsibleTable." dr ON dr.responsible_id = r.id WHERE r.deleteInfo = 0 AND dr.department_id = :depId");
			$temp->bindParam(':depId', $dep_id, PDO::PARAM_INT);
			$temp->execute();
			return $temp->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function setResponsible($firstname, $lastname, $persNr, $userPersNr){
			$temp = system::getClassInstance("database")->getConnection()->prepare("INSERT INTO ".self::$_responsibleTable." (`firstname`, `lastname`, `personalnumber`, `userPersonalnumber`) VALUES (:firstname, :lastname, :persNr, :userPersNr)");
			$temp->bindParam(':firstname', $firstname, PDO::PARAM_STR);
			$temp->bindParam(':lastname', $lastname, PDO::PARAM_STR);
			$temp->bindParam(':persNr', $persNr, PDO::PARAM_STR);
			$temp->bindParam(':userPersNr', $userPersNr, PDO::PARAM_STR);
			return $temp->execute();
		}

		public static function deleteResponsible($id){
			$temp = system::getClassInstance("database")->getConnection()->prepare("UPDATE ".self::$_responsibleTable." SET `deleteInfo` = 1 WHERE `id` = :id");
			$temp->bindParam(':id', $id, PDO::PARAM_INT);
			return $temp->execute();
		}

		public static function getAllDepartments(){
			$temp = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".self::$_departmentTable." WHERE deleteInfo = 0");
			$temp->execute();
			return $temp->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function addDepartment($short, $description, $color, $responsibles){
			//insert in multiple tables. Best solution is an transaction
			$temp = system::getClassInstance("database")->getConnection();
			try{
				$temp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$temp->beginTransaction();
				$pre = $temp->prepare("INSERT INTO ".self::$_departmentTable." (name, description, color_code) VALUES (:name, :description, :color_code)");
				$pre->bindParam(':name', $short, PDO::PARAM_STR);
				$pre->bindParam(':description', $description, PDO::PARAM_STR);
				$pre->bindParam(':color_code', $color, PDO::PARAM_STR);
				$pre->execute();
				$lastId = $temp->lastInsertId();
				foreach($responsibles as $id){
					$pre = $temp->prepare("INSERT INTO ".self::$_department_responsibleTable." (responsible_id, department_id) VALUES (:r_id, :d_id)");
					$pre->bindParam(':r_id', $id, PDO::PARAM_INT);
					$pre->bindParam(':d_id', $lastId, PDO::PARAM_INT);
					$pre->execute();
				}
				return $temp->commit();
			}catch(Exception $e){
				$temp->rollBack();
				return false;
			}
		}

		public static function deleteDepartment($id){
			$temp = system::getClassInstance("database")->getConnection()->prepare("UPDATE ".self::$_departmentTable." SET `deleteInfo` = 1 WHERE `id` = :id");
			$temp->bindParam(':id', $id, PDO::PARAM_INT);
			return $temp->execute();
		}
	}
?>
