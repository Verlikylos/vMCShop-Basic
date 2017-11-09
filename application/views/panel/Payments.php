<!--
 * Created with ♥ by Verlikylos on 14.10.2017 17:59.
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
                    <li class="breadcrumb-item active">Ustawienia płatności</li>
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

                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/payments/update')) : ''; ?>

                                    <div class="row mt-3 mt-sm-0">

                                        <div class="col-sm-12 col-md-6 text-center text-md-left">
                                            <h4><i class="fa fa-credit-card" aria-hidden="true"></i> Ustawienia płatności</h4>
                                        </div>

                                        <div class="col-sm-12 col-md-6 text-center text-md-right">
                                            <button type="button" class="btn btn-outline-success" onclick="showLoading('Trwa zapisywanie ustawień płatności...', this)"><i class="fa fa-floppy-o" aria-hidden="true"></i> Zapisz ustawienia</button>
                                        </div>

                                    </div>

                                    <div class="card card-outline-primary mt-3">
                                        <div class="card-block pb-2">

                                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#pageSms" role="tab"><i class="fa fa-mobile-phone" aria-hidden="true"></i> SMS Premium</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#pagePaypal" role="tab"><i class="fa fa-paypal" aria-hidden="true"></i> PayPal</a>
                                                </li>
<!--                                                <li class="nav-item">-->
<!--                                                    <a class="nav-link" data-toggle="tab" href="#pageTransfer" role="tab"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Przelew</a>-->
<!--                                                </li>-->
                                            </ul>

                                            <div class="tab-content">

                                                <div class="tab-pane fade show active" id="pageSms" role="tabpanel">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 offset-md-3 pt-3">

                                                            <div class="form-group">
                                                                <label for="paymentSmsOperator">Operator płatności SMS</label>
                                                                <select class="form-control" id="paymentSmsOperator" name="paymentSmsOperator" aria-describedby="paymentSmsOperatorHelp">
                                                                    <option disabled <?php echo ($smsOperator == null) ? 'selected' : ''; ?>>Brak</option>
                                                                    <option value="1" <?php echo ($smsOperator['name'] == "MicroSMS.pl") ? 'selected' : ''; ?>>MicroSMS.pl</option>
                                                                    <option value="2" <?php echo ($smsOperator['name'] == "Lvlup.pro") ? 'selected' : ''; ?>>Lvlup.pro</option>
                                                                    <option value="3" <?php echo ($smsOperator['name'] == "Homepay.pl") ? 'selected' : ''; ?>>Homepay.pl</option>
                                                                    <option value="4" <?php echo ($smsOperator['name'] == "Pukawka.pl") ? 'selected' : ''; ?>>Pukawka.pl</option>
                                                                </select>
                                                                <small id="paymentSmsOperatorHelp" class="form-text text-muted">Po wybraniu swojego operatora zapisz ustawienia, aby ukazały się dodatkowe pola konfiguracyjne.</small>
                                                            </div>

                                                            <?php if ($smsOperator != null): ?>

                                                                <?php if ($smsOperator['name'] == "MicroSMS.pl"): ?>

                                                                    <div class="form-group">
                                                                        <label for="paymentMicrosmsUserId">ID klienta<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                        <input type="text" class="form-control" id="paymentMicrosmsUserId" name="paymentMicrosmsUserId" value="<?php echo $smsOperator['config']->sms->userid; ?>" aria-describedby="paymentMicrosmsUserIdHelp" autocomplete="off" />
                                                                        <small id="paymentMicrosmsUserIdHelp" class="form-text text-muted">Identyfikator klienta w serwisie MicroSMS.pl</small>
                                                                    </div>

                                                                <?php elseif ($smsOperator['name'] == "Homepay.pl"): ?>

                                                                    <div class="form-group">
                                                                        <label for="paymentHomepayUserId">ID klienta<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                        <input type="text" class="form-control" id="paymentHomepayUserId" name="paymentHomepayUserId" value="<?php echo $smsOperator['config']->sms->userid; ?>" aria-describedby="paymentHomepayUserIdHelp" autocomplete="off" />
                                                                        <small id="paymentHomepayUserIdHelp" class="form-text text-muted">Identyfikator klienta w serwisie Homepay.pl</small>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="paymentHomepayApiKey">Klucz API<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                        <input type="text" class="form-control" id="paymentHomepayApiKey" name="paymentHomepayApiKey" value="<?php echo $smsOperator['config']->sms->apikey; ?>" aria-describedby="paymentHomepayApiKeyHelp" autocomplete="off" />
                                                                        <small id="paymentHomepayApiKeyHelp" class="form-text text-muted">Można znaleźć go w sekcji "Ustawienia &gt; Dane osobowe" w panelu klienta serwisu Homepay.pl</small>
                                                                    </div>

                                                                <?php elseif ($smsOperator['name'] == "Lvlup.pro"): ?>

                                                                    <div class="form-group">
                                                                        <label for="paymentLvlupUserId">ID klienta<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                        <input type="text" class="form-control" id="paymentLvlupUserId" name="paymentLvlupUserId" value="<?php echo $smsOperator['config']->sms->userid; ?>" aria-describedby="paymentLvlupUserIdHelp" autocomplete="off" />
                                                                        <small id="paymentLvlupUserIdHelp" class="form-text text-muted">Identyfikator klienta można znaleźć w panelu klienta hostingu Lvlup.pro w zakładce "API".</small>
                                                                    </div>

                                                                <?php elseif ($smsOperator['name'] == "Pukawka.pl"): ?>

                                                                    <div class="form-group">
                                                                        <label for="paymentPukawkaApiKey">Klucz API<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                        <input type="text" class="form-control" id="paymentPukawkaApiKey" name="paymentPukawkaApiKey" value="<?php echo $smsOperator['config']->sms->apikey; ?>" aria-describedby="paymentPukawkaApiKeyHelp" autocomplete="off" />
                                                                        <small id="paymentPukawkaApiKeyHelp" class="form-text text-muted">Można go znaleźć w zakładce "Portfel > SMS API" w panelu klienta serwisu Pukawka.pl</small>
                                                                    </div>

                                                                <?php endif; ?>

                                                                <div class="form-group">
                                                                    <label for="paymentPercentage">Prowizja</label>
                                                                    <input type="text" class="form-control" id="paymentPercentage" name="paymentPercentage" value="<?php echo ($smsOperator['config']->sms->percentage * 100) . '%'; ?>" aria-describedby="paymentPercentageHelp" autocomplete="off" />
                                                                    <small id="paymentPercentageHelp" class="form-text text-muted">Procent zysku jaki otrzymujesz z SMSa. Pozostaw to pole puste, aby użyć wartości domyślnej (45%).</small>
                                                                </div>

                                                            <?php endif; ?>

                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade" id="pagePaypal" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 offset-md-3 pt-3">

                                                            <div class="form-group">
                                                                <label for="paymentPaypalAdress">Adres E-mail</label>
                                                                <input type="text" class="form-control" id="paymentPaypalAdress" name="paymentPaypalAdress" value="<?php echo $paypal; ?>" aria-describedby="paymentPaypalAdressHelp" autocomplete="off" />
                                                                <small id="paymentPaypalAdressHelp" class="form-text text-muted">Adres powiązany z Twoim kontem PayPal</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

<!--                                                <div class="tab-pane fade" id="pageTransfer" role="tabpanel">-->
<!---->
<!--                                                </div>-->

                                            </div>

                                        </div>
                                    </div>

                                <?php echo form_close(); ?>

                            </div>

                        </div>

                    </div>
                </div>

            </div>