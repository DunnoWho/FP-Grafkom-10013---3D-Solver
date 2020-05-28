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

function generateElements(shape, l, w, h) {
    const points = [],
        lines = [],
        planes = [];
    let bp = null,
        shapePoints = null;
    if (shape == 0) {
        bp = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split("");
        shapePoints = boxPoints;
    } else if (shape == 1) {
        bp = "abcdefghijklmt".toUpperCase().split("");
        shapePoints = pyramidPoints;
    } else {
        return false;
    }

    const bl = [];
    bp.forEach(e => {
        points.push({
            vec: new THREE.Vector3(shapePoints[e]["point"].x(l), shapePoints[e]["point"].y(h), shapePoints[e]["point"].z(w)),
            name: e
        });
    });
    for (let i = 0; i < points.length; i++) {
        const e = points[i];
        for (let j = i + 1; j < points.length; j++) {
            const ee = points[j];
            bl.push(e["name"] + ee["name"]);
            lines.push({
                name: e["name"] + ee["name"],
                points: [e["vec"], ee["vec"]],
                vec: new THREE.Vector3().subVectors(e["vec"], ee["vec"])
            });
        }
    }
    let bpl = null,
        discard = null;
    if (shape == 0) {
        bpl = [
            "abcd", "mnop", "efgh",
            "adhe", "iksq", "bcgf",
            "adgf", "bche", "abgh", "cdef",
            "adon", "adsq", "bcpm", "bcsq",
            "fgpm", "fgki", "ehon", "ehki",
            "abop", "abrt", "cdmn", "cdtr",
            "ghmn", "ghlj", "efop", "efjl",
            "iltq", "jksr", "ijrq", "klts",
            "ilsr", "jktq", "ijst", "klqr",
            "jlmn", "optr", "jlpo", "mnrt",
            "jntp", "lorm", "jotm", "lnrp"
        ];
        discard = ["abi", "bcj", "cdk", "adl",
            "mnv", "now", "opx", "pmy",
            "efq", "fgr", "ghs", "eht",
            "aem", "eht", "dhp", "adl",
            "iqv", "qsz", "ksx", "iku",
            "bfn", "fgr", "cgo", "bcj"
        ];
    } else if (shape == 1) {
        bpl = [
            "abcd", "ijkl",
            "bcli", "egli", "adkj", "egkj",
            "cdij", "fhij", "abkl", "fhlk",
            "efki", "ghik", "ehlj", "fglj",
        ];
        discard = [
            "abe", "bcf", "cdg", "adh",
            "ait", "bjt", "ckt", "dlt"
        ];
    }

    discard.forEach(e => {
        if (bpl.indexOf(e.toUpperCase()) >= 0) {
            bpl.splice(bpl.indexOf(e.toUpperCase()), 1);
        }
    });

    for (let i = 0; i < bpl.length; i++) {
        const e = bpl[i];
        const pts = strToPoints(e.toUpperCase(), shape, l, w, h);
        planes.push({
            name: e,
            plane: new THREE.Plane(pts[0]["point"], pts[1]["point"], pts[2]["point"])
        })
    }
    return [points, lines, planes];
}

function validCheck(input, n, col) {
    if (n == 1) {
        if (input.length != 1) {
            return false;
        }
        for (let i = 0; i < col.length; i++) {
            if (col[i]["name"] == input) {
                return true;
            }
        }
    } else if (n == 2) {
        if (input.length != 2) {
            return false;
        }
        for (let i = 0; i < col.length; i++) {
            if (col[i]["name"] == input || col[i]["name"] == input[1] + input[0]) {
                return true;
            }
        }
    } else if (n == 3) {
        if (input.length == 3) {
            for (let i = 0; i < col.length; i++) {
                if (col[i]["name"].length == input.length && [
                        input[0] + input[1] + input[2],
                        input[0] + input[2] + input[1],
                        input[1] + input[0] + input[2],
                        input[1] + input[2] + input[0],
                        input[2] + input[0] + input[1],
                        input[2] + input[1] + input[0]
                    ].indexOf(col[i]["name"]) >= 0) {
                    return true;
                }
            }
        } else if (input.length == 4) {
            for (let i = 0; i < col.length; i++) {
                if (col[i]["name"].length == input.length && [
                        input[0] + input[1] + input[2] + input[3],
                        input[1] + input[2] + input[3] + input[0],
                        input[2] + input[3] + input[0] + input[1],
                        input[3] + input[0] + input[1] + input[2]
                    ].indexOf(col[i]["name"]) >= 0) {
                    return true;
                }
            }
        }
        return false;
    }
}

function myRound(x) {
    return Math.round((x + Number.EPSILON) * 100) / 100;
}

// const pyramidSpecialPlanes = [
//     "abcd", "ijkl",
//     "abt", "bct", "cdt", "adt",
//     "act", "bdt", "fht", "egt",
//     "eht", "fgt", "eft", "ght",
//     "bcli", "egli", "adkj", "egkj",
//     "cdij", "fhij", "abkl", "fhlk",
//     "efki", "ghik", "ehlj", "fglj",
//     "efj", "fgk", "ghl", "ehi",
// ];