<!--
 * Created with ♥ by Verlikylos on 11.09.2017 21:08.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<body>

    <?php $this->load->view('components/Navigation'); ?>

    <div class="container">

        <div class="row">

            <div class="col-sm-12">

                <div class="card card-outline-primary bg-faded space-box" style="margin-top: 1em;">
                    <div class="card-block">

                        <div class="row">

                            <?php if (!$servers): ?>

                                <div class="col-sm-12">
                                    <h4 class="text-center mb-0"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych serwerów do wyświetlenia!</h4>
                                </div>

                            <?php else: ?>

                                <?php foreach ($servers as $server): ?>

                                    <div class="col-md-4">

                                        <div class="card mb-3">
                                            <img style="width: 100%; display: block;" src="<?php echo $server['image']; ?>" alt="<?php echo $server['name']; ?> image">
                                            <div class="card-footer text-muted text-xs-center">

                                                <h5 class="text-center">

                                                    <?php if (isset($server['status'])): ?>

                                                        <span class="badge badge-success">Online</span>
                                                        <span class="badge badge-info"><?php echo $server['status']['onlinePlayers'] . "/" . $server['status']['maxPlayers']; ?></span>
                                                        <span class="badge badge-success"><?php echo $server['status']['version']; ?></span>

                                                    <?php else: ?>

                                                        <span class="badge badge-danger">Offline</span>

                                                    <?php endif; ?>

                                                </h5>

                                                <a class="btn btn-lg btn-success btn-block" href="<?php echo base_url('shop/' . $server['name']); ?>">Serwer <?php echo $server['name']; ?></a>

                                            </div>
                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                    </div>
                </div>

            </div>