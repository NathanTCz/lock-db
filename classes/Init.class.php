<?php
require_once 'core/config.php';
require_once 'classes/User.class.php';
require_once 'classes/Student.class.php';

class Init {
  public $lock_roster;
  public $student_roster;
  public $studroster_filename;
  public $pin_files = array();
  public $types = array();

  function __construct ($r, $pf) {
    $this->studroster_filename = $r;
    $this->pin_files = $pf;
  }

  function parse_students () {
    $handle = fopen($this->studroster_filename, "r");

    if ($handle) {
      $cnt = 0;

      while ( ($buffer = fgets($handle, 1024)) !== false ) {
          $buffer = explode("|", $buffer);
          $new_stud = new Student (
            $buffer[0],
            $buffer[1],
            $buffer[2],
            $buffer[3],
            $buffer[4]
          );

          $index = preg_replace('/\s/', '', $new_stud->last_name . $new_stud->first_name . $cnt++);
          $this->student_roster[$index] = $new_stud;
      }
      if (!feof($handle)) {
          echo "Error: unexpected fgets() fail\n";
      }
      fclose($handle);
    }
  }

  function parse_conf($conf_file) {
    $handle = fopen($conf_file, 'r');
    $values = array();

    if ($handle) {
      while ( ($buffer = fgets($handle, 1024)) !== false ) {
        if ($buffer[0] === '#') continue;

        $values[] = $buffer;
      }
    }
  }

