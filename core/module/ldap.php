<?php
/*Author Gierisch Vincent, PersNr.: 4974, Tel.: 2350
Thanks to Domink Ganic for supporting me*/
	namespace simplecore\core\module;
	use simplecore\core\config as config;
	class ldap{

		private $_credentials = array("username" => null, "password" => null);
		private $_ldapConnection;
		private $_appendedUserCredential;
		private $_serverPrefix;
		private $_server;
		private $_AuthentificationStatus;

		public function __construct($mUser, $mPass){
			$this->_serverPrefix=config::getConfiguration("ldapServerPrefix");
			$this->_server=config::getConfiguration("ldapServer");
			$this->_credentials["username"] = $mUser;
            $this->_credentials["password"] = $mPass;
			$this->_appendedUserCredential = $this->_serverPrefix.$this->_credentials["username"];
		}

		public function ldapLogin(){
			    $this->_ldapConnection = ldap_connect($this->_server) or exit ("Can not connect to Server");
                ldap_set_option($this->_ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($this->_ldapConnection, LDAP_OPT_REFERRALS, 0);

                if($this->_ldapConnection) {
                        $this->_authentificationStatus = @ldap_bind($this->_ldapConnection,
                        $this->_appendedUserCredential,
                        $this->_credentials["password"]);
                        ldap_close($this->_ldapConnection);
                }

                return $this->_authentificationStatus;
		}
	}
?>
