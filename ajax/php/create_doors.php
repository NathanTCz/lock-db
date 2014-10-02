<?php
function shell_exec_wstderr($cmd, &$stdout=null, &$stderr=null) {
    $proc = proc_open($cmd,[
        1 => ['pipe','w'],
        2 => ['pipe','w'],
    ],$pipes);
    $stdout = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[2]);
    return proc_close($proc);
}

chdir('../../');
require_once 'core/init.php';

$DATA->parse_pin_files();

if ( isset($_POST['pin_files']) ) {
  $files = implode( ' ', $_POST['pin_files'] );
  chdir('lock-db/flatdb/');
  $return = shell_exec_wstderr("/usr/bin/perl create-doors.pl $files", $std_out, $std_err);

  if ( $return == 0 ) {
    $std_out = explode('W', $std_out);
    unset($std_out[0]);
    foreach ($std_out as $message) {
      echo 'W' . $message . '<br/>';
    }

    echo '<br/><br/><b>Lock file creation complete</b>';
  }
  else {
    echo '<b>Lock file creation failed.<b><br/>';
    echo $std_err;
  }
}
else {
?>

<span>Choose which pin files to sync:</span>
<div class="choose_pin_files">
  <form id="pin_files_form">
    <?php
    foreach ($DATA->types as $fname => $type) {
    ?>
    <input class="checks" type="checkbox" name="pin_files[]" value="<?php echo $fname;?>">
    <?php echo $fname;?>
    <br/><br/>
    <?php
    }
    ?>
  </form>
</div>
<input id="check_all" type="checkbox">Check All<br/><br/>
<button id="sync">Create Lock Files</span>
<?php
}
?>