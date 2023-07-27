<?php
// require_once("../../data/lab10/mykeys.inc.php");
require_once("./data/lab10/mykeys.inc.php");

require_once("hitcounter.php");

$Counter = new HitCounter($host, $user, $pswd, $dbnm, $table);
$Counter->startOver();
$Counter->closeConnection();
