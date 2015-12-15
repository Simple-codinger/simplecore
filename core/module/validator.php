<?php
	namespace simplecore\core\module;

	class validator{
		public static function checkHexCode($hex){
			return (ctype_xdigit($hex) && (strlen($hex) == 6 || strlen($hex) == 3));
		}
	}
?>
