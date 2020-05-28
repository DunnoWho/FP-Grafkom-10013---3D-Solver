<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/101bd9e574.js" crossorigin="anonymous"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-svg.js"></script>
    <script src="../js/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <div id="wizard" class="wizard">
            <div class="wizard__content">
                <header class="wizard__header">
                    <div class="wizard__header-overlay"><canvas id="canvas"></canvas></div>

                    <div class="wizard__header-content">
                    </div>

                    <div class="wizard__steps">
                        <nav class="steps" id="nav-steps">

                        </nav>
                    </div>
                </header>


                <div class="panels" id="div-panels">

                </div>

                <div class="wizard__footer">
                    <button class="button previous" id="backButton">Kembali</button>
                    <button class="button next" id="nextButton">Lanjut</button>
                </div>
            </div>

            <h1 class="wizard__congrats-message">
                Harap tunggu, proses sedang berjalan...
            </h1>
        </div>
    </div>
    <script src="../js/three.js"></script>
    <script src="https://unpkg.com/@seregpie/three.text-texture"></script>
    <script src="https://unpkg.com/@seregpie/three.text-sprite"></script>
    <script src="../js/OrbitControls.js"></script>
    <script src="../js/helper/SceneManager.js"></script>
    <script src="../js/helper/MyGeom.js"></script>
    <script src="../js/helper/MyPoint.js"></script>
    <script src="../js/helper/MyLabel.js"></script>
    <script src="../js/helper/MyLine.js"></script>
    <script src="../js/helper/MyPlane.js"></script>
    <script src="../js/helper/MySolid.js"></script>
    <script src="../js/helper/MyBox.js"></script>
    <script src="../js/helper/MyPyramid.js"></script>
    <script src="../js/myScript.js"></script>
    <script src="../js/helper/MyMathHelper.js"></script>
    <?= $data["pageScript"] ?>
</body>

</html>