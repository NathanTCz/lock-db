<?php
require_once 'classes/User.class.php';

class Student extends User {
  public $emplid;
  public $year;
  public $major;
  public $classes;

  function __construct ($name, $eid, $year, $maj, $cls, $type = '/srv/http/lock-db/flatdb/student.pins') {
    $name = preg_replace( '/:(0|1)/', '', $name);
    $name = strtolower($name);

    $fname = explode( ',', $name )[1];
    $this->first_name = ucwords($fname);

    $lname = explode( ',', $name )[0];
    $this->last_name = ucfirst($lname);

    $this->name = $this->last_name . ', ' . $this->first_name;

    $this->emplid = $eid;
    $this->year = $year;
    $this->major = $maj;
    $this->classes = $cls;
    $this->type = $type;
  }
}
?>