<!--
 * Created with ♥ by Verlikylos on 13.10.2017 18:28.
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
                    <li class="breadcrumb-item active">Vouchery</li>
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
                                        <h4><i class="fa fa-key" aria-hidden="true"></i> Vouchery</h4>
                                    </div>

                                    <div class="col-sm-12 col-md-6 text-center text-md-right">
                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#voucherAddModal"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Wygeneruj nowy voucher</button>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$vouchers): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych voucherów do wyświetlenia!</h4>

                                        <?php else: ?>
                                            <table class="table table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">Serwer</th>
                                                        <th class="text-center">Usługa</th>
                                                        <th class="text-center">Voucher</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($vouchers as $voucher): ?>
                                                        <tr>
                                                            <td><?php echo $voucher['id']; ?></td>
                                                            <td><?php echo $voucher['server']; ?></td>
                                                            <td><?php echo $voucher['service']; ?></td>
                                                            <td><?php echo $voucher['code']; ?></td>
                                                            <td class="td-actions">

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/vouchers/remove'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="voucherId" value="<?php echo $voucher['id']; ?>">

                                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>

                                                                <?php echo (strpos('vmcshop.pro', base_url()) !== true) ? form_close() : ''; ?>

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