<?php

namespace Calender;

use \PDO;

class Event {

    public function __construct()
    {
      $pdo = new PDO("sqlite:../database/db.sql", null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ]);

     return $pdo;
    }
}