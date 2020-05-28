<?php

require "global.php";

$soal = "Diketahui %s dengan %s. Tentukan jarak titik %s ke titik %s!";
$soalSubtitle = "Jarak titik ke titik";

require "input_parse.php";

$data["pageScript"] = loadView("js/page_scripts/jtt.php", $data);
require("views/_layout.php");