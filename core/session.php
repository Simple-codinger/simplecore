<?php
	namespace trainMan\core;
	class session{
	
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
		
		public function unsetSession($mKey){
			unset($_SESSION[''.$mKey.'']);
		}
		
		public function destroySession(){
			session_destroy();
		}
	}
?>