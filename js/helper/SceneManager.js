class SceneManager {
    constructor(scene, camera) {
        this.scene = scene;
        this.camera = camera;
        this.mainGeom = null;
        this.meshPageContent = [];
        this.cameraPos = []
        this.meshPage = 0;
    }

    setMainGeom(geom) {
        if (this.mainGeom) {
            this.scene.remove(this.mainGeom.mesh);
        }
        this.mainGeom = geom;
        this.scene.add(this.mainGeom.mesh);
    }

    nextPage() {
        if (this.meshPage + 1 < this.meshPageContent.length) {
            this.meshPage = this.meshPage + 1;
            for (let i = 0; i < this.meshPageContent[this.meshPage].length; i++) {
                this.scene.add(this.meshPageContent[this.meshPage][i].mesh);
            }
            if (this.cameraPos[this.meshPage]) {
                const temp = this.cameraPos[this.meshPage];
                this.camera.position.set(temp["pos"].x, temp["pos"].y, temp["pos"].z);
                this.camera.lookAt(temp["lookAt"]);
            }
        }
    }

    prevPage() {
        if (this.meshPage - 1 >= 0) {
            for (let i = 0; i < this.meshPageContent[this.meshPage].length; i++) {
                this.scene.remove(this.meshPageContent[this.meshPage][i].mesh);
            }
            if (this.cameraPos[this.meshPage]) {
                const temp = this.cameraPos[this.meshPage];
                this.camera.position.set(temp["pos"].x, temp["pos"].y, temp["pos"].z);
                this.camera.lookAt(temp["lookAt"]);
            }
            this.meshPage = this.meshPage - 1;
        }
    }

    addPage(meshes, cameraPos = null) {
        this.meshPageContent.push(meshes);
        if (this.meshPageContent.length == 1) {
            for (let i = 0; i < this.meshPageContent[0].length; i++) {
                this.scene.add(this.meshPageContent[this.meshPage][i].mesh);
            }
        }
        this.cameraPos.push(cameraPos);
    }
}