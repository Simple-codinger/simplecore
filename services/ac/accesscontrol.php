<?php
    namespace simpleinventory\simplecore\services\ac;

    class accesscontrol{

      private static $_instance = null;

      //Singleton
      public static function getInstance(){
        if(!self::$_instance){
          self::$_instance = new self();
        }
        return self::$_instance;
      }

    }
 ?>
