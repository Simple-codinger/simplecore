<?php
	namespace simpleinventory\simplecore\module;

	use simpleinventory\simplecore\module\user as user;
	use simpleinventory\simplecore\system as system;
	use simpleinventory\simplecore\repository\userRepository as repo;

	class dblogin{

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
					system::getServiceClassInstance("cUser")->create($user);
					return true;
				}
			}
			return false;
		}
	}
?>
