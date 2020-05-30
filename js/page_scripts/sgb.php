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
	if (!validCheck(in1, 2, lines) || !validCheck(in2, 3, planes)) {
		window.location.replace("error.php?code=0");
	}
	const in1pt = strToPoints(in1, shape, drawL, drawW, drawH),
		in2pt = strToPoints(in2, shape, drawL, drawW, drawH),
		scaleL = l / drawL,
		scaleW = w / drawW,
		scaleH = h / drawH;
	const g = [in1pt[0]["point"], in1pt[1]["point"]],
		b = [];

	const content = [];
	const initMeshes = [];
	initMeshes.push(new MyPoint(probPointMaterial, g[0]));
	initMeshes.push(new MyLabel(in1pt[0]["label"]));
	initMeshes.push(new MyPoint(probPointMaterial, g[1]));
	initMeshes.push(new MyLabel(in1pt[1]["label"]));
	initMeshes.push(new MyLine(probLineMaterial, g));
	for (let i = 0; i < in2pt.length; i++) {
        b.push(in2pt[i]["point"]);
        initMeshes.push(new MyPoint(probPointMaterial, in2pt[i]["point"]));
        initMeshes.push(new MyLabel(in2pt[i]["label"]));
	}
	initMeshes.push(new MyPlane(probPlaneMaterial, b));
	addSolutionStep(content, <?= json_encode($data["soal"]) ?>, sceneManager, initMeshes);

	const probPlane = new THREE.Plane().setFromCoplanarPoints(
        new THREE.Vector3(b[0].x, b[0].y, b[0].z),
        new THREE.Vector3(b[1].x, b[1].y, b[1].z),
        new THREE.Vector3(b[2].x, b[2].y, b[2].z)
    ).normalize();
    let helperPlane = null;
    let tempLine = [new THREE.Vector3(g[0]["x"], g[0]["y"], g[0]["z"]), new THREE.Vector3(g[1]["x"], g[1]["y"], g[1]["z"])];
    for (let i = 0; i < planes.length && helperPlane == null; i++) {
        if (planes[i].plane.normal.dot(probPlane.normal) == 0 && planes[i].plane.projectPoint(tempLine[0]).equals(tempLine[0]) && planes[i].plane.projectPoint(tempLine[1]).equals(tempLine[1])) {
            helperPlane = planes[i];
        }
    }
    if (helperPlane == null) {
        window.location.replace("error.php?code=2");
    }
    const bb = [];
    initMeshes.length = 0;
    strToPoints(helperPlane.name, shape, drawL, drawW, drawH).forEach(e => {
        bb.push(e["point"]);
        initMeshes.push(new MyPoint(helper1PointMaterial, e["point"]));
        initMeshes.push(new MyLabel(e["label"]));
    });
    initMeshes.push(new MyPlane(helper1PlaneMaterial, bb));

	addSolutionStep(content, makePageContent(
        "panel_content",
        "fa-pencil-square-o",
        `Cara Pengerjaan`,
        "",
        [
            `Gambar bidang yang memuat garis ${in1} dan tegak lurus terhadap bidang ${in2}. Anda dapat mengubah arah kamera untuk melihat bahwa kedua bidang membentuk sudut 90 derajat. Arahkan kamera hingga kedua bidang tampak seperti 2 garis. Akan terlihat bahwa kedua garis tersebut tegak lurus.`,
            `Cara lain untuk menentukan bidang yang tegak lurus biasanya adalah dengan menggambar garis yang tegak lurus dengan garis ${in2[0]}${in2[1]}${in2.length > 3 ? " dan garis " + in2[2] + in2[3] : ""}. Lalu dari garis itu digambar sebuah bidang.`
        ]
    ), sceneManager, initMeshes.slice());

	for (let i = 0; i < planes.length; i++) {
        const e = planes[i];
    }

    let solLine = null;
    for (let i = 0; i < lines.length && solLine == null; i++) {
        const e = lines[i];
        if (probPlane.projectPoint(e["points"][0]).equals(e["points"][0]) &&
            probPlane.projectPoint(e["points"][1]).equals(e["points"][1]) &&
            helperPlane.plane.projectPoint(e["points"][0]).equals(e["points"][0]) &&
            helperPlane.plane.projectPoint(e["points"][1]).equals(e["points"][1])
        ) {
            solLine = lines[i];
        }
    }
    if (solLine == null) {
        window.location.replace("error.php?code=2");
    }
    const ll = [];
    initMeshes.length = 0;
    strToPoints(solLine.name, shape, drawL, drawW, drawH).forEach(e => {
        ll.push(e["point"]);
        initMeshes.push(new MyPoint(helper2PointMaterial, e["point"]));
        initMeshes.push(new MyLabel(e["label"]));
    });
    initMeshes.push(new MyLine(helper2LineMaterial, ll));

    addSolutionStep(content, makePageContent(
        "panel_content",
        "fa-pencil-square-o",
        `Cara Pengerjaan`,
        "",
        [
            `Gambar garis perpotongan antar 2 bidang (garis ${solLine["name"]})`
        ]
	), sceneManager, initMeshes.slice());
	
	initMeshes.length = 0;
    addSolutionStep(content, makePageContent(
        "panel_content",
        "fa-pencil-square-o",
        `Cara Pengerjaan`,
        "",
        [
            `Sudut antara garis ${in1} ke bidang ${in2} sama dengan <a target="_blank" href='/sgg.php?in1=${in1}&in2=${solLine["name"]}&shape=${shape}&l=${l}&w=${w}&h=${h}'>sudut antara garis ${in1} dan garis ${solLine["name"]}</a>. Klik link untuk melihat cara menghitung sudut tersebut.`
        ]
    ), sceneManager);

	loadPageContent(content);
</script>