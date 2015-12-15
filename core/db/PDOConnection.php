<?php
	namespace simplecore\core\db;
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
	}
?>
