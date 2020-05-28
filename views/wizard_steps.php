<div class="step">
    <div class="step__content">
        <p class="step__number"><i class="fa <?= $data["icon"] ?>" style="line-height:inherit;"></i></p>
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>

        <div class="lines">
            <?php
            if ($data["first"]) {
            ?>
                <div class="line -start">
                </div>
            <?php
            }
            ?>

            <div class="line -background">
            </div>

            <div class="line -progress">
            </div>
        </div>
    </div>
</div>