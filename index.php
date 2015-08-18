<?php

namespace Parse;

/*
 * The usual Parse SDK setup
 */

use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseClient;
use ParseSchema\ParseSchema;

require './autoload.php'; //if you didn't get the SDK using composer thn it should be require 'autoload.php';
require './config.php'; // This is where I stored the keys used in initialize line 20
require './ParseSchema.php';

$schema = new ParseSchema(); // This is the class that would geerate the UML
$chosenObjects = array(); // The array where we will put the classes we're going to add to the UML

ParseClient::initialize($app_id, $rest_key, $master_key);
try {
    $userQuery = ParseUser::query();
    $userQuery->exists("objectId"); // This is not efficiant but Parse lacks random access to objects 
    $users = $userQuery->find();

    /*
     * The Key in $chosenObjects should be the name you want to display in the UML
     */
    $chosenObjects['_User'] = $users[0];

    /*
     * Custum class (Temperature for demo)
     * You can add as many as you want
     */
    $custumQuery = new ParseQuery("Temperature");
    $custumQuery->exists("objectId"); // Same as line 23
    $custumObjects = $custumQuery->find();

    /*
     * Add an array of custum objects to be inclused in the UML
     */
    $chosenObjects['Temperature'] = $custumObjects; // We can pass an array of objects 

    /*
     * Pass the array $chosenObjects to getUML method
     * @return : String (Null if error)
     */
    $UML = $schema->getUML($chosenObjects);

    if ($UML) {
        /*
         * Get the client to download the txt file
         */
        header('Content-Disposition: attachment; filename="uml-' . date('m-d-Y_hia') . '.txt"');
        header('Content-Type: application/force-download');
        header('Content-Length: ' . strlen($UML));
        header('Connection: close');
        echo ($UML);
    } else {
        die("Please Check your array for errors!");
    }
} catch (ParseException $exc) {
    die("EXCEPTION " . $exc->getMessage());
}