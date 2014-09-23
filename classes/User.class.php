<?php
class User {
  public $name;
  public $last_name;
  public $cardnum;
  public $pin;
  public $groups;
  public $type;

  function __construct ($name, $cardnum, $pin, $grps, $type) {
    $this->name = $name;

    $this->last_name = explode( ',', $this->name )[0];

    $this->cardnum = $cardnum;
    $this->pin = $pin;
    $this->groups = $grps;

    $this->type = $type;
  }
}
?>