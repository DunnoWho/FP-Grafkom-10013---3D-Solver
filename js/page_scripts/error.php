<script>
    sceneManager.setMainGeom(new MyBox(mainPointMaterial, mainLineMaterial));
    loadPageContent([
        makePageContent("panel_content", "fa-times", "Error", "<?= $data["msg"]?>", [])
    ]);
</script>