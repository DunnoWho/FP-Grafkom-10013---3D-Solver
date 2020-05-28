const sceneManager = new SceneManager(null, null);
let cam = null
let sprite = null

function main() {
    const canvas = document.querySelector('#canvas');
    const renderer = new THREE.WebGLRenderer({
        canvas
    });

    // const ctx = canvas.getContext("2d");
    // ctx.font = "20px Georgia";

    const camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 0.1, 20);
    camera.position.set(1.911, 1.1, 2.555);
    // camera.position.set(0, 3, -3);
    camera.lookAt(0, 0, 0);
    cam = camera;

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xffffff);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.minDistance = 0.5;
    controls.maxDistance = 100;

    sceneManager.scene = scene;
    sceneManager.camera = camera;

    function resizeRendererToDisplaySize(renderer) {
        const canvas = renderer.domElement;
        const width = canvas.clientWidth;
        const height = canvas.clientHeight;
        const needResize = canvas.width !== width || canvas.height !== height;
        if (needResize) {
            renderer.setSize(width, height, false);
        }
        return needResize;
    }

    function toScreenPosition(obj, camera) {
        var vector = new THREE.Vector3();

        var widthHalf = 0.5 * renderer.context.canvas.width;
        var heightHalf = 0.5 * renderer.context.canvas.height;

        obj.updateMatrixWorld();
        vector.setFromMatrixPosition(obj.matrixWorld);
        vector.project(camera);

        vector.x = (vector.x * widthHalf) + widthHalf;
        vector.y = -(vector.y * heightHalf) + heightHalf;

        return {
            x: vector.x,
            y: vector.y
        };

    };

    function render(time) {
        time *= 0.001;

        if (resizeRendererToDisplaySize(renderer)) {
            const canvas = renderer.domElement;
            camera.aspect = canvas.clientWidth / canvas.clientHeight;
            camera.updateProjectionMatrix();
        }

        renderer.render(scene, camera);

        // for (let i = 0; i < sceneManager.activeLabels.length; i++) {
        //     const e = sceneManager.activeLabels[i];
        //     const pos = toScreenPosition(e.mesh, camera);
        //     ctx.fillText(e.text, pos["x"], pos["y"]);
        // }

        requestAnimationFrame(render);
    }

    requestAnimationFrame(render);
}

main();

function loadPageContent(content) {
    $.post("wizard-content-requestor.php", {
            "pageContent": JSON.stringify(content)
        },
        function (data, textStatus, jqXHR) {
            data = JSON.parse(data);
            for (let i = 0; i < data["stepHeader"].length; i++) {
                const d = data["stepHeader"][i];
                $("#nav-steps").append(d);
            }
            for (let i = 0; i < data["stepPanel"].length; i++) {
                const d = data["stepPanel"][i];
                $("#div-panels").append(d);
            }
            eval(data["stepScript"]);
            MathJax.typeset();
        }
    );
}

function makePageContent(url, icon, panelTitle, panelSubtitle, panelContent) {
    return {
        "url": url,
        "icon": icon,
        "panelTitle": panelTitle,
        "panelSubtitle": panelSubtitle,
        "panelContent": panelContent
    }
}

function addSolutionStep(contentArr, content, sceneManager, meshes = [], cameras = null) {
    contentArr.push(content);
    sceneManager.addPage(meshes, cameras);
}

$("#nextButton").click(function () {
    sceneManager.nextPage();
});

$("#backButton").click(function () {
    sceneManager.prevPage();
});

const boxPoints = {
    A: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'A'
        }
    },
    B: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'B'
        }
    },
    C: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'C'
        }
    },
    D: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'D'
        }
    },
    E: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'E'
        }
    },
    F: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'F'
        }
    },
    G: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'G'
        }
    },
    H: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'H'
        }
    },
    I: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'I'
        }
    },
    J: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'J'
        }
    },
    K: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'K'
        }
    },
    L: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'L'
        }
    },
    M: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'M'
        }
    },
    N: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'N'
        }
    },
    O: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'O'
        }
    },
    P: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'P'
        }
    },
    Q: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'Q'
        }
    },
    R: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'R'
        }
    },
    S: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'S'
        }
    },
    T: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'T'
        }
    },
    U: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'U'
        }
    },
    V: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'V'
        }
    },
    W: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'W'
        }
    },
    X: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'X'
        }
    },
    Y: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'Y'
        }
    },
    Z: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'Z'
        }
    }
}

const pyramidPoints = {
    A: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'A'
        }
    },
    B: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'B'
        }
    },
    C: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'C'
        }
    },
    D: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'D'
        }
    },
    T: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return 1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'T'
        }
    },
    E: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 1 * (0.5 * w + 0.05)
            },
            text: 'E'
        }
    },
    F: {
        point: {
            x: (l) => {
                return 1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'F'
        }
    },
    G: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return -1 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -1 * (0.5 * w + 0.05)
            },
            text: 'G'
        }
    },
    H: {
        point: {
            x: (l) => {
                return -1 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -1 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'H'
        }
    },
    I: {
        point: {
            x: (l) => {
                return -0.5 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 0.5 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -0.5 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0.5 * (0.5 * w + 0.05)
            },
            text: 'I'
        }
    },
    J: {
        point: {
            x: (l) => {
                return 0.5 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return 0.5 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0.5 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0.5 * (0.5 * w + 0.05)
            },
            text: 'J'
        }
    },
    K: {
        point: {
            x: (l) => {
                return 0.5 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return -0.5 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0.5 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -0.5 * (0.5 * w + 0.05)
            },
            text: 'K'
        }
    },
    L: {
        point: {
            x: (l) => {
                return -0.5 * 0.5 * l
            },
            y: (h) => {
                return 0 * 0.5 * h
            },
            z: (w) => {
                return -0.5 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return -0.5 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return 0 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return -0.5 * (0.5 * w + 0.05)
            },
            text: 'L'
        }
    },
    M: {
        point: {
            x: (l) => {
                return 0 * 0.5 * l
            },
            y: (h) => {
                return -1 * 0.5 * h
            },
            z: (w) => {
                return 0 * 0.5 * w
            }
        },
        label: {
            x: (l) => {
                return 0 * (0.5 * l + 0.05)
            },
            y: (h) => {
                return -1 * (0.5 * h + 0.05)
            },
            z: (w) => {
                return 0 * (0.5 * w + 0.05)
            },
            text: 'M'
        }
    }
}

function strToPoints(str, shape, l, w, h) {
    if (shape != 0 && shape != 1) {
        return;
    }
    const ret = [];
    let pts = null;
    if (shape == 0) {
        pts = boxPoints;
    } else if (shape == 1) {
        pts = pyramidPoints;
    }
    str = str.split("");
    for (let i = 0; i < str.length; i++) {
        const v = pts[str[i]];
        ret.push({
            point: {
                x: v["point"].x(l),
                y: v["point"].y(h),
                z: v["point"].z(w)
            },
            label: {
                x: v["label"].x(l),
                y: v["label"].y(h),
                z: v["label"].z(w),
                text: v["label"]["text"]
            }
        });
    }
    return ret;
}

function myRound(x) {
    return Math.round((x + Number.EPSILON) * 100) / 100;
}
