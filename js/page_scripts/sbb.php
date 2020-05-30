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
	if (!validCheck(in1, 3, planes) || !validCheck(in2, 3, planes)) {
		window.location.replace("error.php?code=0");
	}
	const in1pt = strToPoints(in1, shape, drawL, drawW, drawH),
		in2pt = strToPoints(in2, shape, drawL, drawW, drawH),
		scaleL = l / drawL,
		scaleW = w / drawW,
		scaleH = h / drawH;
	const b1 = [],
		b2 = [];

	const content = [];
	const initMeshes = [];
	for (let i = 0; i < in1pt.length; i++) {
		b1.push(in1pt[i]["point"]);
		initMeshes.push(new MyPoint(probPointMaterial, in1pt[i]["point"]));
		initMeshes.push(new MyLabel(in1pt[i]["label"]));
	}
	initMeshes.push(new MyPlane(probPlaneMaterial, b1));
	for (let i = 0; i < in2pt.length; i++) {
		b2.push(in2pt[i]["point"]);
		initMeshes.push(new MyPoint(probPointMaterial, in2pt[i]["point"]));
		initMeshes.push(new MyLabel(in2pt[i]["label"]));
	}
	initMeshes.push(new MyPlane(helper1PlaneMaterial, b2));
	addSolutionStep(content, <?= json_encode($data["soal"]) ?>, sceneManager, initMeshes);

	const probPlane = [new THREE.Plane().setFromCoplanarPoints(
			new THREE.Vector3(b1[0].x, b1[0].y, b1[0].z),
			new THREE.Vector3(b1[1].x, b1[1].y, b1[1].z),
			new THREE.Vector3(b1[2].x, b1[2].y, b1[2].z)
		).normalize(),
		new THREE.Plane().setFromCoplanarPoints(
			new THREE.Vector3(b2[0].x, b2[0].y, b2[0].z),
			new THREE.Vector3(b2[1].x, b2[1].y, b2[1].z),
			new THREE.Vector3(b2[2].x, b2[2].y, b2[2].z)
		).normalize()
	];

	let helperLine = null;
	for (let i = 0; i < lines.length && helperLine == null; i++) {
		const e = lines[i];
		if (probPlane[0].projectPoint(e["points"][0]).equals(e["points"][0]) &&
			probPlane[0].projectPoint(e["points"][1]).equals(e["points"][1]) &&
			probPlane[1].projectPoint(e["points"][0]).equals(e["points"][0]) &&
			probPlane[1].projectPoint(e["points"][1]).equals(e["points"][1])
		) {
			helperLine = lines[i];
		}
	}
	if (helperLine == null) {
		window.location.replace("error.php?code=2");
	}
	const ll = [];
	initMeshes.length = 0;
	strToPoints(helperLine.name, shape, drawL, drawW, drawH).forEach(e => {
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
			`Gambar garis perpotongan antara bidang ${in1} dengan bidang ${in2} (garis ${helperLine["name"]})`
		]
	), sceneManager, initMeshes.slice());

	for (let i = 0; i < planes.length; i++) {
		const e = planes[i];
	}

	let solLine = [];
	probPlane.forEach(plane => {
		let tempSol = null;
		for (let i = 0; i < lines.length && tempSol == null; i++) {
			const e = lines[i];
			if (plane.projectPoint(e["points"][0]).equals(e["points"][0]) &&
				plane.projectPoint(e["points"][1]).equals(e["points"][1]) &&
				lines[i]["vec"].dot(helperLine["vec"]) == 0) {
				tempSol = lines[i];
			}
		}
		if (tempSol == null) {
			window.location.replace("error.php?code=2");
		}
		const ll = [];
		initMeshes.length = 0;
		strToPoints(tempSol.name, shape, drawL, drawW, drawH).forEach(e => {
			ll.push(e["point"]);
			initMeshes.push(new MyPoint(helper2PointMaterial, e["point"]));
			initMeshes.push(new MyLabel(e["label"]));
		});
		initMeshes.push(new MyLine(helper2LineMaterial, ll));
		solLine.push(tempSol);

		addSolutionStep(content, makePageContent(
			"panel_content",
			"fa-pencil-square-o",
			`Cara Pengerjaan`,
			"",
			[
				`Gambar garis yang tegak lurus ${helperLine["name"]} dan terletak pada bidang ${[in1, in2][solLine.length - 1]} (garis ${tempSol["name"]})`
			]
		), sceneManager, initMeshes.slice());
	});

	initMeshes.length = 0;
	addSolutionStep(content, makePageContent(
		"panel_content",
		"fa-pencil-square-o",
		`Cara Pengerjaan`,
		"",
		[
			`Sudut antara bidang ${in1} dan bidang ${in2} sama dengan <a target="_blank" href='/sgg.php?in1=${solLine[0]["name"]}&in2=${solLine[1]["name"]}&shape=${shape}&l=${l}&w=${w}&h=${h}'>sudut antara garis ${solLine[0]["name"]} dan garis ${solLine[1]["name"]}</a>. Klik link untuk melihat cara menghitung sudut tersebut.`
		]
	), sceneManager);

	loadPageContent(content);
</script>