<?php
$roundtrip = $_GET['roundtrip'];
$to = $_GET['to'];
$from = $_GET['from'];
$ddate = $_GET['ddate'];
$rdate = $_GET['rdate'];

if ($roundtrip == 'true'){
	$python = shell_exec("/home/toptripplanner/python3/bin/python3.5 peoria.py 'RT' $from $ddate $rdate");
}else{
	$python = shell_exec("/home/toptripplanner/python3/bin/python3.5 peoria.py 'OW' $from $ddate $rdate");
}

echo $python;
?>
