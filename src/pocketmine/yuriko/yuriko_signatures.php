<?php

$signatures = [];

if(!isset($_GET["sign"])) return;

$submittedSignature = $_GET["sign"];

$result = [
    "check" => in_array($submittedSignature, $signatures)
];

echo serialize($result);

?>