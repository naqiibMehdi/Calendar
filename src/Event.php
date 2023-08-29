<?php

namespace Calendar;

use \PDO;
use \DateTime;

class Event {

  private \PDO $pdo;

    public function __construct()
    {
      $pdo = new PDO("sqlite:../database/db.sqlite", null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ]);

     return $this->pdo = $pdo;
    }

    public function getAllEvents(DateTime $start, DateTime $end): ?array
    {
      $start = $start->getTimestamp();
      $end = $end->getTimestamp();
      $query = $this->pdo->query("SELECT * FROM events WHERE start BETWEEN $start AND $end");
      return $query->fetchAll();
    }
}