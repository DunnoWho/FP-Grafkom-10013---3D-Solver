<div class="panel">
    <header class="panel__header">
        <h2 class="panel__title"><?= $data["panelTitle"] ?></h2>
        <p class="panel__subheading"><?= $data["panelSubtitle"] ?></p>
    </header>

    <?php
    foreach ($data["panelContent"] as $i) {
        ?>
        <p class="panel__content"><?= $i ?></p>
        <?php
    }
    ?>
</div>