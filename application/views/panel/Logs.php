<!--
 * Created with ♥ by Verlikylos on 13.10.2017 20:01.
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
                    <li class="breadcrumb-item active">Logi</li>
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
                                        <h4><i class="fa fa-database" aria-hidden="true"></i> Logi</h4>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$logs): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych logów do wyświetlenia!</h4>

                                        <?php else: ?>

                                            <table class="table table-striped table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Użytkownik</th>
                                                        <th class="text-center">Sekcja</th>
                                                        <th class="text-center">Szczegóły</th>
                                                        <th class="text-center">Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($logs as $log): ?>
                                                        <tr>
                                                            <td><?php echo $log['user']; ?></td>
                                                            <td><?php echo getLogBadge($log['section']); ?></td>
                                                            <td><?php echo $log['details']; ?></td>
                                                            <td><?php echo formatDate($log['date']); ?></td>
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