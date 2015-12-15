<?php
	namespace simplecore\core\db\driver\sqlsrv;
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
			} catch(PDOExcetion $e){
				throw new Exception($e->getMessage(), 1);
			}
			return $conn;
		}

		private function _pdoDsn(array $params)
		{
			$dsn = 'sqlsrv:server=';
			if (isset($params['host'])) {
				$dsn .= $params['host'];
			}
			if (isset($params['port']) && !empty($params['port'])) {
				$dsn .= ',' . $params['port'];
			}
			if (isset($params['dbname'])) {
				$dsn .= ';Database=' .  $params['dbname'];
			}
			if (isset($params['MultipleActiveResultSets'])) {
				$dsn .= '; MultipleActiveResultSets=' . ($params['MultipleActiveResultSets'] ? 'true' : 'false');
			}
			return $dsn;
		}
	}
?>
