<?= $this->extend('Rudi\App\Views\auth\layout'); ?>
<?= $this->section('auth'); ?>

<div class="form-label-group <?= (old('username'))? "was-validated":"" ?>">
    <input type="text" id="inpName" name="username"
        class="form-control <?= $validation->getError('username')? "is-invalid":"" ?>" value="<?= old('username') ?>"
        placeholder="Full Name">
    <label for="inpName">Full Name</label>
    <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
</div>
<div class="form-label-group <?= (old('email'))? "was-validated":"" ?>">
    <input type="email" id="inpEmail" name="email"
        class="form-control <?= ($validation->getError('email'))? "is-invalid":"" ?>" value="<?= old('email') ?>"
        placeholder="Email address">
    <label for="inpEmail">Email address</label>
    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
</div>

<div class="form-label-group <?= (old('password'))? "was-validated":"" ?>">
    <input type="password" id="inpPassword" name="password"
        class="form-control <?= ($validation->getError('password'))? "is-invalid":"" ?>" placeholder="Password">
    <label for="inpPassword">Password</label>
    <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
</div>

<div class="form-label-group">
    <input type="password" id="inpPassConf" name="password_confirmation"
        class="form-control <?= ($validation->getError('password_confirmation'))? "is-invalid":"" ?>"
        placeholder="Password Confirm">
    <label for="inpPassConf">Password Confirm</label>
    <div class="invalid-feedback"><?= $validation->getError('password_confirmation') ?></div>
</div>

<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
<div class="mt-3 mb-3">
    <a href="login">Login</a>
</div>
<?= $this->endSection(); ?>