<!--
 * Created with ♥ by Verlikylos on 13.10.2017 19:10.
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
                    <li class="breadcrumb-item active">Historia zakupów</li>
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
                                        <h4><i class="fa fa-history" aria-hidden="true"></i> Historia zakupów</h4>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$purchases): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych płatności do wyświetlenia!</h4>

                                        <?php else: ?>

                                            <table class="table table-striped table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Klient</th>
                                                    <th class="text-center">Serwer</th>
                                                    <th class="text-center">Usługa</th>
                                                    <th class="text-center">Płatność</th>
                                                    <th class="text-center">Szczegóły</th>
                                                    <th class="text-center">Zysk</th>
                                                    <th class="text-center">Data</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($purchases as $purchase): ?>
                                                    <tr>
                                                        <td><?php echo $purchase['buyer']; ?></td>
                                                        <td><?php echo $purchase['server']; ?></td>
                                                        <td><?php echo $purchase['service']; ?></td>
                                                        <td>
                                                            <?php switch ($purchase['method']) {
                                                                case "SMS Premium":
                                                                    echo '<span class="badge badge-warning">SMS Premium</span>';
                                                                    break;
                                                                case "PayPal":
                                                                    echo '<span class="badge badge-info">PayPal</span>';
                                                                    break;
                                                                case "Voucher":
                                                                    echo '<span class="badge badge-success">Voucher</span>';
                                                                    break;
                                                            } ?>
                                                        </td>
                                                        <td><?php echo ($purchase['method'] == "Voucher") ? '<span class="text-success" data-toggle="tooltip" title="' . $purchase['details'] . '">Kod vouchera</span>' : $purchase['details']; ?></td>
                                                        <td><?php echo number_format($purchase['profit'], 2, ',', ' '); ?> zł</td>
                                                        <td><?php echo formatDate($purchase['date']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        <?php endif; ?>

                                        <?php echo $pagination; ?>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>