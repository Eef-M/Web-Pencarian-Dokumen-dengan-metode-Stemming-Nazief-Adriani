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
                                    <h1 class="mb-2"><span class="badge"
                                            style="background-color: #242F9B; color: white;"><b>PENCARIAN
                                                DOKUMEN</b></span></h1>
                                    <hr class="mb-2 text-primary" style="border-radius: 10px; height: 5px;">
                                    <h3 class="mb-4" style="color: #242F9B;"><b>Ganti Password</b></h3>
                                    <h5 class=" mb-4"><?= $this->session->userdata('reset_email') ?></h5>
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form class="user" method="post" action="<?= base_url('auth/changepassword') ?>">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1"
                                            name="password1" placeholder="Enter new password ...">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2"
                                            name="password2" placeholder="Repeat password ...">
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button class="btn btn-user btn-block"
                                        style="background-color: #242F9B; color: white;" type="submit">
                                        Ganti Password
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>