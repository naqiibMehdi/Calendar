<?php

namespace Calendar;

class Validator{

  private $errors = [];
  private $datas = [];

  public function validates(array $datas): array
  {
    $this->datas = $datas;
    $this->validate("title", "length", 3);
    $this->validate("start_date", "checkDate");
    $this->validate("start_time", "logicTime", "end_time");

    return $this->errors;
  
  }

  public function validate(string $field, string $method, mixed ...$params): void
  {
    if(!isset($this->datas[$field])){
      $this->errors[$field] = "le champ $field n'est pas défini";
    }else{
      call_user_func([$this, $method], $field, ...$params);
    }
  }

  public function length(string $field, int $size): bool
  {
    if(mb_strlen($this->datas[$field]) < $size){
      $this->errors[$field] = "Le titre doit être supérieur ou égale à $size caractères";
      return false;
    }
    return true; 
  }

  public function checkDate(string $field): bool
  {
    if(!preg_match("#^[\d]{4}(-[\d]{2}){2}$#", $this->datas[$field])){
      $this->errors[$field] = "La date n'est pas au bon format";
      return false;
    } 
    return true;
  }

  public function checkTime(string $field): bool
  {
    if(!preg_match("#^[\d]{2}:[\d]{2}$#", $this->datas[$field])){
      $this->errors[$field] = "Le temps n'est pas au bon format";
      return false;
    } 
    return true; 
  }

  public function logicTime($startTime, $endTime): bool
  {
    if($this->checkTime($startTime) && $this->checkTime($endTime)){
      $start = \DateTime::createFromFormat("H:i", $this->datas[$startTime]);
      $end = \DateTime::createFromFormat("H:i", $this->datas[$endTime]);

      if($start->getTimestamp() > $end->getTimestamp()){
        $this->errors[$startTime] = "Le temps du début doit être inférieur au temps de fin";
        return false;
      }
      return true;
    }
    return false;
  }
}