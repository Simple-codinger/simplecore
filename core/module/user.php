<?php
	namespace trainMan\core\module;
	class user{

		private $_user;

		public function __construct($user){
			$this->_user = $user;
		}

		public function getId(){
			return $this->_user['id'];
		}

		public function getUsername(){
			return $this->_user['username'];
		}
	}
?>