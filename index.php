<?php
$xml = simplexml_load_file("src/data.xml") or die("Error: Cannot create object");
require_once("./src/functions.php");
readXmlData($xml);

//require_once("./src/functions.php");
task2($multyarray);

task3();
task4();
