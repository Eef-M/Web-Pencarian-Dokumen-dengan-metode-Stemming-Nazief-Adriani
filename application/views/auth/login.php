<style>
#logo {
    max-width: 70%;
    height: auto;
    margin-bottom: 4px;
}
</style>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
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
                                    <h3 class="mb-4" style="color: #242F9B;"><b>LOGIN</b></h3>
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form class="user" method="post" action="<?= base_url('auth') ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email"
                                            name="email" placeholder="Enter Email Address..."
                                            value="<?= set_value('email') ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password"
                                            name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button class="btn btn-user btn-block"
                                        style="background-color: #242F9B; color: white;" type="submit">
                                        <b>Masuk</b>
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword') ?>">Lupa Password ?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/registration') ?>">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>