class MyPyramid extends MySolid{
    constructor(meshMaterial, lineMaterial, length=1, width=1, height=1){
        super(meshMaterial, lineMaterial);
        const pts = [
            new THREE.Vector3(-0.5 * length, -0.5 * height, 0.5 * width),
            new THREE.Vector3(0.5 * length, -0.5 * height, 0.5 * width),
            new THREE.Vector3(0.5 * length, -0.5 * height, -0.5 * width),
            new THREE.Vector3(-0.5 * length, -0.5 * height, -0.5 * width),
            new THREE.Vector3(0, 0.5 * height, 0),
        ];

        const lines = [
            [pts[0].clone(), pts[1].clone()],
            [pts[1].clone(), pts[2].clone()],
            [pts[2].clone(), pts[3].clone()],
            [pts[3].clone(), pts[0].clone()],
            [pts[0].clone(), pts[4].clone()],
            [pts[1].clone(), pts[4].clone()],
            [pts[2].clone(), pts[4].clone()],
            [pts[3].clone(), pts[4].clone()]
        ];

        for(let i = 0; i < pts.length; i++){
            const mesh = new THREE.Mesh(this.pointGeometry, this.meshMaterial);
            mesh.position.x = pts[i].x;
            mesh.position.y = pts[i].y;
            mesh.position.z = pts[i].z;
            this.mesh.add(mesh);
        }
    
        for(let i = 0; i < lines.length; i++){
            const line = new THREE.Line(new THREE.BufferGeometry().setFromPoints(lines[i]), this.lineMaterial);
            line.computeLineDistances();
            this.mesh.add(line);
        }
    }
}