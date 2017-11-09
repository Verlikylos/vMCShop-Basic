<!--
 * Created with ♥ by Verlikylos on 07.11.2017 20:47.
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
                    <li class="breadcrumb-item active">Edycja <?php switch ($this->uri->rsegment('2')) { case "server": echo 'serwera ' . $server['name']; break; case "service": echo 'usługi ' . $service['name'] . " (ID: #" . $service['id'] . ")"; break; case "page": echo '?? ' . $page['title']; break; } ?></li>
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

                                <?php if (strpos(base_url() , 'vmcshop.pro') != true) { switch ($this->uri->rsegment('2')) { case "server": echo form_open_multipart(base_url('panel/edit/serverSave')); break; case "service": echo form_open_multipart(base_url('panel/edit/serviceSave')); break; case "page": echo form_open(base_url('panel/edit/pageSave')); break; } } ?>

                                    <div class="row mt-3 mt-sm-0">

                                        <div class="col-sm-12 col-md-6 text-center text-md-left">
                                            <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edycja <?php switch ($this->uri->rsegment('2')) { case "server": echo 'serwera ' . $server['name']; break; case "service": echo 'usługi ' . $service['name'] . " (ID: #" . $service['id'] . ")"; break; case "page": echo 'strony ' . $page['title']; break; } ?></h4>
                                        </div>

                                        <div class="col-sm-12 col-md-6 text-center text-md-right">
                                            <button type="submit" class="btn btn-outline-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Zapisz</button>
                                        </div>

                                    </div>

                                    <div class="card card-outline-primary mt-3">
                                        <div class="card-block pb-2">
                                            <div class="row">

                                                <?php if ($this->uri->rsegment('2') == "server"): ?>
                                                    <div class="col-sm-12 col-md-7">

                                                        <input type="hidden" name="serverId" value="<?php echo $server['id']; ?>" />

                                                        <div class="form-group">
                                                            <label for="serverName">Nazwa serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="serverName" name="serverName" value="<?php echo $server['name']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Obrazek serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label><br />
                                                            <label class="custom-file d-block">
                                                                <input data-toggle="custom-file" data-target="#serverImageLabel" aria-describedby="serverImageHelp" type="file" name="serverImage" accept="image/png" class="custom-file-input">
                                                                <span id="serverImageLabel" class="custom-file-control custom-file-name" data-content="Wybierz obrazek..."></span>
                                                            </label>
                                                            <small id="serverImageHelp" class="form-text text-muted">Pozostaw to pole puste w celu zachowania obrazka.</small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serverIp">Adres IP serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="serverIp" name="serverIp" value="<?php echo $server['ip']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serverPort">Port serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="serverPort" name="serverPort" value="<?php echo $server['port']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serverRconPort">Port RCON serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="serverRconPort" name="serverRconPort" value="<?php echo $server['rcon_port']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serverRconPass">Hasło RCON serwera<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="serverRconPass" name="serverRconPass" value="<?php echo $server['rcon_pass']; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-5">
                                                        <h6 class="font-weight-bold">Informacja:</h6>
                                                        <p>Wszelkie dane potrzebne do uzupełnienia formularza obok znajdziesz w pliku <strong>"server.properties"</strong> w katalogu głównym serwera. Kolejno zaczynając od Adresu IP będą to linijki o nazwach: <strong>"server-ip"</strong>, <strong>"server-port"</strong>, <strong>"rcon.port"</strong> oraz <strong>"rcon.password"</strong>.</p>
                                                    </div>
                                                <?php elseif ($this->uri->rsegment('2') == "service"): ?>
                                                    <div class="col-sm-12 col-md-7">

                                                        <input type="hidden" name="serviceId" value="<?php echo $service['id']; ?>" />

                                                        <div class="form-group">
                                                            <label for="serviceName">Nazwa usługi<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="serviceName" name="serviceName" value="<?php echo $service['name']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serviceServer">Serwer<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <select class="form-control" id="serviceServer" name="serviceServer">
                                                                <?php foreach ($servers as $server): ?>
                                                                    <option value="<?php echo $server['id']; ?>" <?php echo ($service['server'] == $server['id']) ? 'selected' : ''; ?>>Serwer <?php echo $server['name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serviceDesc">Opis usługi<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <textarea class="form-control" id="serviceDesc" name="serviceDesc" rows="15"><?php echo $service['description']; ?></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Obrazek usługi<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label><br />
                                                            <label class="custom-file d-block">
                                                                <input data-toggle="custom-file" data-target="#serviceImageLabel" type="file" aria-describedby="serviceImageHelp" name="serviceImage" accept="image/png" class="custom-file-input">
                                                                <span id="serviceImageLabel" class="custom-file-control custom-file-name" data-content="Wybierz obrazek..."></span>
                                                            </label>
                                                            <small id="serviceImageHelp" class="form-text text-muted">Pozostaw to pole puste w celu zachowania obrazka.</small>
                                                        </div>

                                                        <?php if ($settings['smsOperator'] != 0): ?>
                                                            <?php switch ($settings['smsOperator']) {
                                                                case "1":
                                                                    echo '
                                                                        <div class="form-group">
                                                                            <label for="serviceId">Kanał SMS</label>
                                                                            <input type="text" class="form-control" id="serviceChannel" name="serviceSmsChannel" value="' . $service['smsConfig']['smsChannel'] . '" />
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label for="serviceChannelId">ID kanału SMS</label>
                                                                            <input type="text" class="form-control" id="serviceChannelId" name="serviceSmsChannelId" value="' . $service['smsConfig']['smsChannelId'] . '" />
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label for="serviceSmsNumber">Numer SMS</label>
                                                                            <select class="form-control" id="serviceSmsNumber" name="serviceSmsNumber">
                                                                                <option value="" selected>Brak</option>
                                                                    ';
                                                                    foreach (getSmsNumbers(1) as $number => $cost) {
                                                                        echo '<option value="' . $number . '" ' . (($service['smsConfig']['smsNumber'] == $number) ? 'selected' : '') . '>' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 1) . ' zł z VAT)</option>';
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
                                                                        echo '<option value="' . $number . '" ' . (($service['smsConfig']['smsNumber'] == $number) ? 'selected' : '') . ' >' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 2) . ' zł z VAT)</option>';
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
                                                                            <input type="text" class="form-control" id="serviceChannel" name="serviceSmsChannel" value="' . $service['smsConfig']['smsChannel'] . '" />
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label for="serviceChannelId">ID konta SMS</label>
                                                                            <input type="text" class="form-control" id="serviceChannelId" name="serviceSmsChannelId" value="' . $service['smsConfig']['smsChannelId'] . '" />
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label for="serviceSmsNumber">Numer SMS</label>
                                                                            <select class="form-control" id="serviceSmsNumber" name="serviceSmsNumber">
                                                                                <option selected>Brak</option>
                                                                    ';
                                                                    foreach (getSmsNumbers(3) as $number => $cost) {
                                                                        echo '<option value="' . $number . '" ' . (($service['smsConfig']['smsNumber'] == $number) ? 'selected' : '') . '>' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 3) . ' zł z VAT)</option>';
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
                                                                        echo '<option value="' . $number . '" ' . (($service['smsConfig']['smsNumber'] == $number) ? 'selected' : '') . '>' . $number . ' - ' . $cost . ' zł (' . getPriceBrutto($number, 4) . ' zł z VAT)</option>';
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
                                                            <input type="text" class="form-control" id="servicePaypalCost" name="servicePaypalCost" value="<?php echo $service['paypalCost']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="serviceCmds">Polecenia do wykonania<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <textarea class="form-control" id="serviceCmds" name="serviceCmds" rows="5"><?php echo $service['commands']; ?></textarea>
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
                                                <?php elseif ($this->uri->rsegment('2') == "page"): ?>
                                                    <div class="col-sm-12 col-md-6 offset-md-3">

                                                        <input type="hidden" name="pageId" value="<?php echo $page['id']; ?>" />

                                                        <div class="form-group">
                                                            <label for="pageTitle">Tytuł strony<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                            <input type="text" class="form-control" id="pageTitle" name="pageTitle" value="<?php echo $page['title']; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="pageLink">Odnośnik</label>
                                                            <input type="text" class="form-control" aria-describedby="pageLinkHelp" id="pageLink" name="pageLink" value="<?php echo $page['link']; ?>" />
                                                            <small id="pageLinkHelp" class="form-text text-muted">Umieść tu link, do którego ma przekierować przycisk w nawigacji. Jeżeli to pole jest puste wyświetli się zawartość pola "Zawartość strony".</small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="pageIcon">Ikona</label>
                                                            <input type="text" class="form-control" aria-describedby="pageIconHelp" id="pageIcon" name="pageIcon" value="<?php echo $page['icon']; ?>" />
                                                            <small id="pageIconHelp" class="form-text text-muted">Tutaj mozesz wpisać klasę ikony FontAwesome. Będzie się ona wyświetlać obok tytułu strony w nawigacji oraz na samej stronie. Przykład: "fa-adress-book". Listę dostępnych ikon możesz znaleźć <a href="http://fontawesome.io/icons/">tutaj</a>.</small>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-12">

                                                        <div class="form-group mt-md-5">
                                                            <label for="pageContent">Zawartość strony</label>
                                                            <textarea class="form-control" id="pageContent" name="pageContent" rows="50"><?php echo $page['content']; ?></textarea>
                                                        </div>

                                                    </div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                            </div>

                        </div>

                    </div>
                </div>

            </div>