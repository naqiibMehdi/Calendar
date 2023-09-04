<?php

namespace Calendar;

class Month{

  public $days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

  private $month;
  private $year;
  private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];

  public function __construct(?int $month = null, ?int $year = null)
  {
    if($month === null){
      $month = (int)date("m");
    }

    if($year === null){
      $year = (int)date("Y");
    }

    if($month < 1 || $month > 12){
      throw new Exception("le mois $month n'est pas compris dans le calendrier");
    }

    $this->month = $month;
    $this->year = $year;
  }

  public function toString(): string
  {
    return $this->months[$this->month - 1] . " " . $this->year;
  }

  public function getStartDay(): \DateTime
  {
    return new \DateTime("{$this->year}-{$this->month}-01");
  }

  public function getWeeks(): int
  {
    $start = $this->getStartDay();
    $end = (clone $start)->modify("+1 month -1 day");
    
    if($end->format("W") === "01"){
      $end = $end->modify("-7 days");
      $nbWeeks = ((int)$end->format("W") - (int)$start->format("W")) + 2;
    }else{
      $nbWeeks = ((int)$end->format("W") - (int)$start->format("W")) + 1;
    }
    
    if($nbWeeks < 0){
      $nbWeeks = (int)$end->format("W");
    }
    return $nbWeeks;
  }

  public function isNotSameDate(\DateTime $date): bool
  {
    return $this->getStartDay()->format("Y-m") !== $date->format("Y-m");
  }

  public function urlNextMonth(): string
  {
    $month = $this->month;
    $year = $this->year;

    $month++;

    if($month > 12){
      $month = 1;
      $year += 1;
    }
    return http_build_query(["month" => $month , "year" => $year]);
  }

  public function urlPreviousMonth(): string
  {
    $month = $this->month;
    $year = $this->year;

    $month--;

    if($month < 1){
      $month = 12;
      $year -= 1;
    }
    return http_build_query(["month" => $month , "year" => $year]);
  }
}