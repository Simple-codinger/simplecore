<?php
	namespace trainMan\core\module;

	use trainMan\core\module\user as user;
	use trainMan\core\config as config;
	use trainMan\core\system as system;

	class currentUser{

		private static $_instance = null;
		private $_exist = false;
		private $_key;
		private $_session;
		private $_user;

		//Singleton
		public static function getInstance(){
			if(is_null(self::$_instance)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct(){
			$this->_session = system::getClassInstance("session");
			$this->_key = config::getConfiguration("SessionNameUser");

			if($this->_session->existsSession($this->_key)){
				if((unserialize($this->_session->getSession($this->_key)) instanceof user)){
					$this->_user = (unserialize($this->_session->getSession($this->_key)));
					$this->_exist = true;
				}
			}
		}

		public function getUser(){
			if($this->_exist){
				return $this->_user;
			}
		}

		public function existUser(){
			return $this->_exist;
		}

		public function create($user){
			if(!$this->_session->existsSession($this->_key)){
				$this->_user = $user;
				$this->_session->createSession($this->_key, serialize($this->_user));
				$this->_exist = true;
			}
		}

		public function delete(){
			$this->_session->unsetSession($this->_key);
			$this->__destruct();
		}

		public function __destruct(){
			$this->_exist = false;
			$_instance = null;
		}
	}
?>
