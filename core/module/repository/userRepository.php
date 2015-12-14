<?php
  namespace trainMan\core\module\repository;

  use trainMan\core\module\user as user;
  use trainMan\core\db\sql as sql;

  class userRepository{

    public static function getAllUser(){
      $users = array();
      foreach (sql::getAllUser() as $userArray) {
        array_push($users, new user($userArray));
      }
      return $users;
    }

  }
 ?>
