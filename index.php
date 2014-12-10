<?php

include 'vendor/autoload.php';

use EventManager\EventManager;
use EventManager\Response\ResultIterator;

$em = new EventManager();

$em->attach('hello', function($name) {
    return "$name 100";
});

$list = $em->attach('hello', function($name) {
    return "$name 10";
}, 5);

$list = $em->attach('hello', function($name) {
    return "$name 10";
}, 5);

$ll = $em->attach('hello', function($name) {
    return 'aafs';
}, 4);


$em->detach($list);

$results = $em->trigger('hello', array('mahad'));

foreach ( $results as $r ) {
	echo PHP_EOL;
	echo $r->getResult();
}

echo PHP_EOL;


foreach ( new ResultIterator($results->getCommandResult($ll)) as $r ) {
	echo PHP_EOL;
	echo $r;
}

