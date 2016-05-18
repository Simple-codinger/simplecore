<?php
	namespace simplecore\module;

	class stringUtils{
		public static function substr($key, $from, $to, $ext="..."){
			$maxLength = $to - $from;
			if(strlen($key) > $maxLength) {
				$sub = substr($key, $from, $to);
				return $sub.$ext;
			} else
				return $key;
		}


		public static function getHexCodeFromColor($color){
			try{
				return ltrim($color, '#');
			}catch(Exception $e){
				echo "Cannot convert color!";
			}
		}
	}
?>
