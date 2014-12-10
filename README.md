PHP Event Manager Library
=========================

This is an easy to use event manager library. Which you can utilize to create event driven application.

Installation:
=============
use composer to install the library, in your composer.json:

```json
{
    "require": {
        "mahadazad/event-manager": "dev-master"
    }
}
```

or run

`php composer.phar require "mahadazad/event-manager":"dev-master"`

How To Use?
===========

simply instansiate the EventManager object:

```php
use EventManager\EventManager;

$em = new EventManager();

// $em->attach(event_name, callable, priority);

$handler1 = $em->attach('say.hello', function () {
    return 'hello';
}, 10);

$handler2 = $em->attach('say.hello', function () {
    return 'hello!!!';
}, 200);

$handler3 = $em->attach('say.hello', function () {
    return 'heeellloooo';
}, 300);

// remove an existing handler
$em->detach($handler3);

// $em->trigger(eventname); returns \EventManager\Response\ResponseCollection
$response = $em->trigger('say.hello');

/*
print_r($response->toArray());
    outputs:
        array(
          0 => hello!!!
          1 => hello
        )
        
can be traversed:
foreach ($response as $r) {
    echo $r->toResult();
}

you can get response of particular handler:
$hander1Results = $response->getCommandResult($handler2); // returns \EventManager\Response\ResponseCollection
*/
```
