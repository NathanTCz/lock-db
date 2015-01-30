<?php
// MAIN CONFIGURATION FILE

// Current Version Number
$CURR_VERSION = '1.2.0';


/* Set the Default Timezone */
date_default_timezone_set('America/New_York');

/* List of IP addresses that are authorized to
 * use this software. This is instead of a login
 * system.
 */
$AUTH_USERS = array(
  '127.0.0.1',
  '128.186.120.147',  // cazell.cs.fsu.edu
  '128.186.120.76',   // whissel.cs.fsu.edu
  '128.186.120.51',   // Rezowanul Haque (munroe.cs.fsu.edu)
  '128.186.120.229',  // deleon.cs.fsu.edu
  '128.186.120.107',  // Todd Ryks (stephens.cs.fsu.edu)
  '128.186.120.44'    // castelli.cs.fsu.edu
);


/* Active directory group name that users should be a
 * part of in order to obtain access to this application.
 */
$AUTH_GROUP = 'CS-System';


/* The absolute path to the directory containing
 * the pin files here.
 */
$PIN_FILE_PATH = '/usr/share/webapps/lock-db/flatdb/';

/* The absolute path to the PDA sync directory. This
 * is where the door files will be copied to after
 * generation.
*/
$PDA_PATH = '/home/ncaz/PDAFiles/locks/';

/* The user that owns the PDAFiles directory*/
$PDA_USER = 'ncaz';

// Specify *.pins files here
$PIN_FILES = array(
  $PIN_FILE_PATH . 'faculty.pins',
  $PIN_FILE_PATH . 'staff.pins',
  $PIN_FILE_PATH . 'student.pins',
  $PIN_FILE_PATH . 'guest.pins',
  $PIN_FILE_PATH . 'university.pins'
);

// Specify the student roster file here.
$STUD_RSTR_FILE = $PIN_FILE_PATH . 'roster.txt';


/* Absolute path to Operator log file. */
$OP_LOGFILE = '/var/log/lockdb.log';

/* Absolute path to the files containing Access
 * Points and Access Groups.
 */
$ACCESS_POINTS_FILE = '/usr/share/webapps/lock-db/flatdb/config/access_points.conf';
$ACCESS_GROUPS_FILE = '/usr/share/webapps/lock-db/flatdb/config/access_groups.conf';
?>
