<!--
 * Created with ♥ by Verlikylos on 11.09.2017 22:12.
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
                    <li class="breadcrumb-item active">Sklep serwera <?php echo $server['name']; ?></li>
                </ol>

            </div>

        </div>

        <div class="row space-box">

            <?php if ($settings['sidebarPos'] == 2): ?>

                <div class="col-md-4">
                    <div class="card card-outline-primary bg-faded" style="margin-bottom: 1em;">
                        <div class="card-header bg-primary text-custom">
                            <i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Status serwera
                        </div>
                        <div class="card-block text-center">

                            <h5 class="card-text">Serwer <?php echo $server['name']; ?></h5>
                            <br />
                            <?php if (isset($server['status'])): ?>

                                <div class="progress">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: <?php echo $server['status']['percent']; ?>%;" role="progressbar" aria-valuenow="<?php echo $server['status']['percent']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br />
                                <h5>
                                    <span class="badge badge-success">Online</span>
                                    <span class="badge badge-info"><?php echo $server['status']['onlinePlayers'] . "/" . $server['status']['maxPlayers']; ?></span>
                                    <span class="badge badge-success"><?php echo $server['status']['version']; ?></span>
                                </h5>

                            <?php else: ?>

                                <div class="progress">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br />
                                <h5>
                                    <span class="badge badge-danger">Offline</span>
                                </h5>

                            <?php endif; ?>

                        </div>
                    </div>

                    <?php if ($settings['lastBuyersPos'] == 1): ?>

                        <div class="card card-outline-primary bg bg-faded">
                            <div class="card-header bg-primary text-custom">
                                <i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Ostatni kupujący
                            </div>
                            <div class="card-block text-center">

                                <?php if (!$purchases): ?>

                                    <h4 class="text-center pb-1 mb-0"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nikt jeszcze nie dokonał zakupu!</h4>

                                <?php else: ?>
                                    <?php foreach ($purchases as $purchase): ?>
                                        <img class="img-fluid rounded mb-2 mr-1" src="https://cravatar.eu/avatar/<?php echo $purchase['buyer']; ?>/44" alt="<?php echo $purchase['buyer']; ?>'s avatar" data-toggle="tooltip" data-html="true" title="<strong><?php echo $purchase['buyer']; ?></strong><br /><?php echo $purchase['service']; ?>" />
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php endif; ?>
                </div>

            <?php endif; ?>

            <div class="col-md-8">
                <div class="card card-outline-primary bg-faded">
                    <div class="card-block">

                        <div class="row">

                            <div class="col-sm-12 col-md-6 text-center text-md-left">
                                <h4><i class="fa fa-shopping-basket" aria-hidden="true"></i> Sklep serwera <?php echo $server['name']; ?></h4>
                            </div>

                            <div class="col-sm-12 col-md-6 text-center text-md-right mb-3">
                                <button class="btn btn-outline-success" data-toggle="modal" data-target="#voucherModal"><i class="fa fa-key" aria-hidden="true"></i> Zrealizuj voucher</button>
                            </div>

                            <?php if ($settings['serviceListLayout'] == 1): ?>

                                <?php if (!$services): ?>

                                    <div class="col-sm-12 text-center">
                                        <h4 class="mb-0"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Ten sklep nie posiada jeszcze żadnych usług!</h4>
                                    </div>

                                <?php else: ?>

                                    <?php foreach ($services as $service): ?>

                                        <div class="col-md-6">

                                            <div class="card service-card">
                                                <div class="card-image-top card-image-custom" style="background-image: url('<?php echo $service['image']; ?>')"></div>
                                                <div class="card-block text-center">
                                                    <h4 class="card-title"><?php echo $service['name']; ?></h4>
                                                    <h5 class="card-text">
                                                        <?php if (($service['smsConfig'] != null) && ($settings['smsOperator'] != 0)): ?>
                                                            <span class="badge badge-default"><i class="fa fa-mobile" aria-hidden="true"></i> SMS: <?php echo getPriceBrutto($service['smsConfig']['smsNumber'], $service['smsConfig']['operator']); ?> zł</span>
                                                        <?php endif; ?>
                                                        <?php if (($service['paypalCost']) && ($paypal != null)): ?>
                                                            <span class="badge badge-default"><i class="fa fa-paypal" aria-hidden="true"></i> PayPal: <?php echo number_format($service['paypalCost'], 2, ',', ' '); ?> zł</span>
                                                        <?php endif; ?>
                                                    </h5>
                                                    <br />
                                                    <a href="<?php echo base_url('service/' . $service['id']); ?>" class="btn btn-lg btn-success"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Kup</a>
                                                </div>
                                            </div>

                                        </div>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            <?php elseif ($settings['serviceListLayout'] == 2): ?>

                                <?php if (!$services): ?>

                                    <div class="col-sm-12 text-center">
                                        <h4 class="mb-0"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Ten sklep nie posiada jeszcze żadnych usług!</h4>
                                    </div>

                                <?php else: ?>

                                    <?php foreach ($services as $service): ?>

                                        <div class="col-sm-12 mb-3">
                                            <div class="card">
                                                <div class="card-block" style="padding: 0;">
                                                    <div class="row">
                                                        <div class="col-sm-5" style="height: 270px;">
                                                            <img class="img-fluid horizontal-card-image" src="<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?> image">
                                                        </div>
                                                        <div class="col-sm-7 pl-0">
                                                            <div class="horizontal-card">
                                                                <h3 class="text-center text-md-left"><?php echo $service['name']; ?></h3>
                                                                <?php if (strlen($service['description']) > 290): ?>
                                                                    <?php echo substr($service['description'], 0, 286) . " ..."; ?>
                                                                <?php else: ?>
                                                                    <?php echo $service['description']; ?>
                                                                <?php endif; ?>
                                                                <h5 class="card-text float-left" style="margin-top: 50px;">
                                                                    <?php if ($service['smsConfig']): ?>
                                                                        <span class="badge badge-default"><i class="fa fa-mobile" aria-hidden="true"></i> SMS: 11.07 zł</span>
                                                                    <?php endif; ?>
                                                                    <?php if ($service['paypalCost']): ?>
                                                                        <span class="badge badge-default"><i class="fa fa-paypal" aria-hidden="true"></i> PayPal: <?php echo $service['paypalCost']; ?> zł</span>
                                                                    <?php endif; ?>
                                                                </h5>
                                                                <a href="<?php echo base_url('service/' . $service['id']); ?>" class="btn btn-lg btn-success float-right" style="margin-top: 40px;"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Kup</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>

            <?php if ($settings['sidebarPos'] == 1): ?>

                <div class="col-md-4">
                    <div class="card card-outline-primary bg-faded" style="margin-bottom: 1em;">
                        <div class="card-header bg-primary text-custom">
                            <i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Status serwera
                        </div>
                        <div class="card-block text-center">

                            <h5 class="card-text">Serwer <?php echo $server['name']; ?></h5>
                            <br />
                            <?php if (isset($server['status'])): ?>

                                <div class="progress">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: <?php echo $server['status']['percent']; ?>%;" role="progressbar" aria-valuenow="<?php echo $server['status']['percent']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br />
                                <h5>
                                    <span class="badge badge-success">Online</span>
                                    <span class="badge badge-info"><?php echo $server['status']['onlinePlayers'] . "/" . $server['status']['maxPlayers']; ?></span>
                                    <span class="badge badge-success"><?php echo $server['status']['version']; ?></span>
                                </h5>

                            <?php else: ?>

                                <div class="progress">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <br />
                                <h5>
                                    <span class="badge badge-danger">Offline</span>
                                </h5>

                            <?php endif; ?>

                        </div>
                    </div>

                    <?php if ($settings['lastBuyersPos'] == 1): ?>

                        <div class="card card-outline-primary bg bg-faded">
                            <div class="card-header bg-primary text-custom">
                                <i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Ostatni kupujący
                            </div>
                            <div class="card-block text-center">

                                <?php if (!$purchases): ?>

                                    <h4 class="text-center pb-1 mb-0"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nikt jeszcze nie dokonał zakupu!</h4>

                                <?php else: ?>
                                    <?php foreach ($purchases as $purchase): ?>
                                        <img class="img-fluid rounded mb-2 mr-1" src="https://cravatar.eu/avatar/<?php echo $purchase['buyer']; ?>/44" alt="<?php echo $purchase['buyer']; ?>'s avatar" data-toggle="tooltip" data-html="true" title="<strong><?php echo $purchase['buyer']; ?></strong><br /><?php echo $purchase['service']; ?>" />
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </div>

        <?php if ($settings['lastBuyersPos'] == 2): ?>

            <div class="row space-box">
                <div class="col-sm-12">
                    <div class="card card-outline-primary bg-faded">
                        <div class="card-header bg-primary text-custom">
                            <i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Ostatni kupujący
                        </div>
                        <div class="card-block text-center">

                            <?php if (!$purchases): ?>

                                <h4 class="text-center pb-1 mb-0"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nikt jeszcze nie dokonał zakupu!</h4>

                            <?php else: ?>
                                <?php foreach ($purchases as $purchase): ?>
                                    <img class="img-fluid rounded mb-2 mr-1" src="https://cravatar.eu/avatar/<?php echo $purchase['buyer']; ?>/44" alt="<?php echo $purchase['buyer']; ?>'s avatar" data-toggle="tooltip" data-html="true" title="<strong><?php echo $purchase['buyer']; ?></strong><br /><?php echo $purchase['service']; ?>" />
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <div class="row">