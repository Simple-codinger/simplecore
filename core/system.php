<?php
/*Author Gierisch Vincent, PersNr.: 4974, Tel.: 2350
Thanks to Domink Ganic for supporting me*/
	namespace simplecore\core;

	class system{
		private static $arrObjects = array();

		public function __construct(){
			spl_autoload_register(array($this, '_coreLoader'));
			$this->_defineClasses();
		}

		private function _defineClasses(){
			//no globals
			//work with singleton and import function
			self::import("simplecore\\core\\session", "session");

			//get current user
			self::import("simplecore\\core\\module\\currentUser", "cUser");

			self::import("simplecore\\core\\db\\connection", "database");
			self::getClassInstance("database")->connect(\simplecore\core\config::getConfiguration("databaseConfig"), new \simplecore\core\db\driver\mysqli\driver());
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
		 * Import a library and make it accessible by its name or an optional key
		 *
		 * @param string  $strClass The class name
		 * @param string  $strKey   An optional key to store the object under
		 * @param boolean $blnForce If true, existing objects will be overridden
		*/
		public static function import($strClass, $strKey=null, $blnForce=false){
			$strKey = !is_null($strKey) ? $strKey : $strClass;
			if($blnForce || !isset(self::$arrObjects[$strKey])){
				//ceck if singleton pattern is used
				self::$arrObjects[$strKey] = in_array('getInstance', get_class_methods($strClass)) ? call_user_func(array($strClass, 'getInstance')) : new $strClass();
			}
		}

		public static function getClassInstance($strKey){
			if(isset(self::$arrObjects[$strKey])){
				return self::$arrObjects[$strKey];
			}
			return null;
		}

		//source this shit out of here

		public function getUser(){
			return unserialize($_SESSION[\simplecore\core\config::getConfiguration("SessionNameUser")]);
		}

	} (new system());
?>
