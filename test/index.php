<?php
  namespace simplecore;

  require_once("../core/system.php");
  //AccessControl test

  if(system::getService("AC")->hasAccess("testEnviroment")){
    echo "You have access";
  }else{
    echo "You habe no access";
  }

 ?>
