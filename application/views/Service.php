<!--
 * Created with ♥ by Verlikylos on 20.09.2017 20:21.
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
                    <li class="breadcrumb-item"><a href="<?php echo base_url('shop/' . $server['name']); ?>">Sklep serwera <?php echo $server['name']; ?></a></li>
                    <li class="breadcrumb-item active">Ranga VIP</li>
                </ol>

            </div>

        </div>

        <div class="row space-box">

            <div class="col-sm-12">

                <div class="card card-outline-primary bg-faded space-box">
                    <div class="card-block">

                        <div class="row">

                            <div class="col-md-6 col-sm-12 text-center">

                                <img class="img-fluid rounded w-50" src="<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?> image">

                                <hr class="float-none">

                                <h2><?php echo $service['name']; ?></h2>

                                <p class="text-center">
                                    <?php echo $service['description']; ?>
                                </p>

                            </div>

                            <div class="col-md-6 col-sm-12">

                                <?php $i = 0; ?>

                                <?php if (($service['smsConfig'] == null) && ($paypal == null)): ?>

                                    <h4 class="text-center mt-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aby umożliwić zakup usługi, skonfiguruj jedną z metod płatności w panelu administratora!</h4>

                                <?php endif; ?>

                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <?php if (($service['smsConfig'] != null) && ($settings['smsOperator'] != 0)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link<?php echo ($i == 0) ? ' active' : ''; ?>" data-toggle="tab" href="#sms" role="tab"><i class="fa fa-mobile-phone" aria-hidden="true"></i> SMS Premium</a>
                                        </li>
                                        <?php $i ++; ?>
                                    <?php endif; ?>

                                    <?php if (($service['paypalCost']) && ($paypal != null)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link<?php echo ($i == 0) ? ' active' : ''; ?>" data-toggle="tab" href="#paypal" role="tab"><i class="fa fa-paypal" aria-hidden="true"></i> PayPal</a>
                                        </li>
                                        <?php $i ++; ?>
                                    <?php endif; ?>

                                    <!--
                                        <li class="nav-item">
                                            <a class="nav-link disabled" data-toggle="tab" href="#transfer" role="tab"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Przelew</a>
                                        </li>
                                    -->
                                </ul>

                                <div class="tab-content">

                                    <?php $i = 0; ?>

                                    <?php if (($service['smsConfig'] != null) && ($settings['smsOperator'] != 0)): ?>
                                        <div class="tab-pane fade<?php echo ($i == 0) ? ' show active' : ''; ?> text-center" id="sms" role="tabpanel">

                                            <h2 class="mt-3"><i class="fa fa-mobile-phone" aria-hidden="true"></i> Płatność SMS Premium</h2>
                                            <h5><span class="badge badge-success">Koszt: <?php echo getPriceNetto($service['smsConfig']['smsNumber'], $settings['smsOperator']); ?> zł (<?php echo getPriceBrutto($service['smsConfig']['smsNumber'], $settings['smsOperator']); ?> z VAT)</span></h5>

                                            <p class="mt-5">
                                                Aby aktywować usługę, wyślij SMS o treści<br /><strong>
                                                    <?php
                                                        switch ($settings['smsOperator']) {
                                                            case 1:
                                                                echo $service['smsConfig']['smsChannel'];
                                                                break;
                                                            case 2:
                                                                echo $service['smsConfig']['smsChannel'];
                                                                break;
                                                            case 3:
                                                                echo $service['smsConfig']['smsChannel'];
                                                                break;
                                                            case 4:
                                                                echo $service['smsConfig']['smsChannel'];
                                                                break;
                                                        }
                                                    ?>
                                                </strong> pod numer <strong><?php echo $service['smsConfig']['smsNumber']; ?></strong>.<br />Otrzymany kod wprowadź poniżej.
                                            </p>

                                            <div class="row">

                                                <div class="col-md-8 offset-md-2 col-sm-12 mt-5 text-left">

                                                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('checkout/sms')) : ''; ?>

                                                        <input type="hidden" name="serviceId" value="<?php echo $service['id']; ?>" />
                                                        <input type="hidden" name="serverName" value="<?php echo $server['name']; ?>" />

                                                        <div class="form-group">
                                                            <label for="userName">Twój nick z serwera:</label>
                                                            <input type="text" class="form-control" id="userName" name="userName" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="smsCode">Kod z SMS:</label>
                                                            <input type="text" class="form-control" id="smsCode" name="smsCode" />
                                                        </div>

                                                        <br />

                                                        <div class="form-group text-center">
                                                            <button class="btn btn-lg btn-success" onclick="$(this).children('i').attr('class','fa fa-cog fa-spin');"><i class="fa fa-check" aria-hidden="true"></i> Realizuj usługę</button>
                                                        </div>

                                                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                </div>

                                            </div>


                                            <hr class="mt-5">

                                            <?php
                                                switch ($settings['smsOperator']) {
                                                    case 1:
                                                        echo '
                                                            <img class="img-fluid rounded" src="' . base_url('assets/images/microsms.png') . '" alt="MicroSMS.pl" />
    
                                                            <p class="mt-1">
                                                                Płatności zapewnia firma <a href="http://microsms.pl/">MicroSMS</a>. Korzystanie z serwisu jest jednozanczne z akceptacją <a href="http://microsms.pl/partner/documents/">regulaminów</a>. Jeśli nie dostałeś kodu zwrotnego w ciągu 30 minut skorzystaj z <a href="http://microsms.pl/customer/complaint/">formularza reklamacyjnego</a>.
                                                            </p>
                                                        ';
                                                        break;
                                                    case 2:
                                                        echo '
                                                        <img class="img-responsive center-block" src="' . base_url('assets/images/logo_dotpay.jpg') . '" alt="DotPay.pl" />
                                                        
                                                        <p>
                                                            Płatności zapewnia firma <a href="http://dotpay.pl/">DotPay</a>. Korzystanie z serwisu jest jednozanczne z akceptacją <a href="http://www.dotpay.pl/regulamin-serwisow-sms-premium/">regulaminów</a>. Jeśli nie dostałeś kodu zwrotnego w ciągu 30 minut skorzystaj z <a href="https://www.dotpay.pl/kontakt/uslugi-sms-premium/">formularza reklamacyjnego</a>.
                                                        </p>
                                                        ';
                                                        break;
                                                    case 3:
                                                        echo '
                                                        <img class="img-responsive center-block" src="' . base_url('assets/images/homepay.png') . '" alt="Homepay.pl" />
                                                        
                                                        <p>
                                                            Płatności zapewnia firma <a href="http://homepay.pl/">Homepay</a>. Korzystanie z serwisu jest jednozanczne z akceptacją <a href="http://homepay.pl/regulamin">regulaminów</a>. Jeśli nie dostałeś kodu zwrotnego w ciągu 30 minut skorzystaj z <a  href="https://homepay.pl/reklamacje">formularza reklamacyjnego</a>.
                                                        </p>
                                                        ';
                                                        break;
                                                    case 4:
                                                        echo '
                                                        <img class="img-responsive center-block" src="' . base_url('assets/images/pukawka.png') . '" alt="Pukawka.pl" />
                                            
                                                        <p>
                                                            Płatności zapewnia firma <a href="http://pukawka.pl/">Pukawka</a>. Korzystanie z serwisu jest jednozanczne z akceptacją <a href="http://pukawka.pl/regulamin_sms.html">regulaminów</a>. Jeśli nie dostałeś kodu zwrotnego w ciągu 30 minut skorzystaj z <a href="https://admin.pukawka.pl/?page=wallet&do=reklamacjasms">formularza reklamacyjnego</a>.
                                                        </p>
                                                        ';
                                                        break;
                                                }
                                            ?>

                                        </div>
                                        <?php $i ++; ?>
                                    <?php endif; ?>

                                    <?php if (($service['paypalCost']) && ($paypal != null)): ?>
                                        <div class="tab-pane fade<?php echo ($i == 0) ? ' show active' : ''; ?> text-center" id="paypal" role="tabpanel">

                                            <h2 class="mt-3"><i class="fa fa-mobile-phone" aria-hidden="true"></i> Płatność PayPal</h2>
                                            <h5><span class="badge badge-success">Koszt: <?php echo number_format($service['paypalCost'], 2, ',', ' '); ?> zł</span></h5>

                                            <p class="mt-5">
                                                Aby aktywować usługę, wpisz poniżej swój nick z serwera i przejdź dalej.
                                            </p>

                                            <div class="row">

                                                <div class="col-md-8 offset-md-2 col-sm-12 mt-5 text-left">

                                                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('Paypal')) : ''; ?>

                                                        <input type="hidden" name="serviceId" value="<?php echo $service['id']; ?>" />
                                                        <input type="hidden" name="serverName" value="<?php echo $server['name']; ?>" />

                                                        <div class="form-group">
                                                            <label for="userName">Twój nick z serwera:</label>
                                                            <input type="text" class="form-control" id="userName" name="userName" />
                                                        </div>

                                                        <br />

                                                        <div class="form-group text-center">
                                                            <button type="submit" class="btn btn-lg btn-success" onclick="$(this).children('i').attr('class','fa fa-cog fa-spin');"><i class="fa fa-mail-forward" aria-hidden="true"></i> Przejdź do płatności</button>
                                                        </div>

                                                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                </div>

                                            </div>


                                            <hr class="mt-5">

                                            <img class="img-fluid w-50 rounded" src="<?php echo base_url('assets/images/paypal.png'); ?>" alt="PayPal.com" />

                                            <p class="mt-1">
                                                Dokonanie płatności jest jednoznaczne z akceptacją <a href="https://www.paypal.com/pl/webapps/mpp/ua/legalhub-full?locale.x=pl_PL">regulaminów i umów</a>. W celu zgłoszenia reklamacji lub utworzenia sporu odwiedź <a href="https://www.paypal.com/pl/selfhelp/topic/DISPUTE_AND_CLAIM_INFORMATION">ten link</a>.
                                            </p>

                                        </div>
                                        <?php $i ++; ?>
                                    <?php endif; ?>

                                    <!--
                                        <div class="tab-pane fade" id="transfer" role="tabpanel">.3..</div>
                                    -->
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>