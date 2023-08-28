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
    $nbWeeks = (int)$end->format("W") - (int)$start->format("W");
    if($nbWeeks < 0){
      $nbWeeks = (int)$end->format("W");
    }
    return $nbWeeks + 1;
  }
}