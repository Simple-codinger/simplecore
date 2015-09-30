<?php
	namespace trainMan\core\db;
	use trainMan\core\db\driver\iDriver as Driver;
	
	class connection
	{
		private $_params = array();
		private $_driver;
		private $_isConnected = false;
		private $_conn;

		public function __construct(array $params, Driver $driver)
		{
			$this->_driver = $driver;
			$this->_params = $params;

			$this->_connect();
		}

		private function _connect()
		{
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

	    public function &getConnection(){
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