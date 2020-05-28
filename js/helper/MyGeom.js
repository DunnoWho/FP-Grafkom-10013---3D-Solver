const mainPointGeometry = new THREE.SphereBufferGeometry(0.02, 8, 8);
const mainLabelGeometry = new THREE.SphereBufferGeometry(0.0001, 8, 8);
const mainPointMaterial = new THREE.MeshBasicMaterial({color : 0x000000});
const mainLabelMaterial = new THREE.MeshBasicMaterial({color : 0xffffff});
const mainLineMaterial = new THREE.LineBasicMaterial({color : 0x000000});
const probPointMaterial = new THREE.MeshBasicMaterial({color : 0x0000ff});
const probPlaneMaterial = new THREE.MeshBasicMaterial({color : 0x0000ff, side : THREE.DoubleSide, opacity: 0.5, transparent: true});
const probLineMaterial = new THREE.LineBasicMaterial({color : 0x0000ff});
const probExtraLineMaterial = new THREE.LineDashedMaterial({color : 0x9f9f9f, dashSize: 0.1, gapSize: 0.05});
const helper1PointMaterial = new THREE.MeshBasicMaterial({color : 0x00ff00});
const helper1PlaneMaterial = new THREE.MeshBasicMaterial({color : 0x00ff00, side : THREE.DoubleSide, opacity: 0.5, transparent: true});
const helper1LineMaterial = new THREE.LineDashedMaterial({color : 0x00ff00, dashSize: 0.1, gapSize: 0.05});
const helper2PointMaterial = new THREE.MeshBasicMaterial({color : 0xff0000});
const helper2PlaneMaterial = new THREE.MeshBasicMaterial({color : 0xff0000, side : THREE.DoubleSide, opacity: 0.5, transparent: true});
const helper2LineMaterial = new THREE.LineDashedMaterial({color : 0xff0000, dashSize: 0.1, gapSize: 0.05});
// const probLineMaterial = new THREE.LineBasicMaterial({color : 0x0000ff});
class MyGeom{
    constructor(meshMaterial, lineMaterial, pointGeometry=mainPointGeometry){
        this.mesh = new THREE.Object3D();
        this.pointGeometry = pointGeometry;
        this.meshMaterial = meshMaterial;
        this.lineMaterial = lineMaterial;
    }
}