<?php
	include "./vendor/autoload.php";
	include "./config.php";
?>

<h1>Test Amp</h1>
<a href="https://amphp.org/">https://amphp.org/</a>
<br><br>

<?php
putenv('AMP_PHP_BINARY=/usr/bin/php'); // compatibilité PHP-FPM; marche pas :/
$apb = getenv('AMP_PHP_BINARY');
echo "AMP_PHP_BINARY: [$apb]<br>";

use Amp\Promise;
use function Amp\ParallelFunctions\parallelMap;

$resultats = [];

$tempsAvant = time();


$values = Promise\wait(parallelMap(
		[[1, 3], [2, 4], [3, 3], [4, 1]],
		function ($conf) use ($testServiceUrl, $tempsAvant, &$resultats) {

			$url = $testServiceUrl . '?ord=' . $conf[0] . '&att=' . $conf[1];
			$res = file_get_contents($url);
			$tempsChelou = time();
			$duree = $tempsChelou - $tempsAvant;
			echo "J'écris des trucs dans le corbaque (temps passé: $duree sec)<br>";
			array_push($resultats, $res);
}));


$tempsApres= time();
$dureeA = $tempsApres - $tempsAvant;
echo "J'écris des machins après le wait (temps passé: $dureeA sec.)<br>";

// y a tout qu'est bon :)
echo "<pre>"; var_dump($resultats); echo "</pre>";
