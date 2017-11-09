<!--
 * Created with ♥ by Verlikylos on 13.10.2017 16:38.
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
                    <li class="breadcrumb-item active">Usługi</li>
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

                                    <div class="col-sm-12 col-md-6 text-center text-md-left">
                                        <h4><i class="fa fa-diamond" aria-hidden="true"></i> Usługi</h4>
                                    </div>

                                    <div class="col-sm-12 col-md-6 text-center text-md-right">
                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#serviceAddModal"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nową usługę</button>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$services): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych usług do wyświetlenia!</h4>

                                        <?php else: ?>

                                            <table class="table table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">Nazwa</th>
                                                        <th class="text-center">Serwer</th>
                                                        <th class="text-center">Ustawienia płatności</th>
                                                        <th class="text-center">Opis, obrazek oraz komendy</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($services as $service): ?>

                                                        <tr>
                                                            <td><?php echo $service['id']; ?></td>
                                                            <td><?php echo $service['name']; ?></td>
                                                            <td><?php echo $service['server']; ?></td>
                                                            <td><button type="submit" class="btn btn-sm btn-info" data-toggle="modal" data-target="#servicePayments<?php echo $service['id']; ?>" style="margin-top: -3px;"><i class="fa fa-search" aria-hidden="true"></i> Podgląd</button></td>
                                                            <td><button type="submit" class="btn btn-sm btn-info" data-toggle="modal" data-target="#serviceSettings<?php echo $service['id']; ?>" style="margin-top: -3px;"><i class="fa fa-search" aria-hidden="true"></i> Podgląd</button></td>
                                                            <td class="td-actions">

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/edit/service'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="serviceId" value="<?php echo $service['id']; ?>">

                                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>


                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/services/remove'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="serviceId" value="<?php echo $service['id']; ?>">

                                                                <button type="button" onclick="uSure(this);" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                            </td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>