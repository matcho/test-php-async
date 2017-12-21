<?php
	include "./vendor/autoload.php";
	include "./config.php";
?>

<h1>Test icicle (deprecated)</h1>
<a href="https://icicle.io/">https://icicle.io/</a>
<br><br>

<?php
use Icicle\Awaitable;
use Icicle\Coroutine\Coroutine;
use Icicle\Loop;

$generator = function () {
    try {
        // Sets $start to the value returned by microtime() after approx. 1 second.
        $start = (yield Awaitable\resolve(microtime(true))->delay(1));

        echo "Sleep time: ", microtime(true) - $start, "<br>";

        // Throws the exception from the rejected promise into the coroutine.
        yield Awaitable\reject(new Exception('Rejected promise<br>'));
    } catch (Exception $e) { // Catches promise rejection reason.
        echo "Caught exception: ", $e->getMessage(), "\n";
    }

    yield Awaitable\resolve('Coroutine completed<br>');
};

$coroutine = new Coroutine($generator());

$coroutine->done(function ($data) {
    echo $data, "\n";
});

echo "Coucou les amis<br>";

Loop\run();

echo "Il faut beau non ?<br>";

//Loop\stop();

echo "Ça roule ?<br>";
