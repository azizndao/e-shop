<form method="post" class="form__update__profile">
    <h1>Changer de mot de passe</h1>
    <input type="hidden" name="action" value="update-password">
    <div class="form-group">
        <label for="password">Mot de passe actuel</label>
        <input type="password" autocomplete="password" name="password" id="password" value="<?= $data['password'] ?? '' ?>">
        <?php if (!empty($errors['password'])) : ?>
            <small class="input-error">
                <?= $errors['password'] ?>
            </small>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="new-password">Votre nouveau mot de passe</label>
        <input type="password" autocomplete="new-password" name="new-password" id="new-password" placeholder="poulo@dierri.sn" value="<?= $data['new-password'] ?? '' ?>">
        <?php if (!empty($errors['new-password'])) : ?>
            <small class="input-error">
                <?= $errors['new-password'] ?>
            </small>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="password-confirmation">Comfirmer le mot de passe</label>
        <input type="password" autocomplete="new-confirmation" name="password-confirmation" id="password-confirmation" placeholder="poulo@dierri.sn" value="<?= $data['password-confirmation'] ?? '' ?>">
        <?php if (!empty($errors['password-confirmation'])) : ?>
            <small class="input-error">
                <?= $errors['password-confirmation'] ?>
            </small>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Sauvegarder</button>
</form>