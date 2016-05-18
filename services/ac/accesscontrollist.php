<?php
  namespace simplecore\services\ac;
  class accesscontrollist{
    private static $_instance = null;
    private $_aclOrigin = null;
    private $_aclNew = null;

    //Singleton
    public static function getInstance(){
      if(!self::$_instance){
        self::$_instance = new self();
      }
      return self::$_instance;
    }
  }
 ?>
