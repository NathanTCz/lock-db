<?php
require_once "classes/Student.class.php";

class Init {
  public $lock_roster;
  public $student_roster;
  public $studroster_filename;
  public $pin_files = array();

  function __construct ($r, $pf) {
    $this->studroster_filename = $r;
    $this->pin_files = $pf; 

    //$this->parse_students();
    $this->parse_pin_files();
  }

  function parse_students () {
    $handle = fopen($this->studroster_filename, "r");

    if ($handle) {
        while (($buffer = fgets($handle, 1024)) !== false) {
            $buffer = explode("|", $buffer);
            $new_stud = new Student (
              $buffer[0],
              $buffer[1],
              $buffer[2],
              $buffer[3],
              $buffer[4],
              $this->studroster_filename
            );

            $this->student_roster[$new_stud->last_name] = $new_stud;
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
    }
  }

  function parse_pin_files () {
    /*
     * Lines in these files *should* be formatted as such
     * Last, First:5894 3710 0123 4567:0714:group1,groupN,
     *     NAME           CARD #       PIN       GROUPS
     * values delmited by colons ':'
    */

    foreach ($this->pin_files as $fname) {
      $handle = fopen($fname, "r");

      if ($handle) {
          while (($buffer = fgets($handle, 1024)) !== false) {
            if ($buffer[0] === '#') continue;

            $buffer = explode(":", $buffer);
            $new_user = new User (
              $buffer[0],
              $buffer[1],
              $buffer[2],
              $buffer[3],
              $fname
            );

            $this->lock_roster[$new_user->last_name] = $new_user;
          }
          if (!feof($handle)) {
              echo "Error: unexpected fgets() fail\n";
          }
          fclose($handle);
      }
    }

    //sort($this->roster);
  }

  function search_lock_roster ($search) {
    $this->parse_pin_files();

    if ( strlen($search) > 0 ) {
      $search = $search . '*';

      $array = $this->lock_roster;

      $search = str_replace( '\*', '.*?', preg_quote( $search, '/' ) );
      $result = preg_grep( '/^' . $search . '$/i', array_keys( $array ) );

      return array_intersect_key( $array, array_flip( $result ) );
    }
    return array();
  }

}
?>