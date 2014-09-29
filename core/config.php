<?php
// MAIN CONFIGURATION FILE


/* List of IP addresses that are authorized to
 * use this software. This is instead of a login
 * system.
 */
$AUTH_USERS = array(
  '128.186.120.147',
  '128.186.120.76'
);

// Specify *.pins files here
$PIN_FILES = array(
  'lock-db/flatdb/faculty.pins',
  'lock-db/flatdb/staff.pins',
  'lock-db/flatdb/student.pins',
  'lock-db/flatdb/guest.pins',
  'lock-db/flatdb/university.pins',
  'lock-db/flatdb/test.pins'
);

// Specify the student roster file here.
$STUD_RSTR_FILE = 'lock-db/flatdb/roster.txt';


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