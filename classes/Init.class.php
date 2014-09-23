<?php
require_once "classes/Student.class.php";

class Init {
  public $lock_roster;
  public $student_roster;
  public $studroster_filename;
  public $pin_files = array();
  public $types = array();

  function __construct ($r, $pf) {
    $this->studroster_filename = $r;
    $this->pin_files = $pf; 

    //$this->parse_students();
    //$this->parse_pin_files();
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
              $buffer[4]
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
      // add to types
      // strip off '.pins'
      $type = explode( '.', $fname)[0];
      // spit up path name by '/'
      $type = explode( '/', $type );
      // take last element;
      $type = array_pop( $type );
      $this->types[$fname] = $type;

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

    uksort($this->lock_roster, 'strcasecmp');
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

  function search_student_roster ($search) {
    $this->parse_students();

    if ( strlen($search) > 0 ) {
      $search = $search . '*';

      $array = $this->student_roster;

      $search = str_replace( '\*', '.*?', preg_quote( $search, '/' ) );
      $result = preg_grep( '/^' . $search . '$/i', array_keys( $array ) );

      return array_intersect_key( $array, array_flip( $result ) );
    }
    return array();
  }

  function flush_lock_roster ($which) {
    uksort($this->lock_roster, 'strcasecmp');

    $file_format = array();

    foreach ($this->lock_roster as $user) {
      if ($user->type === $which) {
        $line = $user->name . ':' . $user->cardnum . ':' . $user->pin . ':' . $user->groups;

        $file_format[$user->type][] = $line . "\n";
      }
    }

    foreach ($file_format as $fname => $list) {
      $handle = fopen($fname, 'w');

      foreach ($list as $line) {
        fwrite($handle, $line);
      }
      fclose($handle);
    }
  }

}
?>