<?php

// temps d'attente
$att = 5;
if (! empty($_REQUEST['att'])) {
	$att = $_REQUEST['att'];
}

// ordre d'appel
$ord = null;
if (! empty($_REQUEST['ord'])) {
	$ord = $_REQUEST['ord'];
}

sleep($att);

if ($ord !== null) {
	echo $ord;
} else {
	echo rand();
}
