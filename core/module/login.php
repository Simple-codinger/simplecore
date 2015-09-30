<?php
	namespace trainMan\core\module;
	use trainMan\core\config as config;
	use trainMan\core\module\ldap as ldap;
	use trainMan\core\module\user as user;
	use trainMan\core\db\sql as sql;

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
					global $cSession;
					$cSession->createSession(config::getConfiguration("SessionNameUser"), serialize(new user($user)));
					return true;
				}
				else
				{
					return false;
				}
			}
			else{
				return false;
			}
		}

		public static function isLoggedIn(){
			global $cSession;
			return $cSession->existsSession(config::getConfiguration("SessionNameUser"));
		}

		public static function logout(){
			global $cSession;
			$cSession->destroySession(config::getConfiguration("SessionNameUser"));
		}

	}
?>