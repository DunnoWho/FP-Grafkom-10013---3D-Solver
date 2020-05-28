class MyPoint extends MyGeom {
    constructor(meshMaterial, obj = {}) {
        super(meshMaterial, null);
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
        const mesh = new THREE.Mesh(this.pointGeometry, this.meshMaterial);
        mesh.position.x = pts.x;
        mesh.position.y = pts.y;
        mesh.position.z = pts.z;
        this.mesh.add(mesh);
    }
}