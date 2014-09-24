<?php
class User {
  public $name;
  public $first_name;
  public $last_name;
  public $cardnum;
  public $pin;
  public $groups;
  public $type;

  function __construct ($name, $cardnum, $pin, $grps, $type) {
    $this->name = $name;

    $fname = trim(explode( ',', $name )[1]);
    $this->first_name = $fname;

    $this->last_name = explode( ',', $this->name )[0];

    $this->cardnum = $cardnum;
    $this->pin = $pin;

    
    $this->groups = str_replace("\n", '', $grps);

    $this->type = $type;
  }
}
?>