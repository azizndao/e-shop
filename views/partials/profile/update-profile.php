<form action="/profile" method="post" class="form__update__profile">
    <h1>Votre profile</h1>
    <input type="hidden" name="action" value="update-profile">
    <section class="name">
        <div class="form-group">
            <label for="first-name">Prenom</label>
            <input type="text" autocomplete="given-name" name="first_name" id="first-name" placeholder="Poulo" value="<?= $user->first_name ?? '' ?>">
            <?php if (!empty($errors['first_name'])) : ?>
                <small class="input-error">
                    <?= $errors['first_name'] ?>
                </small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="last-name">Nom de famille</label>
            <input type="text" autocomplete="family-name" name="last_name" id="last-name" placeholder="Dierri" value="<?= $user->last_name ?? '' ?>" aria-errormessage="<?= $errors['last_name'] ?>">
            <?php if (!empty($errors['last_name'])) : ?>
                <small class="input-error">
                    <?= $errors['last_name'] ?>
                </small>
            <?php endif; ?>
        </div>
    </section>
    <div class="form-group">
        <label for="birthday">Date de naissance</label>
        <input type="date" autocomplete="birthday" name="birthday" id="birthday" value="<?= $user->birthday ?? '' ?>">
        <?php if (!empty($errors['birthday'])) : ?>
            <small class="input-error">
                <?= $errors['birthday'] ?>
            </small>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="email">Votre email</label>
        <input type="email" autocomplete="email" name="email" id="email" placeholder="poulo@dierri.sn" value="<?= $user->email ?? '' ?>">
        <?php if (!empty($errors['email'])) : ?>
            <small class="input-error">
                <?= $errors['email'] ?>
            </small>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="mobile">Votre telephone</label>
        <input type="number" autocomplete="mobile" name="mobile" id="mobile" value="<?= $user->mobile ?? '' ?>" placeholder="Ex: +221 77 622 62 32">
        <?php if (!empty($errors['mobile'])) : ?>
            <small class="input-error">
                <?= $errors['mobile'] ?>
            </small>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Sauvegarder</button>
</form>