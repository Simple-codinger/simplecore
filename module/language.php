<?php
	/*Author Gierisch Vincent/
	/* http://www.uebersetzungen.in/sprachkuerzel-nach-iso_639-1/ */
	namespace simplecore\module;

	class language{
		public $xmlFile;
		private $_defaultLanguage;
		private $_cookieName;

		public function __construct(){
			/*if DefaultLanguage is not set then get BrowserLanguage*/
			$this->_defaultLanguage = coreConfig::getConfiguration("languageDefault") == "" ? $this->_getBrowserLang() : coreConfig::getConfiguration("languageDefault");
			$this->_cookieName = coreConfig::getConfiguration("languageCookie");
			$this->_getCookieLang();
			$this->xmlFile = simplexml_load_file(coreConfig::getConfiguration("languageFile"));
			if(!$this->xmlFile){die("Could not read xml file");};
		}

		private function _getBrowserLang(){
			return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}

		private function _getCookieLang(){
			if(coreCookie::existsCookie($this->_cookieName)){
				$this->_defaultLanguage = $_COOKIE[$this->_cookieName];
			}
		}

		public function getString($key, $lan="conf"){
			if($lan=="conf"){$lan=$this->_defaultLanguage;}
			foreach($this->xmlFile->xpath('language[@lan="'.$lan.'"]/lanString[@key="'.$key.'"]') as $lanString){
				return (string)$lanString;
			}
		}

		public function getLanguages(){
			$languageArray = array();
			for($i = 0; $i < count($this->xmlFile->language); $i++)
			{
				$lan = (string)($this->xmlFile->language[$i]->attributes()->lan);
				$languageArray[$lan] =  (string)($this->xmlFile->language[$i]->attributes()->name);
			}
			return $languageArray;
		}
	}
?>
