<!--
 * Created with ♥ by Verlikylos on 11.10.2017 19:56.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<body>

    <?php $this->load->view('components/Navigation'); ?>

    <div class="container">

        <div class="row">

            <div class="col-sm-12">

                <ol class="breadcrumb" style="margin-top: 1em;">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Strona Główna</a></li>
                    <li class="breadcrumb-item active">Logowanie do ACP</li>
                </ol>

            </div>

        </div>

        <div class="row space-box">

            <div class="col-sm-12">

                <div class="card card-outline-primary bg-faded space-box">
                    <div class="card-block">

                        <div class="col-md-4 offset-md-4 col-sm-12 pt-4 pb-4">

                            <?php echo form_open(base_url('admin/login')); ?>

                                <div class="form-group">
                                    <label for="authLogin">Login</label>
                                    <input type="text" class="form-control" id="authLogin" name="authLogin" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label for="authPass">Hasło</label>
                                    <input type="password" class="form-control" id="authPass" name="authPass" autocomplete="off" required />
                                </div>

                                <br />

                                <button type="submit" class="btn btn-success btn-lg btn-block">Zaloguj się</button>

                            <?php echo form_close(); ?>

                        </div>

                    </div>
                </div>

            </div>