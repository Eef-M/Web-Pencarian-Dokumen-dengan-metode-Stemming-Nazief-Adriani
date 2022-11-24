<style>
#logo {
    max-width: 70%;
    height: auto;
    margin-bottom: 4px;
}
</style>
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <img src="<?= base_url('assets/img/uad.webp') ?>" id='logo'>
                            <h2 class="my-2"><span class="badge"
                                    style="background-color: #242F9B; color: white;"><b>PENCARIAN
                                        DOKUMEN</b></span></h2>
                            <hr class="mb-2 text-primary" style="border-radius: 10px; height: 5px;">
                            <h3 class="mb-4" style="color: #242F9B;"><b>Pendaftaran Akun</b></h3>
                        </div>
                        <form class="user" method="post" action="<?= base_url('auth/registration') ?>">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="name"
                                    placeholder="Full Name" name="name" value="<?= set_value('name') ?>">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email"
                                    placeholder="Email Address" name="email" value="<?= set_value('email') ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="password1"
                                        name="password1" placeholder="Password">
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password2"
                                        name="password2" placeholder="Repeat Password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-user btn-block"
                                style="background-color: #242F9B; color: white;">
                                Daftar Akun
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth/forgotpassword') ?>">Lupa Password ?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth') ?>">Sudah punya akun ? Silahkan Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>