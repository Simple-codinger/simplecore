<?php
	namespace simplecore\core;
	class cookie{

		public static function existsCookie($mKey) {
			return (isset($_COOKIE[$mKey]));
		}

		public static function createCookie($mKey, $mValue, $mExpireDate, $mPath) {
				setcookie($mKey, $mValue, $mExpireDate, $mPath);
		}

		public static function unsetCookie($mKey){
			setcookie($mKey, time()-1);
		}
	}
?>
