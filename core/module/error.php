<?php
	namespace trainMan\core\module;
	class error{
		private $mErrorArray = array("siteNotFound" => "Fehler. Die Seite wurde nicht gefunden.");
		private $mErrorText;
		private $mAlert = false;

		public function __construct($errorText, $alert=false){
			if(array_key_exists($errorText, $this->mErrorArray)){
				$this->mErrorText = $this->mErrorArray[$errorText];
			}else{
				throw new Exception("Fehler in der Fehlerausgabe??");
			}
			$this->mAlert = $alert;
		}

		public function show(){
			if($this->mAlert){
				return "<div class='alert alert-danger' role='alert'>".$this->mErrorText."</div>";
			}else{
				return $this->mErrorText;
			}
		}
	}
?>
