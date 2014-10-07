<?php
require_once 'core/config.php';

class Operator {
  public $username;
  public $info;
  public $groups;
  public $client_ip;

  function __construct ($uname, $info, $grps, $ip) {
    $this->username = $uname;
    $this->info = $info;
    $this->groups = $grps;
    $this->client_ip = $ip;
  }

  function log ($action, $desc) {
    global $OP_LOGFILE;

    $handle = fopen($OP_LOGFILE, 'a');

    $line = '[' . date(DATE_RFC2822) . '] [:' .
      $action . '] [client ' . $this->client_ip .
      '] [user ' . $this->username . '] ' . $desc . "\n";

    fwrite($handle, $line);
    fclose($handle);
  }
}
?>