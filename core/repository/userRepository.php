<?php
  namespace simplecore\core\repository;

  use simplecore\core\module\user as user;

  class userRepository{

    public static function getUserByUsername($username){
      $userArray = \simplecore\core\system::getClassInstance("database")->getConnection()->select("SELECT * FROM user WHERE username = :username;", array(':username' => $username));
      $user = null;
      if(!empty($userArray)){
        $userArray = $userArray[0];
        $user = new user();
        $user->setId($userArray['id']);
        $user->setUsername($userArray['username']);
        $user->setPassword($userArray['password']);
        $user->setFirstname($userArray['firstname']);
        $user->setLastname($userArray['lastname']);
      }
      return $user;
    }

  }
 ?>
