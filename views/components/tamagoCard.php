<div class="tamago-card">
    <div class="tamago-card-body">
        <?php if ($isDead): ?>
            <p class="tamago-card-text">Ici repose: <?= htmlspecialchars($tamago->name) ?></p>
            <p class="tamago-card-text">Niveau: <?= htmlspecialchars($tamago->niveaux) ?></p>
            <p class="tamago-card-text">Né le: <?= htmlspecialchars($tamago->born_at) ?></p>
            <p class="tamago-card-text">Mort le: <?= htmlspecialchars($tamago->died_at) ?></p>
        <?php else: ?>
            <p class="tamago-card-text">Nom: <?= htmlspecialchars($tamago->name) ?></p>
            <p class="tamago-card-text">Niveau: <?= htmlspecialchars($tamago->niveaux) ?></p>
            <p class="tamago-card-text">Faim: <?= htmlspecialchars($tamago->faim) ?></p>
            <p class="tamago-card-text">Soif: <?= htmlspecialchars($tamago->soif) ?></p>
            <p class="tamago-card-text">Ennui: <?= htmlspecialchars($tamago->ennui) ?></p>
            <p class="tamago-card-text">Sommeil: <?= htmlspecialchars($tamago->sommeil) ?></p>
            <p class="tamago-card-text">État: <?= htmlspecialchars($tamago->etat) ?></p>
            <p class="tamago-card-text">Actions: <?= htmlspecialchars($tamago->actions) ?></p>

            <div class="tamago-actions">
                <a href="../controllers/actions/eat.php?tamago_id=<?= urlencode($tamago->id) ?>&username=<?= urlencode($username) ?>">
                    <button class="button-14">Manger</button>
                </a>
                <a href="../controllers/actions/drink.php?tamago_id=<?= urlencode($tamago->id) ?>&username=<?= urlencode($username) ?>">
                    <button class="button-14">Boire</button>
                </a>
                <a href="../controllers/actions/sleep.php?tamago_id=<?= urlencode($tamago->id) ?>&username=<?= urlencode($username) ?>">
                    <button class="button-14">Dormir</button>
                </a>
                <a href="../controllers/actions/play.php?tamago_id=<?= urlencode($tamago->id) ?>&username=<?= urlencode($username) ?>">
                    <button class="button-14">Jouer</button>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
