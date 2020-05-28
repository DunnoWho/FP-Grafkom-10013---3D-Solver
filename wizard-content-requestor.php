<?php
require "global.php";

$data = json_decode($_POST["pageContent"], true);
$temp = array(
    "stepHeader" => array(),
    "stepPanel" => array()
);
for ($i = 0; $i < count($data); $i++) {
    $d = $data[$i];
    $d["first"] = $i == 0;
    $temp["stepHeader"][] = loadView("views/wizard_steps.php", $d);
    $temp["stepPanel"][] = loadView("views/" . $d["url"] . ".php", $d);
}
$temp["stepScript"] = file_get_contents("js/script.js");
$data = $temp;
echo json_encode($data);