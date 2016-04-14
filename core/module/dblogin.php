<?php
	namespace simplecore\core\module;

	use simplecore\core\module\user as user;
	use simplecore\core\system as system;

	class login{

		private $_credentials = array("username" => null, "password" => null);

		public function __construct($username, $password){
			$this->_credentials["username"] = $username;
			$this->_credentials["password"] = $password;
		}

		public function isUserAuthorized(){
			//is anything empty?
			if(empty($this->_credentials["username"])||empty($this->_credentials["password"])){return false;}

			$user = repo::getUserByUsername($this->_credentials["username"]);
			if(!is_null($user))
			{
				if(crypt($this->_credentials["password"], $user->getPassword()) == $user->getPassword()){
					system::getClassInstance("cUser")->create($user);
					return true;
				}
			}
			return false;
		}
	}
?>
