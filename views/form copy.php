<?php
$titik = array(
    'A', 'B', 'C',
    'D', 'E', 'F',
    'G', 'H', 'I',
    'J', 'K', 'L',
    'M', 'N', 'O',
    'P', 'Q', 'R', 'S',
    'T', 'U', 'V',
    'W', 'X', 'Y', 'Z'
);
$garis = array();
foreach ($titik as $i) {
    foreach ($titik as $j) {
        if ($i != $j) {
            $garis[] = $i . $j;
        }
    }
}
$bidang = array();
foreach ($titik as $i) {
    foreach ($garis as $j) {
        if (strpos($j, $i) === false) {
            $bidang[] = $i . $j;
        }
    }
}
foreach (array(
    "aib", "bjc", "ckd", "dla",
    "mvn", "nwo", "oxp", "pym",
    "eqf", "frg", "gsh", "hte",
    "ame", "eth", "hpd", "dla",
    "ivq", "qzs", "sxk", "kui",
    "bnf", "frg", "goc", "jcb"
) as $i) {
    $i = strtoupper($i);
    unset($garis[array_search("$i[0]$i[1]$i[2]", $bidang)]);
    unset($garis[array_search("$i[0]$i[2]$i[1]", $bidang)]);
    unset($garis[array_search("$i[1]$i[0]$i[2]", $bidang)]);
    unset($garis[array_search("$i[1]$i[2]$i[0]", $bidang)]);
    unset($garis[array_search("$i[2]$i[0]$i[1]", $bidang)]);
    unset($garis[array_search("$i[2]$i[1]$i[0]", $bidang)]);
}
foreach (array(
    "abcd", "ijkl", "mnop", "vwxy",
    "efgh", "qrst", "ahed", "mtpl",
    "iqsk", "vzxu", "bfgc", "nrqj",
    "adgf", "bche", "abdh", "dcfe",
    "adon", "bcpm", "mpgf", "nohe",
    "abop", "dcnm", "mngh", "efop"
) as $i) {
    $bidang[] = "$i[0]$i[1]$i[2]$i[3]";
    $bidang[] = "$i[1]$i[2]$i[3]$i[0]";
    $bidang[] = "$i[2]$i[3]$i[0]$i[1]";
    $bidang[] = "$i[3]$i[0]$i[1]$i[2]";
}
?>
<div class="panel">
    <header class="panel__header">
        <h2 class="panel__title"><?= $data["panelTitle"] ?></h2>
        <p class="panel__subheading"><?= $data["panelSubtitle"] ?></p>
    </header>

    <p>Soal:
        <select id="bentuk" name="bentuk">
            <option value="0">Kubus</option>
            <option value="1">Balok</option>
            <option value="2">Limas segi empat</option>
            <option value="3">Limas segitiga</option>
        </select>
    </p>
    <p class="hide" id="hide1"> Titik:
        <select name="titik1" id="titik1">
            <?php
            foreach ($titik as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <p>Soal:
        <select id="soal" name="soal">
            <option value="0">Jarak 2 titik</option>
            <option value="1">Jarak titik ke garis</option>
            <option value="2">Jarak titik ke bidang</option>
            <option value="3">Proyeksi titik ke bidang</option>
            <option value="4">Proyeksi garis ke bidang</option>
            <option value="5">Sudut antara garis dan garis</option>
            <option value="6">Sudut antara garis dan bidang</option>
            <option value="7">Sudut antara bidang dan bidang</option>
        </select>
    </p>
    <p class="hide" id="hide1"> Titik:
        <select name="titik1" id="titik1">
            <?php
            foreach ($titik as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <p class="hide" id="hide2"> Titik:
        <select name="titik2" id="titik2">
            <?php
            foreach ($titik as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <p class="hide" id="hide3"> Garis:
        <select name="garis1" id="garis1">
            <?php
            foreach ($garis as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <p class="hide" id="hide4"> Garis:
        <select name="garis2" id="garis2">
            <?php
            foreach ($garis as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <p class="hide" id="hide5"> Garis:
        <select name="bidang1" id="bidang1">
            <?php
            foreach ($bidang as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <p class="hide" id="hide6"> Garis:
        <select name="bidang2" id="bidang2">
            <?php
            foreach ($bidang as $i) {
            ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            }
            ?>
        </select>
    </p>
    <button class="button" id="submit">Submit</button>
    <script>
        $(document).ready(function() {
            const soal = $("#soal");
            const titik1 = $("#titik1");
            const titik2 = $("#titik2");
            const garis1 = $("#garis1");
            const garis2 = $("#garis2");
            const bidang1 = $("#bidang1");
            const bidang2 = $("#bidang2");
            soal.select2();
            titik1.select2();
            titik2.select2();
            garis1.select2();
            garis2.select2();
            bidang1.select2();
            bidang2.select2();
            $(".hide").hide();
            $("#hide1").show();
            $("#hide2").show();
            soal.on("change", function() {
                $(".hide").hide();
                const temp = soal.val();
                if (temp == 0) {
                    $("#hide1").show();
                    $("#hide2").show();
                } else if (temp == 1) {
                    $("#hide1").show();
                    $("#hide3").show();
                } else if (temp == 2) {
                    $("#hide1").show();
                    $("#hide5").show();
                } else if (temp == 3) {
                    $("#hide1").show();
                    $("#hide5").show();
                } else if (temp == 4) {
                    $("#hide3").show();
                    $("#hide5").show();
                } else if (temp == 5) {
                    $("#hide3").show();
                    $("#hide4").show();
                } else if (temp == 6) {
                    $("#hide3").show();
                    $("#hide5").show();
                } else if (temp == 7) {
                    $("#hide5").show();
                    $("#hide6").show();
                }
            });
            $("#submit").click(function() {
                let action = "";
                const val = soal.val();
                const input = {};
                switch (val) {
                    case "0":
                        action = "/jtt.php";
                        input["in1"] = titik1.val();
                        input["in2"] = titik2.val();
                        break;
                    case "1":
                        action = "/jtg.php";
                        input["in1"] = titik1.val();
                        input["in2"] = garis1.val();
                        break;
                    case "2":
                        action = "/jtb.php";
                        input["in1"] = titik1.val();
                        input["in2"] = bidang1.val();
                        break;
                    case "3":
                        action = "/ptb.php";
                        input["in1"] = titik1.val();
                        input["in2"] = bidang1.val();
                        break;
                    case "4":
                        action = "/pgb.php";
                        input["in1"] = garis1.val();
                        input["in2"] = bidang1.val();
                        break;
                    case "5":
                        action = "/sgg.php";
                        input["in1"] = garis1.val();
                        input["in2"] = garis2.val();
                        break;
                    case "6":
                        action = "/sgb.php";
                        input["in1"] = garis1.val();
                        input["in2"] = bidang1.val();
                        break;
                    case "7":
                        action = "/sbb.php";
                        input["in1"] = bidang1.val();
                        input["in2"] = bidang2.val();
                        break;
                }
                const form = $('<form />', {
                    action: action,
                    method: "POST",
                    style: 'display: none;'
                });
                if (typeof input !== 'undefined' && input !== null && input !== {}) {
                    $.each(input, function(name, value) {
                        $('<input />', {
                            type: 'hidden',
                            name: name,
                            value: value
                        }).appendTo(form);
                    });
                }
                form.appendTo('body').submit();
            })
        });
    </script>
</div>