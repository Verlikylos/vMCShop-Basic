<!--
 * Created with ♥ by Verlikylos on 15.10.2017 01:57.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<body>

    <?php $this->load->view('components/Navigation'); ?>

    <div class="container">

        <div class="row">

            <div class="col-sm-12">

                <ol class="breadcrumb" style="margin-top: 1em;">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('panel/dashboard'); ?>">Admin Control Panel</a></li>
                    <li class="breadcrumb-item active">Ustawienia konta</li>
                </ol>

            </div>

        </div>

        <div class="row space-box">

            <div class="col-sm-12">

                <div class="card card-outline-primary bg-faded space-box">
                    <div class="card-block">

                        <div class="row">

                            <div class="col-sm-12 col-md-3">
                                <?php $this->load->view('panel/components/Sidebar'); ?>
                            </div>

                            <div class="col-sm-12 col-md-9">

                                <div class="row mt-3 mt-sm-0">

                                    <div class="col-sm-12 text-center text-md-left">
                                        <h4><i class="fa fa-user" aria-hidden="true"></i> Zalogowany jako <?php echo $_SESSION['name']; ?></h4>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <h4><i class="fa fa-key" aria-hidden="true"></i> Zmiana hasła</h4>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 offset-md-3">

                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/account/changepassword')) : ''; ?>

                                                    <div class="form-group">
                                                        <label for="accountPass">Aktualne hasło<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                        <input type="password" class="form-control" id="accountPass" name="accountPass" autocomplete="off" required />
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="accountNewPass">Nowe hasło<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                        <input type="password" class="form-control" id="accountNewPass" name="accountNewPass" autocomplete="off" required />
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="accountNewPassRepeat">Powtórz nowe hasło<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                        <input type="password" class="form-control" id="accountNewPassRepeat" name="accountNewPassRepeat" autocomplete="off" required />
                                                    </div>

                                                    <div class="text-center mt-5 mb-4">
                                                        <button type="button" class="btn btn-lg btn-outline-success" onclick="showLoading('Trwa zmiana hasła...', this)"><i class="fa fa-check" aria-hidden="true"></i> Zmień hasło</button>
                                                    </div>

                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>