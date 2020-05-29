<script>
    sceneManager.setMainGeom(<?= $data["mainGeom"] ?>);
    const l = <?= $data["l"] ?>,
        w = <?= $data["w"] ?>,
        h = <?= $data["h"] ?>,
        drawL = <?= $data["drawL"] ?>,
        drawW = <?= $data["drawW"] ?>,
        drawH = <?= $data["drawH"] ?>,
        in1 = "<?= $data["in1"] ?>",
        in2 = "<?= $data["in2"] ?>",
        shape = <?= $data["shape"] ?>;
    let points = null,
        lines = null,
        planes = null;
    [points, lines, planes] = generateElements(shape, l, w, h);
    if (!validCheck(in1, 1, points) || !validCheck(in2, 1, points)) {
        window.location.replace("error.php?code=0");
    }
    const in1pt = strToPoints(in1, shape, drawL, drawW, drawH)[0],
        in2pt = strToPoints(in2, shape, drawL, drawW, drawH)[0],
        scaleL = l / drawL,
        scaleW = w / drawW,
        scaleH = h / drawH;
    const t1 = in1pt["point"],
        t2 = in2pt["point"];
    const pts = [t1];
    if (pts[pts.length - 1]["x"] != t2["x"]) {
        pts.push({
            "x": t2["x"],
            "y": t1["y"],
            "z": t1["z"]
        });
    }
    if (pts[pts.length - 1]["y"] != t2["y"]) {
        pts.push({
            "x": t2["x"],
            "y": t2["y"],
            "z": t1["z"]
        });
    }
    if (pts[pts.length - 1]["z"] != t2["z"]) {
        pts.push({
            "x": t2["x"],
            "y": t2["y"],
            "z": t2["z"]
        });
    }

    const content = [];
    const initMeshes = [];
    initMeshes.push(new MyPoint(probPointMaterial, in1pt["point"]));
    initMeshes.push(new MyLabel(in1pt["label"]));
    initMeshes.push(new MyPoint(probPointMaterial, in2pt["point"]));
    initMeshes.push(new MyLabel(in2pt["label"]));
    initMeshes.push(new MyLine(helper1LineMaterial, [in1pt["point"], in2pt["point"]]));

    addSolutionStep(content, <?= json_encode($data["soal"]) ?>, sceneManager, initMeshes);

    addSolutionStep(content, makePageContent(
        "panel_content",
        "fa-pencil-square-o",
        `Cara Pengerjaan`,
        "",
        [
            `Gambar satu atau lebih garis bantu yang menghubungkan titik ${in1} dan ${in2}. Syaratnya adalah garis harus sejajar sumbu X (garis ke kiri / kanan), sejajar sumbu Y (ke atas / bawah), atau sumbu Z (masuk ke dalam / keluar). Kemudian hitunglah panjang masing-masing garis bantu.`
        ]
    ), sceneManager);

    pts.splice(0, 1);
    let temp = t1;
    let ctrLangkah = 1;
    let lineLengths = [];
    for (let i = 0; i < pts.length; i++) {
        let len = myRound(Math.abs((temp["x"] - pts[i]["x"]) * scaleL + (temp["y"] - pts[i]["y"]) * scaleH + (temp["z"] - pts[i]["z"]) * scaleW));
        if (Math.floor(len) != len) {
            len = new FracHelper(len * 16, 16);
        }
        lineLengths.push(len);
        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Langkah ${ctrLangkah}`,
            "",
            [`Gambar garis bantu dan ukur jaraknya (dalam kasus ini jaraknya adalah \\( ${len} \\))`]), sceneManager, [
            new MyPoint(helper2PointMaterial, pts[i]),
            new MyLine(helper2LineMaterial, [temp, pts[i]])
        ]);
        ctrLangkah++;
        temp = pts[i];
    }

    if (lineLengths.length == 0) {
        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Perhitungan jarak`,
            "",
            [`Ternyata kedua titik posisinya sama sehingga jaraknya adalah 0`]), sceneManager);
    } else if (lineLengths.length == 1) {
        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Perhitungan jarak`,
            "",
            [`Jarak kedua titik adalah \\( ${lineLengths[0]} cm \\)`]), sceneManager);
    } else {
        const paragraphs = [`Gunakan teorema Pythagoras untuk menghitung panjang garis. Panjang garis adalah:`];
        paragraphs.push(`\\( ${in1}${in2} = \\sqrt{${lineLengths.join("^2 + ")}^2} \\)`);
        let sum = 0;
        for (let i = 0; i < lineLengths.length; i++) {
            const e = lineLengths[i];
            if (lineLengths[i] instanceof FracHelper) {
                sum += lineLengths[i].a * lineLengths[i].a / lineLengths[i].b / lineLengths[i].b;
            } else {
                sum += e * e;
            }
        }
        if (Math.floor(sum) != sum) {
            console.log(sum);
            console.log(new SqrtHelper(sum * 16));
            console.log(new SqrtHelper(16));
            sum = new SqrtFracHelper(new SqrtHelper(sum * 16), new SqrtHelper(16));
            console.log(sum);
        } else {
            sum = new SqrtHelper(sum);
        }
        if (sum.a == 1) {
            paragraphs.push(`\\( ${in1}${in2} = \\sqrt{${sum.squared()}} cm\\)`);
        } else {
            paragraphs.push(`\\( ${in1}${in2} = \\sqrt{${sum.squared()}} \\)`);
            paragraphs.push(`\\( ${in1}${in2} = ${sum} cm\\)`);
        }

        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Perhitungan jarak`,
            "",
            paragraphs), sceneManager);
    }

    loadPageContent(content);
</script>