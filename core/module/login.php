<?php
	namespace simplecore\core\module;

	use simplecore\core\config as config;
	use simplecore\core\module\ldap as ldap;
	use simplecore\core\module\user as user;
	use simplecore\core\db\sql as sql;
	use simplecore\core\system as system;

	class login{

		private $_username;
		private $_password;

		public function __construct($username, $password){
			$this->_username = $username;
			$this->_password = $password;
		}

		public function isUserAuthorized(){
			//is anything empty?
			if(empty($this->_username)||empty($this->_password)){return false;}

			//new LdapModule Object
			$ldapModule = new ldap($this->_username, $this->_password);

			//is User LDAP authorized?
			if($ldapModule->ldapLogin())
			{
				//get user from database
				$user = sql::getUser($this->_username);
				if(!empty($user))
				{
					system::getClassInstance("cUser")->create(new user($user));
					return true;
				}
			}
			return false;
		}
	}
?>
