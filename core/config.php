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
  '192.168.26.110',   // presentation machine (LOV016 Machine)
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


/* List of default groups. These groups represent the access
 * point groups for lock configuration.
 */
$GROUPS = array(
  'all',
  'systems',
  'faculty',
  'staff',
  'class',
  'major',
  'grad',
  'ta',
  'labmon',
  'sait',
  'acm',
  'lov267off',
  'custodian',
  'maintenance',
  'security',
  'keyshop',
  'guest',
  'fsu-its'
);

/* List of default doors. These are the individual access points.*/
$DOORS = array(
  'lov010',
  'lov010a',
  //'lov016',
  'lov025',
  'lov025a',
  //'lov025b',
  'lov103',
  'lov104a',
  'lov105',
  'lov150',
  //'lov151',
  'lov151a',
  'lov153',
  'lov167',
  'lov170',
  'lov250',
  'lov253a',
  'lov253b',
  //'lov260',
  'lov267',
  'mch202',
);
?>