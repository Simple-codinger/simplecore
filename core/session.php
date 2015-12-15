<?php
	namespace simplecore\core;
	class session{

		private static $_instance = null;

		//Singleton

		public static function getInstance(){
			if(is_null(self::$_instance)){
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct(){
			if(!isset($_SESSION)) {
				session_start();
			}
		}

		public function existsSession($mKey) {
			return isset($_SESSION[$mKey]);
		}

		public function createSession($mKey, $mValue) {
				$_SESSION[$mKey] = $mValue;
		}

		public function getSession($key){
			return $_SESSION[$key];
		}

		public function unsetSession($mKey){
			unset($_SESSION[''.$mKey.'']);
		}

		public function destroySession(){
			session_destroy();
		}
	}
?>
