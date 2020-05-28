<?php
require "global.php";
$temp["pageScript"] = str_replace("\n", "", loadView("views/form.php", array()));
$temp["pageScript"] = loadView("js/page_scripts/index.php", $temp);
$data = $temp;
require("views/_layout.php");
