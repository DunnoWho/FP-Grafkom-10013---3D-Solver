<?php
if(!isset($_GET["in1"]) || !isset($_GET["in2"]) || !isset($_GET["shape"]) || !isset($_GET["l"]) || !isset($_GET["w"]) || !isset($_GET["h"])){
    die("Data input tidak cukup!");
}

require "global.php";

$soal = "Diketahui %s dengan %s. Tentukan sudut yang dibentuk antara garis %s dan bidang %s!";
$soalSubtitle = "Sudut antara garis dan bidang";

require "input_parse.php";

$temp["pageScript"] = loadView("js/page_scripts/sgb.php", $data);
$data = $temp;
require("views/_layout.php");