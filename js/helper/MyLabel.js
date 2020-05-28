class MyLabel extends MyGeom {
    constructor(obj = {}) {
        super(mainLabelMaterial, null, mainLabelGeometry);
        const pts = new THREE.Vector3(0, 0, 0);
        if (obj["x"]) {
            pts.x = obj["x"];
        }
        if (obj["y"]) {
            pts.y = obj["y"];
        }
        if (obj["z"]) {
            pts.z = obj["z"];
        }
        if (obj["text"]) {
            this.text = obj["text"];
        }
        else{
            this.text = "";
        }
        if (obj["color"]) {
            this.color = obj["color"];
        }
        else{
            this.color = '#0000ff';
        }
        const mesh = new THREE.TextSprite({
            fillStyle: this.color,
            fontFamily: '"Courier New", monospace',
            fontSize: 0.1,
            text: this.text,
        });
        mesh.position.x = pts.x;
        mesh.position.y = pts.y;
        mesh.position.z = pts.z;
        this.mesh.add(mesh);
    }
}