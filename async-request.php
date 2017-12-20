<?php
	include "./vendor/autoload.php";
	include "./config.php";
?>

<h1>Test async-request</h1>
<a href="https://packagist.org/packages/async-request/async-request">https://packagist.org/packages/async-request/async-request</a>
<br><br>

<?php
$urls = [
	$testServiceUrl . '?ord=1&att=3',
	$testServiceUrl . '?ord=2&att=4',
	$testServiceUrl . '?ord=3&att=3',
	$testServiceUrl . '?ord=4&att=1'
];

$resultats = [];

$tempsAvant = time();
$asyncRequest = new AsyncRequest\AsyncRequest();

foreach ($urls as $url) {
	$request = new AsyncRequest\Request($url);
	// "use" pour agir sur le scope parent depuis la closure, "&" pour avoir le droit de modifier
	$asyncRequest->enqueue($request, function(AsyncRequest\Response $response) use ($tempsAvant, &$resultats) {
		//echo "<pre>"; var_dump($response); echo "</pre>";
		$tempsChelou = time();
		$duree = $tempsChelou - $tempsAvant;
		echo "J'écris des trucs dans le corbaque (temps passé: $duree sec)<br>";
		array_push($resultats, $response->getBody());
	});
}

$tempsEntreDeux = time();
$dureeED = $tempsEntreDeux - $tempsAvant;
echo "J'écris des machins avant le run (temps passé: $dureeED sec.)<br>";

// ---- on passe en mode asynchrone
$asyncRequest->run();

// ---- on repasse en mode synchrone
$tempsApres= time();
$dureeA = $tempsApres - $tempsAvant;
echo "J'écris des machins après le run (temps passé: $dureeA sec.)<br>";

// y a tout qu'est bon :)
echo "<pre>"; var_dump($resultats); echo "</pre>";
