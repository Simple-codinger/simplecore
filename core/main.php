<?php
/*Author Gierisch Vincent, PersNr.: 4974, Tel.: 2350
Thanks to Domink Ganic for supporting me*/
	namespace trainMan\core;

	class coreMain{

		public function __construct(){
			spl_autoload_register(array($this, 'core_loader'));
			$this->_defineClasses();
		}

		private function _defineClasses(){
			global $cSession;
			$cSession = new \trainMan\core\session();

			global $dDb;
			$connectionParams = array(
				'dbname' => 'trainMan',
				'user' => 'root',
				'password' => '',
				'host' => 'localhost');
			$dDb = new \trainMan\core\db\connection($connectionParams, new \trainMan\core\db\driver\mysqli\driver());
		}

		private function core_loader($className){
       		$file = ltrim($className, '\\');  // Evntl. vorangegangenen Backslashes entfernen
	        $file_array = explode('\\', $file);
	        array_shift($file_array); // Root-Namespace entfernen

	        $file = implode(DIRECTORY_SEPARATOR, $file_array);
	        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . $file . '.php';
	        if(file_exists($path)) include $path; // Pfad der Klasse einbinden
	        else die($path . " could not load to the project!");
		}

		public function getUser(){
			return unserialize($_SESSION[\trainMan\core\config::getConfiguration("SessionNameUser")]);
		}

		public function mSubString($mKey, $mFrom, $mTo) {
			$mMaxLength = $mTo - $mFrom;
			if(strlen($mKey) > $mMaxLength) {
				$mSub = substr($mKey, $mFrom, $mTo);
				return $mSub.'...';
			} else
				return $mKey;
		}
	}
	global $cMain;
	$cMain = new coreMain();
	echo "TEST";
?>
