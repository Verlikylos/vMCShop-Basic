<!--
 * Created with ♥ by Verlikylos on 11.09.2017 21:02.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->


                <div class="col-sm-12">

                    <div class="card card-outline-primary bg-faded" style="margin-bottom: 4rem;">
                        <div id="footer" class="card-block">

                            <div class="row">

                                <div class="col-sm-6 text-left">

                                    <span>Generated in <?php echo $benchmark; ?>s</span>

                                </div>

                                <div class="col-sm-6 text-right">

                                    <!--   Zakaz usuwania informacji o autore oraz linku do jego strony ze stopki!  -->
                                    <!-- Usuniecie wyzej wymienionych danych wiaze sie ze zlamaniem praw autorskich!-->
                                    <span>Proudly powered by <a href="https://verlikylos.pro/">vMCShop Basic</a> v<?php echo $this->config->item('version'); ?></span>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Modals -->
        <?php if ($this->uri->rsegment('1') == "users"): ?>
            <div id="userAddModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nowego użytkownika</h5>
                            <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/users/create')) : ''; ?>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-sm-12 col-md-7">

                                        <div class="form-group">
                                            <label for="userName">Nazwa użytkownika<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                            <input type="text" class="form-control" id="userName" name="userName" />
                                        </div>

                                    </div>

                                    <div class="col-sm-12 col-md-5">
                                        <h6 class="font-weight-bold">Informacja:</h6>
                                        <p>Po dodaniu użytkownika zostanie wygenerowane losowe hasło, które wraz z wybraną nazwą użytkownika należy przesłać nowemu administratorowi.</p>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-outline-success"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj użytkownika</button>
                            </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->uri->rsegment('1') == "servers"): ?>
            <div id="serverAddModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nowy serwer</h5>
                            <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open_multipart(base_url('panel/servers/create')) : ''; ?>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-7">

                                    <div class="form-group">
                                        <label for="serverName">Nazwa serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="serverName" name="serverName" />
                                    </div>

                                    <div class="form-group">
                                        <label>Obrazek serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label><br />
                                        <label class="custom-file d-block">
                                            <input data-toggle="custom-file" data-target="#serverImageLabel" type="file" name="serverImage" accept="image/png" class="custom-file-input">
                                            <span id="serverImageLabel" class="custom-file-control custom-file-name" data-content="Wybierz obrazek..."></span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="serverIp">Adres IP serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="serverIp" name="serverIp" />
                                    </div>

                                    <div class="form-group">
                                        <label for="serverPort">Port serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="serverPort" name="serverPort" />
                                    </div>

                                    <div class="form-group">
                                        <label for="serverRconPort">Port RCON serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="serverRconPort" name="serverRconPort" />
                                    </div>

                                    <div class="form-group">
                                        <label for="serverRconPass">Hasło RCON serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="serverRconPass" name="serverRconPass" />
                                    </div>

                                </div>

                                <div class="col-sm-12 col-md-5">
                                    <h6 class="font-weight-bold">Informacja:</h6>
                                    <p>Wszelkie dane potrzebne do uzupełnienia formularza obok znajdziesz w pliku <strong>"server.properties"</strong> w katalogu głównym serwera. Kolejno zaczynając od Adresu IP będą to linijki o nazwach: <strong>"server-ip"</strong>, <strong>"server-port"</strong>, <strong>"rcon.port"</strong> oraz <strong>"rcon.password"</strong>.</p>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-outline-success"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj serwer</button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                    </div>
                </div>
            </div>

            <?php if ($servers): ?>
                <?php foreach ($servers as $server): ?>
                    <div id="serverImage<?php echo $server['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fa fa-picture-o" aria-hidden="true"></i> Obrazek serwera <?php echo $server['name']; ?></h5>
                                    <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img class="img-fluid" src="<?php echo $server['image']; ?>" alt="<?php echo $server['name']; ?> server image" />
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->uri->rsegment('1') == "services"): ?>
            <div id="serviceAddModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-gears" aria-hidden="true"></i> Dodaj nową usługę</h5>
                            <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open_multipart(base_url('panel/services/create')) : ''; ?>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-7">

                                    <div class="form-group">
                                        <label for="serviceName">Nazwa usługi<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="serviceName" name="serviceName" />
                                    </div>

                                    <div class="form-group">
                                        <label for="serviceServer">Serwer<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <select class="form-control" id="serviceServer" name="serviceServer">
                                            <option disabled selected>Brak</option>
                                            <?php foreach ($servers as $server): ?>
                                                <option value="<?php echo $server['id']; ?>">Serwer <?php echo $server['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="serviceDesc">Opis usługi<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <textarea class="form-control" id="serviceDesc" name="serviceDesc" rows="15"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Obrazek usługi<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label><br />
                                        <label class="custom-file d-block">
                                            <input data-toggle="custom-file" data-target="#serviceImageLabel" type="file" name="serviceImage" accept="image/png" class="custom-file-input">
                                            <span id="serviceImageLabel" class="custom-file-control custom-file-name" data-content="Wybierz obrazek..."></span>
                                        </label>
                                    </div>

                                    <?php if ($settings['smsOperator'] != 0): ?>
                                        <?php switch ($settings['smsOperator']) {
                                            case "1":
                                                echo '
                                                    <div class="form-group">
                                                        <label for="serviceId">Kanał SMS</label>
                                                        <input type="text" class="form-control" id="serviceChannel" name="serviceSmsChannel" />
                                                    </div>
                
                                                    <div class="form-group">
                                                        <label for="serviceChannelId">ID kanału SMS</label>
                                                        <input type="text" class="form-control" id="serviceChannelId" name="serviceSmsChannelId" />
                                                    </div>
                
                                                    <div class="form-group">
                                                        <label for="serviceSmsNumber">Numer SMS</label>
                                                        <select class="form-control" id="serviceSmsNumber" name="serviceSmsNumber">
                                                            <option value="" selected>Brak</option>
                                                            ';
                                                            foreach (getSmsNumbers(1) as $number => $cost) {
                                                                echo '<option value="' . $number . '">' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 1) . ' zł z VAT)</option>';
                                                            }
                                                            echo '
                                                        </select>
                                                    </div>
                                                ';
                                                break;
                                            case "2":
                                                echo '
                                                    <div class="form-group">
                                                        <label for="serviceSmsNumber">Numer SMS</label>
                                                        <select class="form-control" id="serviceSmsNumber" name="serviceSmsNumber">
                                                            <option selected>Brak</option>
                                                            ';
                                                            foreach (getSmsNumbers(2) as $number => $cost) {
                                                                echo '<option value="' . $number . '">' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 2) . ' zł z VAT)</option>';
                                                            }
                                                            echo '
                                                        </select>
                                                    </div>
                                                ';
                                                break;
                                            case "3":
                                                echo '
                                                    <div class="form-group">
                                                        <label for="serviceId">Identyfikator SMS</label>
                                                        <input type="text" class="form-control" id="serviceChannel" name="serviceSmsChannel" />
                                                    </div>
                
                                                    <div class="form-group">
                                                        <label for="serviceChannelId">ID konta SMS</label>
                                                        <input type="text" class="form-control" id="serviceChannelId" name="serviceSmsChannelId" />
                                                    </div>
                
                                                    <div class="form-group">
                                                        <label for="serviceSmsNumber">Numer SMS</label>
                                                        <select class="form-control" id="serviceSmsNumber" name="serviceSmsNumber">
                                                            <option selected>Brak</option>
                                                            ';
                                                            foreach (getSmsNumbers(3) as $number => $cost) {
                                                                echo '<option value="' . $number . '">' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 3) . ' zł z VAT)</option>';
                                                            }
                                                            echo '
                                                        </select>
                                                    </div>
                                                ';
                                                break;
                                            case "4":
                                                echo '
                                                    <div class="form-group">
                                                        <label for="serviceSmsNumber">Numer SMS</label>
                                                        <select class="form-control" id="serviceSmsNumber" name="serviceSmsNumber">
                                                            <option selected>Brak</option>
                                                            ';
                                                            foreach (getSmsNumbers(4) as $number => $cost) {
                                                                echo '<option value="' . $number . '">' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 4) . ' zł z VAT)</option>';
                                                            }
                                                            echo '
                                                        </select>
                                                    </div>
                                                ';
                                                break;
                                        } ?>
                                    <?php endif; ?>

                                    <div class="form-group">
                                        <label for="servicePaypalCost">Koszt PayPal</label>
                                        <input type="text" class="form-control" id="servicePaypalCost" name="servicePaypalCost" />
                                    </div>

                                    <div class="form-group">
                                        <label for="serviceCmds">Polecenia do wykonania<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <textarea class="form-control" id="serviceCmds" name="serviceCmds" rows="5"></textarea>
                                    </div>

                                </div>

                                <div class="col-sm-12 col-md-5">
                                    <h6 class="text-center">Aktualnie płatności SMS obsługuje:<br /><strong><?php echo ($smsOperator == null) ? "Jeszcze nie ustawiono" : $smsOperator['name']; ?></strong></h6>
                                    <br />
                                    <h6 class="font-weight-bold">Informacja:</h6>
                                    <p>
                                        <strong>Serwer</strong> - Wybierz serwer, na ktorym ma zostać zrealizowana usługa po pomyślnym dokonaniu płatności.<br /><br />

                                        <strong>Obrazek usługi</strong> - Maksymalna rozmiar obrazka to 10MB. Maksymalne wymiary 360x360 pikseli.<br /><br />

                                        <strong>Koszt PayPal</strong> - Cena usługi przy płatności PayPal. Płatność PayPal nie jest jeszcze obsługiwana przez sklep. (Jeżeli nie chcesz korzystać z płatności PayPal dla tej usługi pozostaw to pole puste)<br /><br />

                                        <strong>Polecenia do wykonania</strong> - Komendy, które zostaną wysłane na serwer po dokonaniu płatności przez użytkownika. Zamiast nicku gracza użyj "{PLAYER}" (bez cudzysłowi). Komendy oddzielaj średnikiem bez znaków nowej lini, spacji oraz poprzedzającego slash'a.<br /><br />
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-outline-success"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj usługę</button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                    </div>
                </div>
            </div>

            <?php if ($services): ?>
                <?php foreach ($services as $service): ?>
                    <div id="servicePayments<?php echo $service['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fa fa-gears" aria-hidden="true"></i> Ustawienia płatności usługi <?php echo $service['name']; ?> (ID: #<?php echo $service['id']; ?>)</h5>
                                    <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs nav-justified" role="tablist">
                                        <?php if ($service['smsConfig'] != null): ?>
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#servicePaymentsSms<?php echo $service['id']; ?>" role="tab"><i class="fa fa-mobile-phone" aria-hidden="true"></i> SMS</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($service['paypalCost'] != null): ?>
                                            <li class="nav-item">
                                                <a class="nav-link<?php echo ($service['smsConfig'] == null) ? ' active' : ''; ?>" data-toggle="tab" href="#servicePaymentsPaypal<?php echo $service['id']; ?>" role="tab"><i class="fa fa-paypal" aria-hidden="true"></i> PayPal</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>

                                    <div class="tab-content">

                                        <?php if ($service['smsConfig'] != null): ?>
                                            <div class="tab-pane fade show active" id="servicePaymentsSms<?php echo $service['id']; ?>" role="tabpanel">
                                                <table class="table table-responsive d-md-table mb-0">
                                                    <tbody>
                                                        <?php switch ($service['smsConfig']['operator']) {
                                                            case 1:
                                                                echo '
                                                                    <tr>
                                                                        <td class="font-weight-bold">Operator SMS:</td>
                                                                        <td class="text-right">MicroSMS.pl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Kanał SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsChannel'] . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">ID Kanału SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsChannelId'] . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Numer SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsNumber']  . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Koszt SMS:</td>
                                                                        <td class="text-right">' . getPriceNetto($service['smsConfig']['smsNumber'], 1)  . ' zł (' . getPriceBrutto($service['smsConfig']['smsNumber'], 1)  . ' zł z VAT)</td>
                                                                    </tr>
                                                                ';
                                                                break;
                                                            case 2:
                                                                echo '
                                                                    <tr>
                                                                        <td class="font-weight-bold">Operator SMS:</td>
                                                                        <td class="text-right">Lvlup.pro</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Numer SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsNumber']  . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Koszt SMS:</td>
                                                                        <td class="text-right">' . getPriceNetto($service['smsConfig']['smsNumber'], 2)  . ' zł (' . getPriceBrutto($service['smsConfig']['smsNumber'], 2)  . ' zł z VAT)</td>
                                                                    </tr>
                                                                ';
                                                                break;
                                                            case 3:
                                                                echo '
                                                                    <tr>
                                                                        <td class="font-weight-bold">Operator SMS:</td>
                                                                        <td class="text-right">Homepay.pl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Identyfikator konta SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsChannel'] . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">ID konta SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsChannelId'] . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Numer SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsNumber']  . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Koszt SMS:</td>
                                                                        <td class="text-right">' . getPriceNetto($service['smsConfig']['smsNumber'], 3)  . ' zł (' . getPriceBrutto($service['smsConfig']['smsNumber'], 3)  . ' zł z VAT)</td>
                                                                    </tr>
                                                                ';
                                                                break;
                                                            case 3:
                                                                echo '
                                                                    <tr>
                                                                        <td class="font-weight-bold">Operator SMS:</td>
                                                                        <td class="text-right">Pukawka.pl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Numer SMS:</td>
                                                                        <td class="text-right">' . $service['smsConfig']['smsNumber']  . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="font-weight-bold">Koszt SMS:</td>
                                                                        <td class="text-right">' . getPriceNetto($service['smsConfig']['smsNumber'], 4)  . ' zł (' . getPriceBrutto($service['smsConfig']['smsNumber'], 4)  . ' zł z VAT)</td>
                                                                    </tr>
                                                                ';
                                                                break;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($service['paypalCost'] != null): ?>
                                            <div class="tab-pane fade show active" id="servicePaymentsPaypal<?php echo $service['id']; ?>" role="tabpanel">
                                                <table class="table table-responsive d-md-table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="font-weight-bold">Koszt:</td>
                                                            <td class="text-right"><?php echo number_format(round($service['paypalCost'], 2), 2, ',', ' '); ?> zł</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="serviceSettings<?php echo $service['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fa fa-gears" aria-hidden="true"></i> Ustawienia usługi <?php echo $service['name']; ?> (ID: #<?php echo $service['id']; ?>)</h5>
                                    <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#serviceSettingDescription<?php echo $service['id']; ?>" role="tab"><i class="fa fa-align-left" aria-hidden="true"></i> Opis</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#serviceSettingImage<?php echo $service['id']; ?>" role="tab"><i class="fa fa-picture-o" aria-hidden="true"></i> Obrazek</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#serviceSettingCommands<?php echo $service['id']; ?>" role="tab"><i class="fa fa-terminal" aria-hidden="true"></i> Komendy</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">

                                        <div class="tab-pane fade show active" id="serviceSettingDescription<?php echo $service['id']; ?>" role="tabpanel">
                                            <?php echo $service['description']; ?>
                                        </div>

                                        <div class="tab-pane fade text-center" id="serviceSettingImage<?php echo $service['id']; ?>" role="tabpanel">
                                            <img class="img-fluid" src="<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?> image" />
                                        </div>

                                        <div class="tab-pane fade" id="serviceSettingCommands<?php echo $service['id']; ?>" role="tabpanel">
                                            <table class="table table-responsive d-md-table mb-0 text-center">
                                                <tbody>
                                                    <?php foreach ($service['commands'] as $command): ?>
                                                        <tr>
                                                            <td><?php echo $command; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->uri->rsegment('1') == "vouchers"): ?>
            <div id="voucherAddModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Wygeneruj nowy voucher</h5>
                            <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/vouchers/create')) : ''; ?>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-6 offset-md-3">

                                    <div class="form-group">
                                        <label for="voucherService">Usługa<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <select class="form-control" id="voucherService" name="voucherService">
                                            <option disabled selected>Brak</option>
                                            <?php if ($services): ?>
                                                <?php foreach ($services as $service): ?>
                                                    <option value="<?php echo $service['id']; ?>">Serwer <?php echo $service['server']; ?> &gt; <?php echo $service['name']; ?> (ID: #<?php echo $service['id']; ?>)</option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="voucherAmount">Ilość voucherów<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <select class="form-control" id="voucherAmount" name="voucherAmount">
                                            <?php for ($i = 1; $i <= 20; $i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                </div>


                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-outline-success"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Wygeneruj voucher</button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->uri->rsegment('1') == "pages"): ?>
            <div id="pageAddModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nową stronę</h5>
                            <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/pages/create')) : ''; ?>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-6 offset-md-3">

                                    <div class="form-group">
                                        <label for="pageTitle">Tytuł strony<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                        <input type="text" class="form-control" id="pageTitle" name="pageTitle" />
                                    </div>

                                    <div class="form-group">
                                        <label for="pageLink">Odnośnik</label>
                                        <input type="text" class="form-control" aria-describedby="pageLinkHelp" id="pageLink" name="pageLink" />
                                        <small id="pageLinkHelp" class="form-text text-muted">Umieść tu link, do którego ma przekierować przycisk w nawigacji. Jeżeli to pole jest puste wyświetli się zawartość pola "Zawartość strony".</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="pageIcon">Ikona</label>
                                        <input type="text" class="form-control" aria-describedby="pageIconHelp" id="pageIcon" name="pageIcon" />
                                        <small id="pageIconHelp" class="form-text text-muted">Tutaj mozesz wpisać klasę ikony FontAwesome. Będzie się ona wyświetlać obok tytułu strony w nawigacji oraz na samej stronie. Przykład: "fa-adress-book". Listę dostępnych ikon możesz znaleźć <a href="http://fontawesome.io/icons/">tutaj</a>.</small>
                                    </div>


                                </div>

                            </div>

                            <div class="form-group mt-md-5">
                                <label for="pageContent">Zawartość strony</label>
                                <textarea class="form-control" id="pageContent" name="pageContent" rows="50"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-outline-success"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj stronę</button>
                        </div>
                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                    </div>
                </div>
            </div>

            <?php if ($pages): ?>
                <?php foreach ($pages as $page): ?>
                    <?php if ($page['link'] == null): ?>
                        <div id="pagePreview<?php echo $page['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?php echo ($page['icon'] != null) ? '<i class="fa ' . $page['icon'] . '" aria-hidden="true"></i>' : ''; ?> Podgląd strony <strong><?php echo $page['title']; ?></strong></h5>
                                        <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $page['content']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (($this->uri->rsegment('1') == "shop") || $this->uri->rsegment('1') == "home"): ?>
        <div id="voucherModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-key" aria-hidden="true"></i> Zrealizuj voucher</h5>
                        <button type="button" class="close text-gray-dark" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('checkout/voucherRedeem')) : ''; ?>
                        <div class="modal-body">

                            <input type="hidden" name="serverName" value="<?php echo $server['name']; ?>" />

                            <div class="form-group">
                                <label for="userName">Twój nick z serwera:</label>
                                <input type="text" class="form-control" id="userName" name="userName" />
                            </div>

                            <div class="form-group">
                                <label for="smsCode">Kod vouchera:</label>
                                <input type="text" class="form-control" id="voucherCode" name="voucherCode" />
                            </div>

                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-outline-success" onclick="$(this).children('i').attr('class','fa fa-cog fa-spin');"><i class="fa fa-check" aria-hidden="true"></i> Zrealizuj voucher</button>
                        </div>
                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- /Modals -->

        <?php $this->load->view('components/Scripts'); ?>
    </body>
</html>