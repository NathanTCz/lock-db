<?php
// MAIN CONFIG FILE


/* List of IP addresses that are authorized to
 * use this software. This is instead of a login
 * system.
 */
$authorized_users = array(
  '128.186.120.147'
);

// Specify *.pins files here
$pin_files = array(
  'lock-db/flatdb/faculty.pins',
  'lock-db/flatdb/staff.pins',
  'lock-db/flatdb/student.pins',
  'lock-db/flatdb/guest.pins',
  'lock-db/flatdb/university.pins',
  'lock-db/flatdb/test.pins'
);

// Specify the student roster file here.
$stud_roster_file = 'lock-db/flatdb/roster.txt';
?>