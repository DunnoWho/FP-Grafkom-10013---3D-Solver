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
	console.log(in1);
	console.log(in2);
	if (!validCheck(in1, 2, lines) || !validCheck(in2, 2, lines)) {
		window.location.replace("error.php?code=0");
	}
	const in1pt = strToPoints(in1, shape, drawL, drawW, drawH),
		in2pt = strToPoints(in2, shape, drawL, drawW, drawH),
		scaleL = l / drawL,
		scaleW = w / drawW,
		scaleH = h / drawH;
	const g1 = [in1pt[0]["point"], in1pt[1]["point"]],
		g2 = [in2pt[0]["point"], in2pt[1]["point"]];

	const content = [];
	const initMeshes = [];
	initMeshes.push(new MyPoint(probPointMaterial, g1[0]));
	initMeshes.push(new MyLabel(in1pt[0]["label"]));
	initMeshes.push(new MyPoint(probPointMaterial, g1[1]));
	initMeshes.push(new MyLabel(in1pt[1]["label"]));
	initMeshes.push(new MyLine(probLineMaterial, g1));
	initMeshes.push(new MyPoint(probPointMaterial, g2[0]));
	initMeshes.push(new MyLabel(in2pt[0]["label"]));
	initMeshes.push(new MyPoint(probPointMaterial, g2[1]));
	initMeshes.push(new MyLabel(in2pt[1]["label"]));
	initMeshes.push(new MyLine(probLineMaterial, g2));
	addSolutionStep(content, <?= json_encode($data["soal"]) ?>, sceneManager, initMeshes);

	let type = 0;
	let helperLine = [null, null, null]; {
		const a = new THREE.Vector3().subVectors(g1[0], g1[1]).normalize(),
			b = new THREE.Vector3().subVectors(g2[0], g2[1]).normalize();
		if (a.equals(b) || a.equals(b.negate())) {
			type = 1;
		} else if (in1[0] == in2[0] || in1[0] == in2[1] || in1[1] == in2[0] || in1[1] == in2[1]) {
			type = 2;
			if (in1[0] == in2[0]) {
				helperLine[0] = strToPoints(in1[1] + in2[1], shape, drawL, drawW, drawH);
			} else if (in1[0] == in2[1]) {
				helperLine[0] = strToPoints(in1[1] + in2[0], shape, drawL, drawW, drawH);
			} else if (in1[1] == in2[0]) {
				helperLine[0] = strToPoints(in1[0] + in2[1], shape, drawL, drawW, drawH);
			} else if (in1[1] == in2[1]) {
				helperLine[0] = strToPoints(in1[0] + in2[0], shape, drawL, drawW, drawH);
			}
		} else {
			for (let i = 0; i < lines.length && helperLine[0] == null; i++) {
				const e = lines[i];
				const f = new THREE.Vector3().subVectors(lines[i]["points"][0], lines[i]["points"][0]).normalize();
				if ((e["name"][0] == in2[0] || e["name"][0] == in2[1] || e["name"][1] == in2[0] || e["name"][1] == in2[1]) && (a.equals(f) || a.equals(f.negate()))) {
					type = 3;
					helperLine[1] = strToPoints(e["name"], shape, drawL, drawW, drawH);
					if (e["name"][0] == in2[0]) {
						helperLine[0] = strToPoints(e["name"][1] + in2[1], shape, drawL, drawW, drawH);
					} else if (e["name"][0] == in2[1]) {
						helperLine[0] = strToPoints(e["name"][1] + in2[0], shape, drawL, drawW, drawH);
					} else if (e["name"][1] == in2[0]) {
						helperLine[0] = strToPoints(e["name"][0] + in2[1], shape, drawL, drawW, drawH);
					} else if (e["name"][1] == in2[1]) {
						helperLine[0] = strToPoints(e["name"][0] + in2[0], shape, drawL, drawW, drawH);
					}
				}
			}
			if (helperLine[0] == null) {
				const temp = [null, null]
				for (let i = 0; i < lines.length && helperLine[0] == null; i++) {
					const e = lines[i];
					const c = new THREE.Vector3().subVectors(e["points"][0], e["points"][1]).normalize();
					if (a.equals(c) || a.equals(c.negate())) {
						temp[0] = e;
					} else if (b.equals(d) || b.equals(d.negate())) {
						temp[1] = e;
					}
					for (let j = i + 1; j < lines.length && (temp[0] == null ^ temp[1] == null); j++) {
						const ee = lines[j];
						if (e["name"][0] == ee["name"][0] || e["name"][0] == ee["name"][1] || e["name"][1] == ee["name"][0] || e["name"][1] == ee["name"][1]) {
							const d = new THREE.Vector3().subVectors(ee["points"][0], ee["points"][1]).normalize();
							if (temp[0] == null && (a.equals(d) || a.equals(d.negate()))) {
								temp[0] = ee;
							} else if (temp[1] == null && (b.equals(d) || b.equals(d.negate()))) {
								temp[1] = ee;
							}
						}
					}
				}
				if (temp[0] != null && temp[1] != null) {
					type = 4;
					helperLine[1] = strToPoints(temp[0]["name"], shape, drawL, drawW, drawH);
					helperLine[2] = strToPoints(temp[1]["name"], shape, drawL, drawW, drawH);
					if (temp[0]["name"][0] == temp[1]["name"][0]) {
						helperLine[0] = strToPoints(temp[0]["name"][1] + temp[1]["name"][1], shape, drawL, drawW, drawH);
					} else if (temp[0]["name"][0] == temp[1]["name"][1]) {
						helperLine[0] = strToPoints(temp[0]["name"][1] + temp[1]["name"][0], shape, drawL, drawW, drawH);
					} else if (temp[0]["name"][1] == temp[1]["name"][0]) {
						helperLine[0] = strToPoints(temp[0]["name"][0] + temp[1]["name"][1], shape, drawL, drawW, drawH);
					} else if (temp[0]["name"][1] == temp[1]["name"][1]) {
						helperLine[0] = strToPoints(temp[0]["name"][0] + temp[1]["name"][0], shape, drawL, drawW, drawH);
					}
				}
			}
		}
	}

	//types:
	//0 => fail
	//1 => sejajar
	//2 => udah nempel
	//3 => digeser baru nempel
	//4 => pakai garis ekstra
	if (type == 0) {
		window.location.replace("error.php?code=2");
	} else if (type == 1) {
		addSolutionStep(content, makePageContent(
			"panel_content",
			"fa-pencil-square-o",
			`Cara Pengerjaan`,
			"",
			[
				`Garis ${in1} dan garis ${in2} sejajar sehingga sudut di antara keduanya adalah \\( 0^\\circ \\)`
			]
		), sceneManager);
	} else {
		const meshes = [];
		let trigPoints = [helperLine[0][0]["label"]["text"], helperLine[0][1]["label"]["text"]];
		if (type == 2) {
			trigPoints.push(in1[0]);
			trigPoints.push(in1[1]);
			trigPoints.push(in2[0]);
			trigPoints.push(in2[1]);
		}
		if (type == 3) {
			meshes.push(new MyPoint(helper1PointMaterial, helperLine[1][0]["point"][0]));
			meshes.push(new MyLabel(helperLine[1][0]["label"]));
			meshes.push(new MyPoint(helper1PointMaterial, helperLine[1][0]["point"][1]));
			meshes.push(new MyLabel(helperLine[1][1]["label"]));
			meshes.push(new MyLine(helper1LineMaterial, helperLine[1][0]["point"]));
			trigPoints.push(in2[0]);
			trigPoints.push(in2[1]);
			trigPoints.push(helperLine[1][0]["label"]["text"]);
			trigPoints.push(helperLine[1][1]["label"]["text"]);
			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"",
				[
					`Gambar garis bantu yang sejajar dengan garis ${in1} dan berpotongan dengan garis ${in2} (garis ${helperLine[1][0]["label"]["text"]+helperLine[1][1]["label"]["text"]}). Sudut antara garis ${in1} dan ${in2} sama dengan sudut antara garis ${helperLine[1][0]["label"]["text"]+helperLine[1][1]["label"]["text"]} dengan garis ${in2}.`
				]
			), sceneManager, meshes.slice());
		} else if (type == 4) {
			meshes.push(new MyPoint(helper1PointMaterial, helperLine[1][0]["point"][0]));
			meshes.push(new MyLabel(helperLine[1][0]["label"]));
			meshes.push(new MyPoint(helper1PointMaterial, helperLine[1][0]["point"][1]));
			meshes.push(new MyLabel(helperLine[1][1]["label"]));
			meshes.push(new MyLine(helper1LineMaterial, helperLine[1][0]["point"]));

			meshes.push(new MyPoint(helper1PointMaterial, helperLine[2][0]["point"][0]));
			meshes.push(new MyLabel(helperLine[2][0]["label"]));
			meshes.push(new MyPoint(helper1PointMaterial, helperLine[2][0]["point"][1]));
			meshes.push(new MyLabel(helperLine[2][1]["label"]));
			meshes.push(new MyLine(helper1LineMaterial, helperLine[2][0]["point"]));

			trigPoints.push(helperLine[1][0]["label"]["text"]);
			trigPoints.push(helperLine[1][1]["label"]["text"]);
			trigPoints.push(helperLine[2][0]["label"]["text"]);
			trigPoints.push(helperLine[2][1]["label"]["text"]);

			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"",
				[
					`Gambar garis bantu yang sejajar dengan garis ${in1} (garis ${helperLine[1][0]["label"]["text"]+helperLine[1][1]["label"]["text"]}) dan sejajar dengan garis ${in2} (garis ${helperLine[2][0]["label"]["text"]+helperLine[2][1]["label"]["text"]}) dan kedua garis bantu saling berpotongan. Sudut antara garis ${in1} dan ${in2} sama dengan sudut antara garis ${helperLine[1][0]["label"]["text"]+helperLine[1][1]["label"]["text"]} dan garis ${helperLine[2][0]["label"]["text"]+helperLine[2][1]["label"]["text"]}.`
				]
			), sceneManager, meshes.slice());
		}

		trigPoints.sort();
		trigPoints = {
			name: trigPoints[0] + trigPoints[2] + trigPoints[4]
		};
		trigPoints["points"] = strToPoints(trigPoints["name"], shape, drawL, drawW, drawH);
		for (let i = 0; i < trigPoints["name"].length && trigPoints.length > 2; i++) {
			if (trigPoints["name"][i] != helperLine[0][0]["label"]["text"] && trigPoints["name"][i] != helperLine[0][1]["label"]["text"]) {
				trigPoints["mainPoint"] = trigPoints["points"][i];
				trigPoints["points"].splice(i, 1);
			}
		}

		meshes.length = 0;

		meshes.push(new MyPoint(helper1PointMaterial, helperLine[0][0]["point"][0]));
		meshes.push(new MyLabel(helperLine[0][0]["label"]));
		meshes.push(new MyPoint(helper1PointMaterial, helperLine[0][0]["point"][1]));
		meshes.push(new MyLabel(helperLine[0][1]["label"]));
		meshes.push(new MyLine(helper1LineMaterial, helperLine[0][0]["point"]));

		addSolutionStep(content, makePageContent(
			"panel_content",
			"fa-pencil-square-o",
			`Cara Pengerjaan`,
			"",
			[
				`Lengkapi dengan garis bantu ${helperLine[0][0]["label"]["text"]+helperLine[0][1]["label"]["text"]} sehingga terbentuk segitiga ${trigPoints["name"]}.`
			]
		), sceneManager, meshes.slice());

		const triangleSides = [
			myDist(trigPoints["mainPoint"]["point"], trigPoints["points"][0]["point"]),
			myDist(trigPoints["mainPoint"]["point"], trigPoints["points"][1]["point"]),
			myDist(trigPoints["points"][0]["point"], trigPoints["points"][1]["point"])
		]
		type = 0;

		{
			if (triangleSides[0].equals(triangleSides[1]) && triangleSides[2].equals(triangleSides[1])) {
				type = 1
			} else {
				const a = triangleSides[0].squared(),
					b = triangleSides[1].squared(),
					c = triangleSides[2].squared();
				if (new FracHelper(
						a.a * b.b + b.a * a.b,
						a.b * b.b
					).equals(c)) {
					type = 2;
				} else if (new FracHelper(
						a.a * c.b + c.a * a.b,
						a.b * c.b
					).equals(b)) {
					type = 3;
				} else if (new FracHelper(
						c.a * b.b + b.a * c.b,
						c.b * b.b
					).equals(a)) {
					type = 4;
				}
			}
			// triangleSides[0]
		}

		let lineNames = [
			trigPoints["mainPoint"]["label"]["text"] + trigPoints["points"][0]["label"]["text"],
			trigPoints["mainPoint"]["label"]["text"] + trigPoints["points"][1]["label"]["text"],
			trigPoints["points"][0]["label"]["text"] + trigPoints["points"][1]["label"]["text"]
		]
		addSolutionStep(content, makePageContent(
			"panel_content",
			"fa-pencil-square-o",
			`Cara Pengerjaan`,
			"",
			[
				`Untuk menghitung sudut antara ${lineNames[0]} dan ${lineNames[1]}, pertama-tama tentukan dahulu jenis segitiga ${trigPoints["name"]}, apakah segitiga siku-siku, segitiga sama sisi, atau segitiga lain.`,
				`Jenis segitiga dapat ditentukan dari memperhatikan bentuk segitiga (putar kamera hingga bentuk segitiga terlihat jelas), atau dengan cara menghitung panjang garis ${lineNames[0]}, ${lineNames[1]}, dan ${lineNames[2]}. Panjang ketiganya dapat diperoleh dengan cara menghitung <a target="_blank" href="/jtt.php?in1=${lineNames[0][0]}&in2=${lineNames[0][1]}&shape=${shape}&l=${l}&w=${w}&h=${h}">jarak titik ${lineNames[0][0]} ke ${lineNames[0][1]}</a>, <a target="_blank" href="/jtt.php?in1=${lineNames[1][0]}&in2=${lineNames[1][1]}&shape=${shape}&l=${l}&w=${w}&h=${h}">jarak titik ${lineNames[1][0]} ke ${lineNames[1][1]}</a>, dan <a target="_blank" href="/jtt.php?in1=${lineNames[2][0]}&in2=${lineNames[2][1]}&shape=${shape}&l=${l}&w=${w}&h=${h}">jarak titik ${lineNames[2][0]} ke ${lineNames[2][1]}</a> (klik link untuk penjelasan cara menghitung jarak masing-masing garis).`
			]
		), sceneManager);

		//type
		//0 => kasus lain
		//1 => sama sisi
		//2 => siku2 di mainpoint
		//3 => siku2 di point 0
		//4 => siku2 di point 1

		const paragraphs = [
			`\\( ${lineNames[0]} = ${triangleSides[0]} cm \\)`,
			`\\( ${lineNames[1]} = ${triangleSides[1]} cm \\)`,
			`\\( ${lineNames[2]} = ${triangleSides[2]} cm \\)`,
		];

		if (type == 1) {
			paragraphs.push(
				`Segitiga ${trigPoints["name"]} adalah segitiga sama sisi`,
				`\\( \\therefore \\theta = 60^\\circ \\)`,
			);
			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"",
				paragraphs
			), sceneManager);
		} else if (type == 2) {
			paragraphs.push(
				`Segitiga ${trigPoints["name"]} adalah segitiga siku-siku dengan sudut siku-siku di ${trigPoints["mainPoint"]["label"]["text"]}`,
				`\\( \\therefore \\theta = 90^\\circ \\)`,
			);
			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"",
				paragraphs
			), sceneManager);
		} else if (type == 0) {
			let temp = [new SqrtFracHelper(
				new SqrtHelper(
					2 * triangleSides[0].a.a * triangleSides[1].a.a,
					triangleSides[0].a.b * triangleSides[1].a.b
				),
				new SqrtHelper(
					triangleSides[0].b.a * triangleSides[1].b.a,
					triangleSides[0].b.b * triangleSides[1].b.b
				)
			), triangleSides[0].squared(), triangleSides[1].squared(), triangleSides[2].squared()];
			temp.push(
				new FracHelper(
					temp[1].a * temp[2].b * temp[3].b + temp[1].b * temp[2].a * temp[3].b - temp[1].b * temp[2].b * temp[3].a,
					temp[1].b * temp[2].b * temp[3].b
				)
			);
			temp.push(new SqrtFracHelper(
				new SqrtHelper(
					temp[4].a * temp[0].b.a, temp[0].b.b
				),
				new SqrtHelper(
					temp[4].b * temp[0].a.a, temp[0].a.b
				),
			));
			const paragraphs = [
				`Gunakan aturan cosinus untuk menentukan nilai cosinus \\( \\angle${trigPoints["mainPoint"]["label"]["text"]} \\):`,
				`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{(${lineNames[0]})^2 + (${lineNames[1]})^2 - (${lineNames[2]})^2}{2(${lineNames[0]})(${lineNames[1]})} \\)`,
				`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{(${triangleSides[0]})^2 + (${triangleSides[1]})^2 - (${triangleSides[2]})^2}{2(${triangleSides[0]})(${triangleSides[1]})} \\)`,
				`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${triangleSides[0].squared()} + ${triangleSides[1].squared()} - ${triangleSides[2].squared()}}{${temp[0]}} \\)`,
				`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${triangleSides[0].squared()} + ${triangleSides[1].squared()} - ${triangleSides[2].squared()}}{${temp[0]}} \\)`,
			]
			if (`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[4]}}{${temp[0]}} \\)` != `\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[5]} \\)`) {
				paragraphs.push(`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[4]}}{${temp[0]}} \\)`);
			}
			paragraphs.push(`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[5]}\\)`);
			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"Kasus lain",
				paragraphs.slice()
			), sceneManager);

			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"Kasus lain",
				[
					`Gunakan persamaan dasar trigonometri untuk mendapatkan nilai fungsi trigonometri yang lainnya`,
					`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{depan}{miring}\\)`,
					`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{samping}{miring}\\)`,
					`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{depan}{samping}\\)`,
					`Untuk mempersingkat, akan digunakan notasi berikut:`,
					`\\( depan \\rightarrow y, samping \\rightarrow x, miring \\rightarrow r\\)`,
				]
			), sceneManager);

			temp = [
				temp[5].a, temp[5].b,
				temp[5].a.squared(), temp[5].b.squared(),
				new SqrtHelper(temp[5].b.squared() - temp[5].a.squared())
			]
			temp.push(
				new SqrtFracHelper(
					temp[4], temp[1]
				),
				new SqrtFracHelper(
					temp[4], temp[0]
				)
			)
			paragraphs.length = 0;
			paragraphs.push(
				`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{x}{r}\\)`,
				`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[0]}}{${temp[1]}}\\)`,
				`\\( \\therefore x = ${temp[0]}, r = ${temp[1]}\\)`,
				`\\( y = \\sqrt{r^2 - x^2} \\)`,
				`\\( y = \\sqrt{(${temp[1]})^2 - (${temp[0]})^2} \\)`,
				`\\( y = \\sqrt{${temp[3]} - ${temp[2]}} \\)`,
			);

			if (`\\( y = \\sqrt{${temp[3] - temp[2]}} \\)` != `\\( y = ${temp[4]} \\)`) {
				paragraphs.push(`\\( y = \\sqrt{${temp[3] - temp[2]}} \\)`);
			}
			paragraphs.push(
				`\\( y = ${temp[4]} \\)`,
				`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{y}{r}\\)`,
			);

			if (`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[4]}}{${temp[1]}} \\)` != `\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[5]} \\)`) {
				paragraphs.push(`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[4]}}{${temp[1]}} \\)`);
			}
			paragraphs.push(
				`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[5]} \\)`,
				`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{y}{r}\\)`,
			);

			if (`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[4]}}{${temp[0]}} \\)` != `\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[6]} \\)`) {
				paragraphs.push(`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${temp[4]}}{${temp[0]}} \\)`);
			}
			paragraphs.push(
				`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[6]} \\)`,
				`\\( \\angle${trigPoints["mainPoint"]["label"]["text"]} = ${myRound(Math.atan2(temp[4].a * Math.sqrt(temp[4].b), temp[0].a * Math.sqrt(temp[0].b)))}^\\circ \\)`
			);

			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"Kasus lain",
				paragraphs
			), sceneManager);
		} else {
			let sa = null,
				de = null,
				mi = null;

			if (type == 3) {
				de = 2;
				sa = 0;
				mi = 1;
			} else {
				de = 1;
				sa = 2;
				mi = 0;
			}

			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"Segitiga siku-siku",
				[
					`Gunakan rumus dasar trigonometri:`,
					`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{depan}{miring}\\)`,
					`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${lineNames[de]}}{${lineNames[mi]}} \\)`,
					`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{samping}{miring}\\)`,
					`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${lineNames[sa]}}{${lineNames[mi]}} \\)`,
					`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{depan}{samping}\\)`
					`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${lineNames[de]}}{${lineNames[sa]}} \\)`
				]
			), sceneManager);

			let temp = [
				new SqrtFracHelper(
					new SqrtHelper(
						triangleSides[de].a.a * triangleSides[mi].b.a,
						triangleSides[de].a.b * triangleSides[mi].b.b
					),
					new SqrtHelper(
						triangleSides[de].b.a * triangleSides[mi].a.a,
						triangleSides[de].b.b * triangleSides[mi].a.b
					),
				),
				new SqrtFracHelper(
					new SqrtHelper(
						triangleSides[sa].a.a * triangleSides[mi].b.a,
						triangleSides[sa].a.b * triangleSides[mi].b.b
					),
					new SqrtHelper(
						triangleSides[sa].b.a * triangleSides[mi].a.a,
						triangleSides[sa].b.b * triangleSides[mi].a.b
					),
				),
				new SqrtFracHelper(
					new SqrtHelper(
						triangleSides[de].a.a * triangleSides[sa].b.a,
						triangleSides[de].a.b * triangleSides[sa].b.b
					),
					new SqrtHelper(
						triangleSides[de].b.a * triangleSides[sa].a.a,
						triangleSides[de].b.b * triangleSides[sa].a.b
					),
				)
			]
			temp.push(Math.atan2(temp[2].a.a * Math.sqrt(temp[2].a.b), temp[2].b.a * Math.sqrt(temp[2].b.b)))
			addSolutionStep(content, makePageContent(
				"panel_content",
				"fa-pencil-square-o",
				`Cara Pengerjaan`,
				"Segitiga siku-siku",
				[
					`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${triangleSides[de]}}{${triangleSides[mi]}} \\)`,
					`\\( \\sin(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[0]}\\)`,
					`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${triangleSides[sa]}}{${triangleSides[mi]}} \\)`,
					`\\( \\cos(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[1]}\\)`,
					`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = \\frac{${triangleSides[de]}}{${triangleSides[sa]}} \\)`,
					`\\( \\tan(${trigPoints["mainPoint"]["label"]["text"]}) = ${temp[2]}\\)`
					`\\( \\angle${trigPoints["mainPoint"]["label"]["text"]} = ${myRound(temp[3])}^\\circ \\)`
				]
			), sceneManager);
		}
	}
	loadPageContent(content);
</script>