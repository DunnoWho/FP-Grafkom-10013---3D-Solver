class MyPlane extends MyGeom {
    constructor(meshMaterial, pts) {
        super(meshMaterial, null);
        this.geometry = new THREE.Geometry();
        for (let i = 0; i < pts.length; i++) {
            this.geometry.vertices.push(new THREE.Vector3(pts[i]["x"], pts[i]["y"], pts[i]["z"]));
        }

        this.geometry.faces.push(new THREE.Face3(0, 1, 2));
        if(pts.length == 4){
            this.geometry.faces.push(new THREE.Face3(0, 2, 3));
        }

        const mesh = new THREE.Mesh(this.geometry, this.meshMaterial);
        this.mesh.add(mesh);
    }
}