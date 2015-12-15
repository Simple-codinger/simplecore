<?php
  namespace simplecore\core\module\repository;

  use simplecore\core\module\user as user;
  use simplecore\core\db\sql as sql;

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
