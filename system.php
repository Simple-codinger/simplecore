<?php
/*Author Gierisch Vincent
Thanks to Domink Ganic for supporting me*/
	namespace simplecore;

	class system{
		private static $arrObjects = array();

		public function __construct(){
			spl_autoload_register(array($this, '_coreLoader'));
			$this->_defineClasses();
		}

		private function _defineClasses(){
			//no globals
			//work with singleton and import function

			self::import("simplecore\\session", "session");
			self::import("simplecore\\db\\connection", "database");
			self::getClassInstance("database")->connect(\simplecore\config::getConfiguration("databaseConfig"), new \simplecore\db\driver\mysqli\driver());
		}

		private function _coreLoader($className){
       		$file = ltrim($className, '\\');  // Evntl. vorangegangenen Backslashes entfernen
	        $file_array = explode('\\', $file);
	        array_shift($file_array); // Root-Namespace entfernen

	        $file = implode(DIRECTORY_SEPARATOR, $file_array);
	        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . $file . '.php';
	        if(file_exists($path)) include $path; // Pfad der Klasse einbinden
	        else die($path . " could not load to the project!");
		}

		/**
		 * Import a service and make it accessible by its name or an optional key
		 *
		 * @param string  $strClass The class name
		 * @param string  $strKey   An optional key to store the object under
		 * @param boolean $blnForce If true, existing objects will be overridden
		*/
		public static function importService($strClass, $strKey=null, $blnForce=false){
			$strKey = !is_null($strKey) ? $strKey : $strClass;
			if($blnForce || !isset(self::$arrObjects[$strKey])){
				//ceck if singleton pattern is used
				self::$arrObjects[$strKey] = in_array('getInstance', get_class_methods($strClass)) ? call_user_func(array($strClass, 'getInstance')) : new $strClass();
			}
		}

		/**
		*Get an imported service by its name
		*
		*@param string  $strKey The name
		*
		*/
		public static function getServiceClassInstance($strKey){
			if(isset(self::$arrObjects[$strKey])){
				return self::$arrObjects[$strKey];
			}
			return null;
		}

	} (new system());
?>
