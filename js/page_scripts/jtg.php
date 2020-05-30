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
    [points, lines, planes] = generateElements(shape, drawL, drawW, drawH);
    if (!validCheck(in1, 1, points) || !validCheck(in2, 2, lines)) {
        window.location.replace("error.php?code=0");
    }
    const in1pt = strToPoints(in1, shape, drawL, drawW, drawH)[0],
        in2pt = strToPoints(in2, shape, drawL, drawW, drawH),
        scaleL = l / drawL,
        scaleW = w / drawW,
        scaleH = h / drawH;
    const t = in1pt["point"],
        g = [in2pt[0]["point"], in2pt[1]["point"]];

    const content = [];
    const initMeshes = [];
    initMeshes.push(new MyPoint(probPointMaterial, t));
    initMeshes.push(new MyLabel(in1pt["label"]));
    initMeshes.push(new MyPoint(probPointMaterial, g[0]));
    initMeshes.push(new MyLabel(in2pt[0]["label"]));
    initMeshes.push(new MyPoint(probPointMaterial, g[1]));
    initMeshes.push(new MyLabel(in2pt[1]["label"]));
    initMeshes.push(new MyLine(probLineMaterial, g));
    addSolutionStep(content, <?= json_encode($data["soal"]) ?>, sceneManager, initMeshes);

    addSolutionStep(content, makePageContent(
        "panel_content",
        "fa-pencil-square-o",
        `Cara Pengerjaan`,
        "",
        [
            `Gambar bidang yang memuat titik ${in1} dan garis ${in2} (bidang ${in1 + in2}).`
        ]
    ), sceneManager, [
        new MyPlane(helper1PlaneMaterial, [
            t, g[0], g[1]
        ])
    ]);

    let tnew = new THREE.Vector3();
    //types:
    //0 -> titik barunya sama kayak g[0]
    //1 -> titik barunya sama kayak g[1]
    //2 -> segitiga siku2
    //3 -> segitiga sama kaki
    //4 -> segitiga sembarang
    // const cameraPos = {
    //     pos: new THREE.Vector3(),
    //     lookAt: new THREE.Vector3()
    // };
    let type = 4; {
        const a = new THREE.Vector3(t["x"], t["y"], t["z"]);
        const b = new THREE.Vector3(g[0]["x"], g[0]["y"], g[0]["z"]);
        const c = new THREE.Vector3(g[1]["x"], g[1]["y"], g[1]["z"]);
        const d = new THREE.Vector3().subVectors(c, b).divideScalar(c.distanceTo(b));
        const v = new THREE.Vector3().subVectors(a, b);
        const t2 = v.dot(d);
        d.multiplyScalar(t2);
        tnew = new THREE.Vector3().addVectors(b, d);
        const ab = a.distanceTo(b),
            ac = a.distanceTo(c),
            bc = b.distanceTo(c);
        const abv = new THREE.Vector3().subVectors(b, a),
            acv = new THREE.Vector3().subVectors(c, a);
        if ((tnew["x"] == b["x"] &&
                tnew["y"] == b["y"] &&
                tnew["z"] == b["z"])) {
            type = 0;
        } else if ((tnew["x"] == c["x"] &&
                tnew["y"] == c["y"] &&
                tnew["z"] == c["z"])) {
            type = 1;
        } else if (ab == ac) {
            type = 3;
        } else if (abv.dot(acv) == 0) {
            type = 2;
        }
        // const plane = new THREE.Plane().setFromCoplanarPoints(a, b, c).normalize();
        // const p0 = new THREE.Vector3(t["x"] + g[0]["x"] + g[1]["x"], t["y"] + g[0]["y"] + g[1]["y"], t["z"] + g[0]["z"] + g[1]["z"]).divideScalar(3);
        // const diag = Math.sqrt(drawL * drawL + drawW * drawW + drawH * drawH);
        // const p1 = p0.addScaledVector(plane.normal, diag);
        // const p2 = p0.addScaledVector(plane.normal, -diag);
        // cameraPos.lookAt = p0;
        // if (p1.length() < p2.length()) {
        //     cameraPos["pos"] = p1;
        // } else {
        //     cameraPos["pos"] = p2;
        // }
    }

    addSolutionStep(content, makePageContent(
        "panel_content",
        "fa-pencil-square-o",
        `Cara Pengerjaan`,
        "",
        [
            `Gambar garis dari titik ${in1} yang tegak lurus dengan garis ${in2}. Beri nama titik baru dengan ${in1}'. Jarak titik ${in1} ke garis ${in2} sama dengan panjang garis ${in1}${in1}'`
        ]
    ), sceneManager, [
        new MyPoint(helper2PointMaterial, tnew),
        new MyLabel({
            x: tnew["x"],
            y: tnew["y"],
            z: tnew["z"],
            text: in1 + "'"
        }),
        new MyLine(helper2LineMaterial, [t, tnew])
    ]);

    if (type == 0 || type == 1) {
        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Cara Pengerjaan`,
            "",
            [
                `Ternyata titik ${in1}' sama posisinya dengan titik ${in2[type]} sehingga panjang ${in1}${in1}' sama dengan <a target='_blank' href='/jtt.php?in1=${in1}&in2=${in2[type]}&shape=${shape}&l=${l}&w=${w}&h=${h}'>jarak titik ${in1} ke titik ${in2[type]}</a>.`,
                `Untuk melihat cara menghitung panjang garis ${in1}${in2[type]} bisa klik link di atas.`
            ]
        ), sceneManager, [
            new MyPoint(helper2PointMaterial, tnew),
            new MyLabel({
                x: tnew["x"],
                y: tnew["y"],
                z: tnew["z"],
                text: in1 + "'"
            }),
            new MyLine(helper2LineMaterial, [t, tnew])
        ]);
    } else {
        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Cara Pengerjaan`,
            "",
            [
                `Untuk menghitung panjang garis ${in1}${in1}', pertama-tama tentukan dahulu jenis segitiga ${in1}${in2[0]}${in2[1]}, apakah segitiga siku-siku, segitiga sama kaki dengan kaki yang sama di ${in1}${in2[0]} dan ${in1}${in2[1]}, atau segitiga lain.`,
                `Jenis segitiga dapat ditentukan dari memperhatikan bentuk segitiga (putar kamera hingga bentuk segitiga terlihat jelas), atau dengan cara menghitung panjang <a target='_blank' href='/jtt.php?in1=${in1}&in2=${in2[0]}&shape=${shape}&l=${l}&w=${w}&h=${h}'>garis ${in1}${in2[0]}</a>, <a target='_blank' href='/jtt.php?in1=${in1}&in2=${in2[1]}&shape=${shape}&l=${l}&w=${w}&h=${h}'>garis ${in1}${in2[1]}</a>, dan <a target='_blank' href='/jtt.php?in1=${in2[0]}&in2=${in2[1]}&shape=${shape}&l=${l}&w=${w}&h=${h}'>garis ${in2[0]}${in2[1]}</a>`,
                // "Ketika tombol lanjut ditekan kamera akan diarahkan sehingga bentuk segitiga terlihat dan panjang ketiga garis akan dihitung. Untuk melihat cara menghitung ketiga garis bisa klik link di atas."
            ]
        ), sceneManager, [
            new MyPoint(helper2PointMaterial, tnew),
            new MyLabel({
                x: tnew["x"],
                y: tnew["y"],
                z: tnew["z"],
                text: in1 + "'"
            }),
            new MyLine(helper2LineMaterial, [t, tnew])
        ]);

        const triangleLines = [
            myDist(t, g[0], scaleL, scaleW, scaleH),
            myDist(t, g[1], scaleL, scaleW, scaleH),
            myDist(g[0], g[1], scaleL, scaleW, scaleH)
        ];

        const paragraphs = [
            `\\( ${in1}${in2[0]} = ${triangleLines[0]} cm \\)`,
            `\\( ${in1}${in2[1]} = ${triangleLines[1]} cm \\)`,
            `\\( ${in2[0]}${in2[1]} = ${triangleLines[2]} cm \\)`
        ];

        if (type == 2) {
            paragraphs.push(`Segitiga ${in1}${in2[0]}${in2[1]} adalah segitiga siku-siku di ${in1}`);
        } else if (type == 3) {
            paragraphs.push(`Segitiga ${in1}${in2[0]}${in2[1]} adalah segitiga sama kaki dengan \\( ${in1}${in2[0]} = ${in1}${in2[1]} \\)`);
        }

        // addSolutionStep(content, makePageContent(
        //     "panel_content",
        //     "fa-pencil-square-o",
        //     `Cara Pengerjaan`,
        //     "",
        //     paragraphs
        // ), sceneManager, [], cameraPos);
        addSolutionStep(content, makePageContent(
            "panel_content",
            "fa-pencil-square-o",
            `Cara Pengerjaan`,
            "",
            paragraphs
        ), sceneManager, []);

        if (type == 2) {
            let temp = [new SqrtFracHelper(
                new SqrtHelper(triangleLines[0].a.a, triangleLines[0].a.b),
                new SqrtHelper(triangleLines[0].b.a, triangleLines[0].b.b)
            ).mul(triangleLines[1])];
            temp.push(
                new SqrtFracHelper(
                    new SqrtHelper(temp[0].a.a, temp[0].a.b).mul(triangleLines[2].b),
                    new SqrtHelper(triangleLines[2].a.a, triangleLines[2].a.b).mul(temp[0].b)
                )
            );

            const paragraphs = [
                `Panjang garis ${in1}${in1}' dapat dihitung menggunakan rumus luas segitiga. Luas segitiga ${in1}${in2[0]}${in2[1]} dapat dihitung menggunakan garis ${in1}${in2[0]} sebagai alas segitiga dan garis ${in1}${in2[1]} sebagai tinggi segitiga, atau garis ${in2[0]}${in2[1]} sebagai alas segitiga dan ${in1}${in1}' sebagai tinggi segitiga (ingat bahwa alas dan tinggi segitiga boleh ditarik dari titik manapun asal kedua titik tegak lurus)`,
                `\\( \\frac{1}{2} \\times ${in1}${in1}' \\times ${in2[0]}${in2[1]} = \\frac{1}{2} \\times ${in1}${in2[0]} \\times ${in1}${in2[1]} \\)`,
                `\\(${in1}${in1}' = \\frac{${in1}${in2[0]} \\times ${in1}${in2[1]}}{${in2[0]}${in2[1]}} \\)`,
                `\\(${in1}${in1}' = \\frac{${triangleLines[0]} \\times ${triangleLines[1]}}{${triangleLines[2]}} \\)`,
            ];

            if (`\\(${in1}${in1}' = \\frac{${temp[0]}}{${triangleLines[2]}} \\)` != `\\(${in1}${in1}' = ${temp[1]}\\)`) {
                paragraphs.push(`\\(${in1}${in1}' = \\frac{${temp[0]}}{${triangleLines[2]}} \\)`);
            }
            paragraphs.push(`\\(${in1}${in1}' = ${temp[1]} cm\\)`);

            addSolutionStep(content, makePageContent(
                "panel_content",
                "fa-pencil-square-o",
                `Cara Pengerjaan`,
                "Segitiga siku-siku",
                paragraphs
            ), sceneManager);
        } else if (type == 3) {
            // console.log("asdf");
            // console.log(triangleLines[2]);
            let temp = [new SqrtFracHelper(
                new SqrtHelper(triangleLines[2].a.a, triangleLines[2].a.b),
                new SqrtHelper(triangleLines[2].b.a * 2, triangleLines[2].b.b)
            )];
            // console.log(triangleLines[2]);
            temp.push(triangleLines[0].squared());
            temp.push(temp[0].squared());
            temp.push(new SqrtFracHelper(
                new SqrtHelper(temp[1].a * temp[2].b - temp[2].a * temp[1].b),
                new SqrtHelper(temp[1].b * temp[2].b)
            ));
            const paragraphs = [
                `Karena \\( ${in1}${in2[0]} = ${in1}${in2[1]} \\), maka titik ${in1}' berada di tengah-tengah garis ${in2[0]}${in2[1]}, sehingga \\( ${in1}'${in2[0]} = ${temp[0]}\\)`,
                `Gunakan teorema Pythagoras untuk menghitung panjang ${in1}${in1}' dengan ${in1}'${in2[0]} sebagai alas, ${in1}${in1}' sebagai garis tinggi, dan ${in1}${in2[0]} sebagai sisi miring`,
                `\\(${in1}${in1}' = \\sqrt{(${triangleLines[0]})^2-(${temp[0]})^2}\\)`,
                `\\(${in1}${in1}' = \\sqrt{${temp[1]}-${temp[2]}}\\)`,
            ]
            if (`\\(${in1}${in1}' = \\sqrt{${temp[3].squared()}}\\)` != `\\(${in1}${in1}' = ${temp[3]}\\)`) {
                paragraphs.push(`\\(${in1}${in1}' = \\sqrt{${temp[3].squared()}}\\)`);
            }
            paragraphs.push(`\\(${in1}${in1}' = ${temp[3]} cm\\)`);
            addSolutionStep(content, makePageContent(
                "panel_content",
                "fa-pencil-square-o",
                `Cara Pengerjaan`,
                "Segitiga sama kaki",
                paragraphs
            ), sceneManager);
        } else if (type == 4) {
            let paragraphs = [
                `Segitiga ${in1}${in2[0]}${in2[1]} dapat dibagi menjadi 2 buah segitiga siku-siku, yaitu segitiga ${in1}${in1}'${in2[0]} dan ${in1}${in1}'${in2[1]}. Perhatikan bahwa:`,
                `\\(${in1}${in1}' = \\sqrt{${in1}${in2[0]}^2 - ${in1}'${in2[0]}^2}\\)`,
                `\\(${in1}${in1}' = \\sqrt{${in1}${in2[1]}^2 - ${in1}'${in2[1]}^2}\\)`,
                `\\( \\therefore \\sqrt{${in1}${in2[0]}^2 - ${in1}'${in2[0]}^2} = \\sqrt{${in1}${in2[1]}^2 - ${in1}'${in2[1]}^2}\\)`,
                `\\( ${in1}${in2[0]}^2 - ${in1}'${in2[0]}^2 = ${in1}${in2[1]}^2 - ${in1}'${in2[1]}^2 \\)`
            ]
            addSolutionStep(content, makePageContent(
                "panel_content",
                "fa-pencil-square-o",
                `Cara Pengerjaan`,
                "Kasus lain",
                paragraphs
            ), sceneManager);

            let temp = {
                "a": `${in1}${in2[1]}`,
                "b": `${in1}${in2[0]}`,
                "c": `${in2[0]}${in2[1]}`,
                "x": `${in1}'${in2[1]}`
            };

            paragraphs = [
                `\\( ${in1}${in2[0]}^2 - ${in1}'${in2[0]}^2 = ${in1}${in2[1]}^2 - ${in1}'${in2[1]}^2 \\)`,
                `\\( ${temp["b"]}^2 - (${temp["c"]} - ${temp["x"]})^2 = ${temp["a"]}^2 - ${temp["x"]}^2 \\)`,
                `\\( ${temp["b"]}^2 - (${temp["c"]}^2 - 2(${temp["c"]})(${temp["x"]}) + ${temp["x"]}^2) = ${temp["a"]}^2 - ${temp["x"]}^2 \\)`,
                `\\( ${temp["b"]}^2 - ${temp["c"]}^2 + 2(${temp["c"]})(${temp["x"]}) - ${temp["x"]}^2 = ${temp["a"]}^2 - ${temp["x"]}^2 \\)`,
                `\\( ${temp["b"]}^2 - ${temp["c"]}^2 + 2(${temp["c"]})(${temp["x"]}) = ${temp["a"]}^2 \\)`,
                `\\( 2(${temp["c"]})(${temp["x"]}) = ${temp["a"]}^2 - ${temp["b"]}^2 + ${temp["c"]}^2 \\)`,
                `\\( ${temp["x"]} = \\frac{${temp["a"]}^2 - ${temp["b"]}^2 + ${temp["c"]}^2}{2${temp["c"]}}\\)`,
            ]
            addSolutionStep(content, makePageContent(
                "panel_content",
                "fa-pencil-square-o",
                `Cara Pengerjaan`,
                "Kasus lain",
                paragraphs
            ), sceneManager);

            temp = [triangleLines[1].squared(), triangleLines[0].squared(), triangleLines[2].squared()]
            temp.push(
                new FracHelper(
                    temp[0].a * temp[1].b * temp[2].b - temp[0].b * temp[1].a * temp[2].b + temp[0].b * temp[1].b * temp[2].a,
                    temp[0].b * temp[1].b * temp[2].b
                )
            );
            temp.push(
                new SqrtFracHelper(
                    new SqrtHelper(
                        temp[3].a * triangleLines[2].b.a, triangleLines[2].b.b
                    ),
                    new SqrtHelper(
                        temp[3].b * triangleLines[2].a.a * 2, triangleLines[2].a.b
                    )
                )
            );
            paragraphs = [
                `\\( ${in1}'${in2[1]} = \\frac{(${triangleLines[1]})^2 - (${triangleLines[0]})^2 + (${triangleLines[2]})^2}{2(${triangleLines[2]})}\\)`,
                `\\( ${in1}'${in2[1]} = \\frac{${triangleLines[1].squared()} - ${triangleLines[0].squared()} + ${triangleLines[2].squared()}}{2(${triangleLines[2]})}\\)`,
                `\\( ${in1}'${in2[1]} = \\frac{${temp[3]}}{2(${triangleLines[2]})}\\)`,
                `\\( ${in1}'${in2[1]} = ${temp[4]}\\)`,
            ]
            addSolutionStep(content, makePageContent(
                "panel_content",
                "fa-pencil-square-o",
                `Cara Pengerjaan`,
                "Kasus lain",
                paragraphs
            ), sceneManager);

            temp.push(
                triangleLines[1].squared(),
                temp[4].squared()
            );
            temp.push(
                new FracHelper(
                    temp[5].a * temp[6].b - temp[5].b * temp[6].a,
                    temp[5].b * temp[6].b
                )
            );
            temp.push(
                new SqrtFracHelper(
                    new SqrtHelper(temp[7].a),
                    new SqrtHelper(temp[7].b)
                )
            )
            paragraphs = [
                `\\(${in1}${in1}' = \\sqrt{${in1}${in2[1]}^2 - ${in1}'${in2[1]}^2}\\)`,
                `\\(${in1}${in1}' = \\sqrt{(${triangleLines[1]})^2 - (${temp[4]})^2}\\)`,
                `\\(${in1}${in1}' = \\sqrt{${triangleLines[1].squared()} - ${temp[4].squared()}}\\)`,
            ]
            if (`\\(${in1}${in1}' = \\sqrt{${temp[7]}}\\)` != `\\(${in1}${in1}' = ${temp[8]}\\)`) {
                paragraphs.push(`\\(${in1}${in1}' = \\sqrt{${temp[7]}}\\)`);
            }
            paragraphs.push(`\\(${in1}${in1}' = ${temp[8]} cm\\)`);
            addSolutionStep(content, makePageContent(
                "panel_content",
                "fa-pencil-square-o",
                `Cara Pengerjaan`,
                "Kasus lain",
                paragraphs
            ), sceneManager);
        }
    }

    loadPageContent(content);
</script>