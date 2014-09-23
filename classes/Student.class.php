<?php
require_once 'classes/User.class.php';

class Student extends User {
  public $emplid;
  public $year;
  public $major;
  public $classes;

  function __construct ($name, $eid, $year, $maj, $cls, $type) {
    $this->name = $name;
    $this->emplid = $eid;
    $this->year = $year;
    $this->major = $maj;
    $this->classes = $cls;
    $this->type = $type;
  }
}
?>