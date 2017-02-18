<?php
	namespace simpleinventory\simplecore\services\db;
	use PDO;
	class PDOConnection extends PDO
	{
		public function __construct($dsn, $user = null, $password = null, array $options = null)
		{
			try{
				parent::__construct($dsn, $user, $password, $options);
			} catch(PDOException $e){
				throw new PDOException($e);
			}
		}

		public function select($sql, $values = array(), $fetchMode = PDO::FETCH_ASSOC){
			$query = $this->prepare($sql);
			foreach($values as $key => $value){
				$query->bindValue($key, $value);
			}
			if(!$query->execute()){
				throw new Exception("Failure: Database", 1);
				return;
			}
			return $query->fetchAll($fetchMode);
		}
	}
?>
