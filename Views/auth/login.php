<?= $this->extend('Rudi\App\Views\auth\layout'); ?>
<?= $this->section('auth'); ?>

<div class="form-label-group <?= (old('email'))? "was-validated":"" ?>">
    <input type="email" id="inpEmail" name="email"
        class="form-control <?= ($validation->getError('email'))? "is-invalid":"" ?>" value="<?= old('email') ?>"
        placeholder="Email address">
    <label for="inpEmail">Email address</label>
    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
</div>

<div class="form-label-group">
    <input type="password" id="inpPassword" name="password"
        class="form-control <?= ($validation->getError('password'))? "is-invalid":"" ?>" placeholder="Password">
    <label for="inpPassword">Password</label>
    <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
</div>

<div class="checkbox mb-3">
    <label>
        <input type="checkbox" value="remember-me"> Remember me
    </label>
</div>

<button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>
<div class="mt-3 mb-3">
    <a href="register">Register</a>
</div>

<?= $this->endSection(); ?>