<?php
	namespace simplecore\core\module;
	use simplecore\core\orm\DataObject as DataObject;
	class user extends DataObject{

		private $id;
		private $username;
		private $firstname;
		private $lastname;
		private $personalnumber;
		//just for saving into db
		public static $tableName = "user";
		public static $fields = array('id', 'username', 'firstname', 'lastname', 'personalnumber');

		public function __construct(){

		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getUsername(){
			return $this->username;
		}

		public function setUsername($username){
			$this->username = $username;
		}

		public function getFirstname(){
			return $this->firstname;
		}

		public function setFirstname($firstname){
			$this->firstname = $firstname;
		}

		public function getLastname(){
			return $this->lastname;
		}

		public function setLastname($lastname){
			$this->lastname = $lastname;
		}

		public function getPersonalnumber(){
			return $this->personalnumber;
		}

		public function setPersonalnumber($personalnumber){
			$this->personalnumber = $personalnumber;
		}
	}
?>
