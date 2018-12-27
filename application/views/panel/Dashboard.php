<!--
 * Created with ♥ by Verlikylos on 12.10.2017 16:24.
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
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

            </div>

        </div>

        <div class="row space-box">

            <div class="col-sm-12">

                <div class="card card-outline-primary bg-faded space-box">
                    <div class="card-block">

                        <div class="row mt-3 mt-sm-0">

                            <div class="col-sm-12 col-md-3">
                                <?php $this->load->view('panel/components/Sidebar'); ?>
                            </div>

                            <div class="col-sm-12 col-md-9">

                                <div class="row mt-3 mt-sm-0">

                                    <div class="col-sm-12 text-center text-md-left">
                                        <h4><i class="fa fa-desktop" aria-hidden="true"></i> Dashboard</h4>
                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3">

                                        <div class="circle-tile">
                                            <div class="circle-tile-heading bg-primary text-custom"><i class="fa fa-server fa-3x"></i></div>
                                            <div class="circle-tile-content bg-primary">
                                                <div class="circle-tile-description text-custom" style="text-transform: none;">Obsługiwane serwery</div>
                                                <div class="circle-tile-number text-custom"><?php echo count($servers); ?></div>
                                                <a class="circle-tile-footer" href="<?php echo base_url('panel/servers'); ?>">Przejdź <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3">

                                        <div class="circle-tile">
                                            <div class="circle-tile-heading bg-primary text-custom"><i class="fa fa-server fa-3x"></i></div>
                                            <div class="circle-tile-content bg-primary">
                                                <div class="circle-tile-description text-custom" style="text-transform: none;">Administratorzy</div>
                                                <div class="circle-tile-number text-custom"><?php echo $usersCount; ?></div>
                                                <a class="circle-tile-footer" href="<?php echo base_url('panel/users'); ?>">Przejdź <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3">

                                        <div class="circle-tile">
                                            <div class="circle-tile-heading bg-primary text-custom"><i class="fa fa-diamond fa-3x"></i></div>
                                            <div class="circle-tile-content bg-primary">
                                                <div class="circle-tile-description text-custom" style="text-transform: none;">Sprzedane usługi</div>
                                                <div class="circle-tile-number text-custom"><?php echo $purchasesCount; ?></div>
                                                <a class="circle-tile-footer" href="<?php echo base_url('panel/purchases'); ?>">Przejdź <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3">

                                        <div class="circle-tile">
                                            <div class="circle-tile-heading bg-primary text-custom"><i class="fa fa-money fa-3x"></i></div>
                                            <div class="circle-tile-content bg-primary">
                                                <div class="circle-tile-description text-custom" style="text-transform: none;">Zyski</div>
                                                <div class="circle-tile-number text-custom"><?php echo number_format($profit, 2, ',', ' '); ?> zł</div>
                                                <a class="circle-tile-footer" href="<?php echo base_url('panel/purchases'); ?>">Przejdź <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-12 col-md-6">

                                        <div class="card card-outline-primary">
                                            <div class="card-block pb-2">
                                                <h4 class="card-title"><i class="fa fa-server" aria-hidden="true"></i> Status serwerów</h4>
                                                <?php if (!$servers): ?>

                                                    <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych serwerów do wyświetlenia!</h4>

                                                <?php else: ?>
                                                    <table class="table table-responsive d-md-table mb-0">
                                                        <tbody>
                                                            <?php foreach ($servers as $server): ?>
                                                                <tr>
                                                                    <td>Serwer <?php echo $server['name']; ?></td>
                                                                    <?php if (isset($server['status'])): ?>
                                                                        <td><span class="badge badge-success">Online</span></td>
                                                                        <td><?php echo $server['status']['onlinePlayers'] . "/" . $server['status']['maxPlayers']; ?></td>
                                                                        <td><?php echo $server['status']['version']; ?></td>
                                                                    <?php else: ?>
                                                                        <td><span class="badge badge-danger">Offline</span></td>
                                                                        <td>0/0</td>
                                                                        <td></td>
                                                                    <?php endif; ?>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-12 col-md-6 mt-3 mt-md-0">

                                        <div class="card card-outline-primary">
                                            <div class="card-block pb-2">
                                                <h4 class="card-title"><i class="fa fa-info" aria-hidden="true"></i> Informacje o skrypcie</h4>
                                                <table class="table table-responsive d-md-table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Autor:</td>
                                                            <td><a href="https://verlikylos.pro/">Verlikylos</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pomoc techniczna:</td>
                                                            <td><a href="mailto:kontakt@verlikylos.pro"><i class="fa fa-envelope" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="https://t.me/Verlikylos"><i class="fa fa-telegram" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="https://www.facebook.com/verlikylos"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Wersja</td>
                                                            <td><?php echo $this->config->item('version'); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>