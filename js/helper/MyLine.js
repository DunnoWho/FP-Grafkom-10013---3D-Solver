class MyLine extends MyGeom {
    constructor(lineMaterial, obj) {
        super(null, lineMaterial);
        const pts = [new THREE.Vector3(0, 0, 0), new THREE.Vector3(0, 0, 0)];
        pts[0].x = obj[0].x;
        pts[0].y = obj[0].y;
        pts[0].z = obj[0].z;
        pts[1].x = obj[1].x;
        pts[1].y = obj[1].y;
        pts[1].z = obj[1].z;
        const line = new THREE.Line(new THREE.BufferGeometry().setFromPoints(pts), this.lineMaterial);
        line.computeLineDistances();
        this.mesh.add(line);
    }
}