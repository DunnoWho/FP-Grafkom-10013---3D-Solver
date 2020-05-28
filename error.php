<?php
if (!isset($_GET["code"])) {
	header("Location: index.php");
}
$msg = array(
	"Nama titik / garis / bidang yang diinputkan tidak valid",
	"Bidang yang dimasukkan salah (keempat titik yang diinputkan tidak terletak pada 1 bidang yang sama)",
	"Untuk mengerjakan soal yang diinputkan diperlukan titik / garis / bidang yang tidak ada dalam daftar",
);
if (!is_numeric($_GET["code"]) || !isset($msg[intval($_GET["code"])])) {
	header("Location: index.php");
}
require "global.php";
$data = array();
$data["pageScript"] = loadView("js/page_scripts/error.php", array(
	"msg" => $msg[intval($_GET["code"])]
));
require("views/_layout.php");