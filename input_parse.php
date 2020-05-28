<?php
if(!isset($_GET["in1"]) || !isset($_GET["in2"]) || !isset($_GET["shape"]) || !isset($_GET["l"]) || !isset($_GET["w"]) || !isset($_GET["h"])){
    die("Data input tidak cukup!");
}

if($_GET["in1"] == "" || $_GET["in2"] == "" || $_GET["shape"] == "" || $_GET["l"] == "" || $_GET["w"] == "" || $_GET["h"] == ""){
    die("Data input tidak boleh ada yang kosong!");
}

$data = $_GET;
$shape = "";
$size = "";

if ($data["shape"] == 0) {
    if ($data["w"] == $data["h"] && $data["w"] == $data["l"]) {
        $shape = "kubus";
        $size = "panjang rusuk " . $data["l"] . " cm";
        $data["mainGeom"] = "new MyBox(mainPointMaterial, mainLineMaterial)";
        $data["drawL"] = 1;
        $data["drawW"] = 1;
        $data["drawH"] = 1;
    } else {
        $shape = "balok";
        $size = "panjang " . $data["l"] . " cm, lebar " . $data["w"] . " cm, dan tinggi " . $data["h"] . " cm";
        $data["drawL"] = $data["l"] / 6;
        $data["drawW"] = $data["w"] / 6;
        $data["drawH"] = $data["h"] / 6;
        $data["mainGeom"] = "new MyBox(mainPointMaterial, mainLineMaterial, ".$data["drawL"].", ".$data["drawW"].", ".$data["drawH"].")";
    }
    $shape .= " ABCD.EFGH";
} else if ($data["shape"] == 1) {
    $shape = "limas segiempat T.ABCD";
    $size = "panjang " . $data["l"] . " cm, lebar " . $data["w"] . " cm, dan tinggi " . $data["h"] . " cm";
    $data["drawL"] = $data["l"] / 6;
    $data["drawW"] = $data["w"] / 6;
    $data["drawH"] = $data["h"] / 6;
    $data["mainGeom"] = "new MyPyramid(mainPointMaterial, mainLineMaterial, ".$data["drawL"].", ".$data["drawW"].", ".$data["drawH"].")";
} else {
    die("Bentuk tidak dikenali!");
}

$soal = sprintf($soal, $shape, $size, $data["in1"], $data["in2"]);

$data["soal"] = array(
    "url" => "panel_content",
    "icon" => "fa-question",
    "panelTitle" => "Soal",
    "panelSubtitle" => $soalSubtitle,
    "panelContent" => array($soal)
);