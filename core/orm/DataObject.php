<?php
	namespace simplecore\core\orm;
	use simplecore\core\system as system;
	abstract class DataObject implements \JsonSerializable{

		public static $tableName;
		private static $fields = array('id');
		private $isNew = true;

		function __construct(){

		}

		public static function getById($id){
			//get static properties from sub class
			$className = get_called_class();
			$classVars = get_class_vars($className);

			//SELECT
			$stmt = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".$classVars['tableName']." WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			$result = $stmt->fetch(\PDO::FETCH_ASSOC);

			//Create new Instance
			$object = new $className;
			//Instance is not new
			$object->setIsNew(false);
			//set fields of Instance
			foreach ($result as $field_name => $value) {
				$setter = "set" . str_replace(' ', '', ucwords(str_replace('_', ' ', $field_name)));
				$object->$setter($result[$field_name]);
			}
			return $object;
		}

		public static function getAll(){
			//get static properties from sub class
			$className = get_called_class();
			$classVars = get_class_vars($className);

			//SELECT
			$stmt = system::getClassInstance("database")->getConnection()->prepare("SELECT * FROM ".$classVars['tableName']);
			$stmt->execute();

			$objectIds = $stmt->fetchAll(\PDO::FETCH_ASSOC);

			$objects = array();

			foreach ($objectIds as $objectId) {
				$objects[] = $className::getById($objectId['id']);
			}
			return $objects;
		}

		public function save(){
			if(!$this->isNew){
				return false;
			}

			$className = get_called_class();
			$classVars = get_class_vars($className);

			$mFields = $classVars['fields'];
			if($key = array_search('id', $mFields)){
				unset($mFields[$key]);
			}

			//prepare query
			$query = "INSERT INTO ". $classVars['tableName']. '(';
			//Add fields to query
			$i = 0;
			foreach($mFields as $field){
				$query .= '`'. $field .'`';

				if(++$i !== count($mFields)){$query .= ', ';}
			}

			$query .= ') VALUES (';

			//Add value placeholder to query
			for($i=0; $i<count($mFields); $i++){
				$query .= '?';

				if($i < count($mFields) - 1){$query .= ', ';}
			}

			$query .= ')';

			$stmt = system::getClassInstance("database")->getConnection()->prepare($query);

			//get values from object
			$values = array();
			$i = 0;
			foreach($mFields as $field_name){
				$i++;
				$getter = "get" . str_replace(' ', '', ucwords(str_replace('_', ' ', $field_name)));
				$values[] = $this->$getter();
			}

			//write to database
			$stmt->execute($values);

			//set id to the DataObject
			$this->setId(system::getClassInstance("database")->getConnection()->lastInsertId());

			//Declare this DataObject is not new
			$this->setIsNew(false);

			return true;
		}

		public function delete(){
			$className = get_called_class();
			$classVars = get_class_vars($className);

			$stmt = system::getClassInstance("database")->getConnection()->prepare("DELETE FROM ". $classVars['tableName'] ." WHERE id = :id");
			$stmt->bindParam(":id", $this->getId());
			return $stmt->execute();
		}

		function jsonSerialize(){
			$className = get_called_class();
			$classVars = get_class_vars($className);

			$result = array();

			foreach($classVars['fields'] as $field_name){
				$getter = "get" . str_replace(' ', '', ucwords(str_replace('_', ' ', $field_name)));
				$result[$field_name] = $this->$getter(true);
			}

			return $result;
		}

		public function isIsNew(){
			return $this->isNew;
		}

		public function setIsNew($isNew){
			$this->isNew = $isNew;
		}
	}
?>
