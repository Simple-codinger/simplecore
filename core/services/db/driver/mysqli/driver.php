<?php
	namespace simplecore\core\services\db\driver\mysqli;
	use simplecore\core\services\db\driver\iDriver as iDriver;
	use simplecore\core\services\db\PDOConnection as PDOConnection;
	class driver implements iDriver
	{
		public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
		{
			try{
				$conn = new PDOConnection(
					$this->_pdoDsn($params),
					$username,
					$password,
					$driverOptions
				);
				$conn->exec("SET CHARACTER SET utf8");
			} catch(PDOExcetion $e){
				throw new Exception($e->getMessage(), 1);
			}
			return $conn;
		}

		private function _pdoDsn(array $params)
		{
			$dsn = 'mysql:';
	        if (isset($params['host']) && $params['host'] != '') {
	            $dsn .= 'host=' . $params['host'] . ';';
	        }
	        if (isset($params['port'])) {
	            $dsn .= 'port=' . $params['port'] . ';';
	        }
	        if (isset($params['dbname'])) {
	            $dsn .= 'dbname=' . $params['dbname'] . ';';
	        }
	        if (isset($params['unix_socket'])) {
	            $dsn .= 'unix_socket=' . $params['unix_socket'] . ';';
	        }
	        if (isset($params['charset'])) {
	            $dsn .= 'charset=' . $params['charset'] . ';';
	        }
	        return $dsn;
		}
	}
?>
