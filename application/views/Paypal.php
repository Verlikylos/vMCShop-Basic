<!--
 * Created with ♥ by Verlikylos on 08.11.2017 13:39.
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
                    <li class="breadcrumb-item active"><a href="<?php echo base_url('shop/' . $server['name']); ?>">Sklep serwera <?php echo $server['name']; ?></a></li>
                    <li class="breadcrumb-item active">Weryfikacja płatności PayPal</li>
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
                    <div class="card-block text-center">

                        <?php if ($displayPage == "createForm"): ?>

                            <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open('https://www.paypal.com/cgi-bin/webscr', 'id="paypalForm"') : ''; ?>

                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="business" value="<?php echo $paypalData['business']; ?>">
                                <input type="hidden" name="item_name" value="<?php echo $paypalData['item_name']; ?>">
                                <input type="hidden" name="item_number" value="<?php echo $paypalData['item_number']; ?>">
                                <input type="hidden" name="custom" value="<?php echo $paypalData['custom']; ?>">
                                <input type="hidden" name="amount" value="<?php echo $paypalData['amount']; ?>">
                                <input type="hidden" name="notify_url" value="<?php echo base_url('paypal/ipn'); ?>">
                                <input type="hidden" name="return" value="<?php echo base_url('paypal/success'); ?>">
                                <input type="hidden" name="cancel_return" value="<?php echo base_url('paypal/cancelled'); ?>">
                                <input type="hidden" name="charset" value="utf-8">
                                <input type="hidden" name="quantity" value="<?php echo $paypalData['quantity']; ?>">
                                <input type="hidden" name="currency_code" value="<?php echo $paypalData['currency_code']; ?>">

                                <h4 class="mb-3">Trwa przekierowywanie do płatności...</h4>
                                <button class="btn btn-success" onclick="this.form.submit()">Kliknij tutaj, jeżeli nie zostaniesz przeniesiony w ciągu 10 sekund</button>

                            <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                        <?php elseif ($displayPage == "showWait"): ?>

                            <h4 class="mb-3">Trwa weryfikowanie płatności przez system PayPal. Odczekaj kilka sekund i odśwież stronę.</h4>
                            <button class="btn btn-success" onclick="location.reload();">Odśwież stronę!</button>

                        <?php elseif ($displayPage == "error"): ?>

                            <h4 class="mb-3">Płatność przebiegła pomyślnie, lecz podczas realizacji usługi wystąpił błąd. Skontaktuj się z administracją serwera w celu rozwiązania problemu!</h4>
                            <a href="<?php echo base_url(); ?>" class="btn btn-success" onclick="location.reload();">Przejdź do strony głównej!</a>

                        <?php else: ?>

                            <h4 class="mb-3"><?php echo $displayPage; ?></h4>
                            <a href="<?php echo base_url(); ?>" class="btn btn-success" onclick="location.reload();">Przejdź do strony głównej!</a>

                        <?php endif; ?>

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