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
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);

     return $this->pdo = $pdo;
    }

    private function getAllEvents(DateTime $start, DateTime $end): array
    {
      $start = $start->getTimestamp();
      $end = $end->getTimestamp();
      $query = $this->pdo->query("SELECT * FROM events WHERE start BETWEEN $start AND $end ORDER BY start ASC");
      return $query->fetchAll();
    }

    public function create(array $datas)
    {
      $query = "INSERT INTO events(title, description, start, end) VALUES(?, ?, ?, ?)";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        $datas["title"],
        $datas["description"],
        (new \DateTime($datas["start_date"] . " " . $datas["start_time"]))->getTimestamp(),
        (new \DateTime($datas["start_date"] . " " . $datas["end_time"]))->getTimestamp(),
      ]);
    }

    public function find(int $id): array|bool
    {
      $event = [];
      $statement = $this->pdo->prepare("SELECT * FROM events WHERE id = ?");
      $statement->execute([$id]);
      $result = $statement->fetch();
      if(!empty($result)){
        $event["title"] = $result["title"];
        $event["description"] = $result["description"];
        $event["start_date"] = date("Y-m-d", $result["start"]);
        $event["start_time"] = date("H:i", $result["start"]);
        $event["end_time"] = date("H:i", $result["end"]);
      } 

      return $event;
    }

    public function getAllEventsByDate(DateTime $start, DateTime $end): array
    {
      $events = [];
      $allEvents = $this->getAllEvents($start, $end);
      foreach($allEvents as $event){
        $dateStart = date("Y-m-d", $event["start"]);

        if(!isset($events[$dateStart])){
          $events[$dateStart] = [$event];
        }else{
          $events[$dateStart][] = $event;
        }
      }

      return $events;
    }
}