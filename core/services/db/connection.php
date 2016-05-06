<?php
	namespace simplecore\core\services\db;
	use simplecore\core\services\db\driver\iDriver as Driver;

	class connection
	{
		private $_params = array();
		private $_driver;
		private $_isConnected = false;
		private $_conn;
		private static $_instance = null;

		//Singleton
		public static function getInstance(){
			if(!self::$_instance){
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct(){
			//Nothing to do here
		}

		private function _connect(){
			if($this->_isConnected){
				return false;
			}

			$driverOptions = isset($this->_params['driverOptions']) ? $this->_params['driverOptions'] : array();
			$user = isset($this->_params['user']) ? $this->_params['user'] : null;
			$password = isset($this->_params['password']) ? $this->_params['password'] : null;

			$this->_conn = $this->_driver->connect($this->_params, $user, $password);
			$this->_isConnected = true;

			return true;
		}

		public function connect(array $params, Driver $driver){
			$this->_driver = $driver;
			$this->_params = $params;

			$this->_connect();
		}

	    public function getConnection(){
	    	if($this->_isConnected)
	    	{
	    		return $this->_conn;
	    	}
	    }

	    public function isConnected(){
	    	return $this->_isConnected;
	    }

	    public function __destruct(){
	    	$this->_conn = null;
	    	$this->_isConnected = false;
	    }
	}
?>