  function parse_pin_files () {
    /*
     * Lines in these files *should* be formatted as such
     *     NAME           CARD #       PIN       GROUPS
     * Last, First:5894 3710 0123 4567:0714:group1, ... , groupN
     *
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

        while ( ($buffer = fgets($handle, 1024)) !== false ) {
          if ($buffer[0] === '#') continue;

          $buffer = str_replace("\n", '', $buffer);
          $buffer = explode(":", $buffer);
          $new_user = new User (
            $buffer[0],
            $buffer[1],
            $buffer[2],
            $buffer[3],
            $fname
          );

          /* The folowing is the index of the user in the whole roster. This
           * is what is used to find the person when using the search
           * function. So anything appended to the key here will be searchable
           * by prepending an * to the search term.
           */
          $index = preg_replace('/\s/', '',
            $new_user->last_name .
            $new_user->first_name .
            $new_user->cardnum .
            $new_user->groups .
            $new_user->type
          );
          $this->lock_roster[$index] = $new_user;
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
      }
    }

    uksort($this->lock_roster, 'strcasecmp');
  }

  function parse_csv ($file, $type, $points, $action) {
    /*
     * Lines in these files *should* be formatted as such
     * LASTNAME,FIRSTNAME,CARDNUMBER,PIN
     *
     * values delmited by commas ','
    */

    global $PIN_FILE_PATH;
    global $OPERATOR;

    // input sanitation
    $points = preg_replace('/\s/', '', $points);

    $handle = fopen($file['tmp_name'], "r");

    if ($handle) {
      $conflicts = array();

      while ( ($buffer = fgets($handle, 1024)) !== false ) {
        $buffer = str_replace("\n", '', $buffer);
        $buffer = explode(",", $buffer);
        $new_user = new User (
          $buffer[0] . ', ' . $buffer[1],
          $buffer[2],
          $buffer[3],
          $points,
          $type
        );

        // search for duplicates
        $index = preg_replace('/\s/', '', $new_user->last_name . $new_user->first_name . $new_user->cardnum);

        $results = $this->search_lock_roster($index);

        if ( count($results) > 1 ) {
          $conflicts['dup'][] = $new_user;
          continue;
        }
        elseif ( count($results) == 1 ) {
          $key = key($results);

          $old_groups = explode(',', $this->lock_roster[$key]->groups);

          if ($action === 'add') {
            $new_groups = explode(',', $points);
            $new_groups = array_unique( array_merge($new_groups, $old_groups) );
            $new_groups = implode(',', $new_groups);
            $this->lock_roster[$key]->groups = $new_groups;
          }

          elseif ($action === 'remove') {
            $new_groups = explode(',', $points);
            foreach ($new_groups as $key_new => $new) {
              if ( in_array($new, $old_groups) ) {
                unset( $old_groups[$key_new] );
              }
            }
            $new_groups = implode(',', $old_groups);
            $this->lock_roster[$key]->groups = $new_groups;
          }
        }
        elseif ( count($results) == 0 ) {
          if ($action === 'add') {
            if ( $type === $PIN_FILE_PATH . 'student.pins' ) {
              $students = $this->search_student_roster($new_user->last_name . $new_user->first_name);

              if ( empty($students) )
                $conflicts['new'][] = $new_user;
              else {
                $index = preg_replace('/\s/', '', $new_user->last_name . $new_user->first_name . $new_user->cardnum);
                $this->lock_roster[$index] = $new_user;
              }
            }
            else {
              $index = preg_replace('/\s/', '', $new_user->last_name . $new_user->first_name . $new_user->cardnum);
              $this->lock_roster[$index] = $new_user;
            }
          }
          elseif ($action === 'remove')
            $conflicts['dne'][] = $new_user;
        }
      }
      if (!feof($handle)) {
          echo "Error: unexpected fgets() fail\n";
      }
      fclose($handle);
    }

    $this->flush_all_lock_roster();

    // Log Operator action
    $fname = $file['name'];
    $description = "Import [$fname]: [$action points] $points -- " . count($conflicts['new']) . " issues";
    $OPERATOR->log('IMPORT', $description);

    return $conflicts;
  }

  function search_lock_roster ($search) {
    if ( strlen($search) > 0 ) {
      $search = $search . '*';

      $array = $this->lock_roster;

      $search = str_replace( '\*', '.*?', preg_quote( $search, '/' ) );
      $result = preg_grep( '/^' . $search . '$/i', array_keys( $array ) );

      return array_intersect_key( $array, array_flip( $result ) );
    }
    return array();
  }

  function fuzzy_search_lockdb ($search) {
    if ( strlen($search) > 0 ) {

      $shortest = -1;

      foreach( $this->lock_roster as $key => $user ) {

        // calculate the distance between the input word,
        // and the current word
        $lev = levenshtein( strtolower($search), strtolower($user->last_name) );

        // check for an exact match
        if ($lev == 0) {

            // closest word is this one (exact match)
            $closest = array( $key => $user );
            $shortest = 0;

            // break out of the loop; we've found an exact match
            break;
        }

        // if this distance is less than the next found shortest
        // distance, OR if a next shortest word has not yet been found
        if ($lev <= $shortest || $shortest < 0) {
            // set the closest match, and shortest distance
            $closest[$key] = $user;
            $shortest = $lev;
        }
      }
      // just return top 3. other seems to be too ambiguous
      return array_reverse( array_slice($closest, -5, 5, true) );
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

  function fuzzy_search_students ($search) {
    $this->parse_students();
    if ( strlen($search) > 0 ) {

      $shortest = -1;

      foreach( $this->student_roster as $key => $user ) {

        // calculate the distance between the input word,
        // and the current word
        $lev = levenshtein( strtolower($search), strtolower($user->last_name) );

        // check for an exact match
        if ($lev == 0) {

            // closest word is this one (exact match)
            $closest = array( $key => $user );
            $shortest = 0;

            // break out of the loop; we've found an exact match
            break;
        }

        // if this distance is less than the next found shortest
        // distance, OR if a next shortest word has not yet been found
        if ($lev <= $shortest || $shortest < 0) {
            // set the closest match, and shortest distance
            $closest[$key] = $user;
            $shortest = $lev;
        }
      }
      // just return top 3. other seems to be too ambiguous
      return array_reverse( array_slice($closest, -5, 5, true) );
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

  function flush_all_lock_roster () {
    uksort($this->lock_roster, 'strcasecmp');

    $file_format = array();

    foreach ($this->lock_roster as $user) {
      $line = $user->name . ':' . $user->cardnum . ':' . $user->pin . ':' . $user->groups;

      $file_format[$user->type][] = $line . "\n";
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
