<?php
	namespace simplecore\module;
	class user{

		private $id;
		private $username;
		private $password;
		private $firstname;
		private $lastname;

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

		public function getPassword(){
			return $this->password;
		}

		public function setPassword($password){
			$this->password = $password;
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
	}
?>
