<div class="panel">
    <header class="panel__header">
        <h2 class="panel__title"><?= $data["panelTitle"] ?></h2>
        <p class="panel__subheading"><?= $data["panelSubtitle"] ?></p>
    </header>
    <p>
        <table>
            <tr>
                <td>Bentuk</td>
                <td>:</td>
                <td><select id="bentuk" name="bentuk">
                        <option value="0">Kubus</option>
                        <option value="1">Balok</option>
                        <option value="2">Limas segi empat</option>
                    </select></td>
            </tr>
            <tr>
                <td>Panjang</td>
                <td>:</td>
                <td><input type="number" name="l" id="l" value="6" step="1" min="1"></td>
            </tr>
            <tr>
                <td>Lebar</td>
                <td>:</td>
                <td><input type="number" name="w" id="w" value="6" step="1" min="1"></td>
            </tr>
            <tr>
                <td>Tinggi</td>
                <td>:</td>
                <td><input type="number" name="h" id="h" value="6" step="1" min="1"></td>
            </tr>
        </table>
    </p>
    <p>
        Catatan: untuk kubus, yang diambil hanya nilai panjang (dianggap sebagai sisi kubus).
    </p>
    <p>
        <table>
            <tr>
                <td>Soal</td>
                <td>:</td>
                <td>
                    <select id="soal" name="soal">
                        <option value="0">Jarak 2 titik</option>
                        <option value="1">Jarak titik ke garis</option>
                        <option value="2">Jarak titik ke bidang</option>
                        <option value="3">Sudut antara garis dan garis</option>
                        <option value="4">Sudut antara garis dan bidang</option>
                        <option value="5">Sudut antara bidang dan bidang</option>
                    </select>
                </td>
            </tr>
            <tr class="hide" id="hide1">
                <td>Titik</td>
                <td>:</td>
                <td><input name="titik1" id="titik1"></td>
            </tr>
            <tr class="hide" id="hide2">
                <td>Titik</td>
                <td>:</td>
                <td><input name="titik2" id="titik2"></td>
            </tr>
            <tr class="hide" id="hide3">
                <td>Garis</td>
                <td>:</td>
                <td><input name="garis1" id="garis1"></td>
            </tr>
            <tr class="hide" id="hide4">
                <td>Garis</td>
                <td>:</td>
                <td><input name="garis2" id="garis2"></td>
            </tr>
            <tr class="hide" id="hide5">
                <td>Bidang</td>
                <td>:</td>
                <td><input name="bidang1" id="bidang1"></td>
            </tr>
            <tr class="hide" id="hide6">
                <td>Bidang</td>
                <td>:</td>
                <td><input name="bidang2" id="bidang2"></td>
            </tr>
        </table>
    </p>
    <p><button class="button" id="submit">Submit</button>
    </p>

    <script>
        $(document).ready(function() {
            const bentuk = $("#bentuk");
            const soal = $("#soal");
            const titik1 = $("#titik1");
            const titik2 = $("#titik2");
            const garis1 = $("#garis1");
            const garis2 = $("#garis2");
            const bidang1 = $("#bidang1");
            const bidang2 = $("#bidang2");
            bentuk.select2();
            soal.select2();
            $(".hide").hide();
            $("#hide1").show();
            $("#hide2").show();

            bentuk.on("change", function() {
                canvasUpdate();
            });
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
                    $("#hide3").show();
                    $("#hide4").show();
                } else if (temp == 4) {
                    $("#hide3").show();
                    $("#hide5").show();
                } else if (temp == 5) {
                    $("#hide5").show();
                    $("#hide6").show();
                }
            });
            $("#submit").on("click", function() {
                let action = "";
                let val = soal.val();
                const input = {};
                if (val == 0) {
                    action = "/jtt.php";
                    input["in1"] = titik1.val().toUpperCase();
                    input["in2"] = titik2.val().toUpperCase();
                } else if (val == 1) {
                    action = "/jtg.php";
                    input["in1"] = titik1.val().toUpperCase();
                    input["in2"] = garis1.val().toUpperCase();
                } else if (val == 2) {
                    action = "/jtb.php";
                    input["in1"] = titik1.val().toUpperCase();
                    input["in2"] = bidang1.val().toUpperCase();
                } else if (val == 3) {
                    action = "/sgg.php";
                    input["in1"] = garis1.val().toUpperCase();
                    input["in2"] = garis2.val().toUpperCase();
                } else if (val == 4) {
                    action = "/sgb.php";
                    input["in1"] = garis1.val().toUpperCase();
                    input["in2"] = bidang1.val().toUpperCase();
                } else if (val == 5) {
                    action = "/sbb.php";
                    input["in1"] = bidang1.val().toUpperCase();
                    input["in2"] = bidang2.val().toUpperCase();
                }
                const form = $('<form />', {
                    action: action,
                    method: "GET",
                    style: 'display: none;'
                });

                val = bentuk.val();

                if (val == 0) {
                    input["shape"] = 0;
                    input["l"] = $("#l").val();
                    input["w"] = $("#l").val();
                    input["h"] = $("#l").val();
                } else if (val == 1) {
                    input["shape"] = 0;
                    input["l"] = $("#l").val();
                    input["w"] = $("#w").val();
                    input["h"] = $("#h").val();
                } else if (val == 2) {
                    input["shape"] = 1;
                    input["l"] = $("#l").val();
                    input["w"] = $("#w").val();
                    input["h"] = $("#h").val();
                }
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
            canvasUpdateBox(1, 1, 1);
        });

        function canvasUpdateBox(l, w, h) {
            sceneManager.setMainGeom(new MyBox(mainPointMaterial, mainLineMaterial, l, w, h));
            $.each(boxPoints, function(k, v) {
                sceneManager.scene.add(new MyPoint(mainPointMaterial, {
                    x: v["point"].x(l),
                    y: v["point"].y(h),
                    z: v["point"].z(w)
                }).mesh);
                sceneManager.scene.add(new MyLabel({
                    x: v["label"].x(l),
                    y: v["label"].y(h),
                    z: v["label"].z(w),
                    text: v["label"]["text"]
                }).mesh);
            });
        }

        function canvasUpdatePyramid(l, w, h) {
            sceneManager.setMainGeom(new MyPyramid(mainPointMaterial, mainLineMaterial, l, w, h));
            $.each(pyramidPoints, function(k, v) {
                sceneManager.scene.add(new MyPoint(mainPointMaterial, {
                    x: v["point"].x(l),
                    y: v["point"].y(h),
                    z: v["point"].z(w)
                }).mesh);
                sceneManager.scene.add(new MyLabel({
                    x: v["label"].x(l),
                    y: v["label"].y(h),
                    z: v["label"].z(w),
                    text: v["label"]["text"]
                }).mesh);
            });
        }

        function canvasUpdate() {
            for (let i = sceneManager.scene.children.length - 1; i >= 0; i--) {
                sceneManager.scene.remove(sceneManager.scene.children[i]);
            }
            const temp = $("#bentuk").val();
            if (temp == 0) {
                canvasUpdateBox(1, 1, 1);
            } else if (temp == 1) {
                canvasUpdateBox(1.25, 1, 0.75);
            } else if (temp == 2) {
                canvasUpdatePyramid(1, 1, 1);
            }
        }
    </script>
</div>