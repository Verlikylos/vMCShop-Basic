<!--
 * Created with ♥ by Verlikylos on 25.10.2017 22:07.
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
                    <li class="breadcrumb-item active">Konsola</li>
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
                                        <h4><i class="fa fa-terminal" aria-hidden="true"></i> Konsola</h4>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$servers): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych serwerów do wyświetlenia!</h4>

                                        <?php else : ?>
                                            <ul id="consoleTabs" class="nav nav-tabs nav-justified" role="tablist">

                                                <?php $i = 0; ?>
                                                <?php foreach ($servers as $server): ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link<?php if ($consoleServerActive == $server['name']) { echo ' active'; } ?>" data-toggle="tab" href="#consoleServer<?php echo $server['id']; ?>" role="tab">Serwer <?php echo $server['name']; ?> <?php echo (isset($server['status'])) ? '<span class="badge badge-success">Online</span>' : '<span class="badge badge-danger">Offline</span>'; ?></a>
                                                    </li>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>

                                            </ul>

                                            <div class="tab-content mt-2">

                                                <?php $i = 0; ?>
                                                <?php foreach ($servers as $server): ?>
                                                    <div class="tab-pane fade<?php if ($consoleServerActive == $server['name']) { echo ' show active'; } ?>" id="consoleServer<?php echo $server['id']; ?>" role="tabpanel">

                                                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('admin/consoleSendCommands')) : ''; ?>

                                                        <div class="form-group">
                                                            <textarea class="form-control" id="consoleOutputServer<?php echo $server['id']; ?>" name="consoleOutputServer<?php echo $server['id']; ?>" rows="15" style="font-family: 'Ubuntu', monospace; color: #0d0d0d; resize: none;" readonly><?php echo (isset($_SESSION['consoleOutput' . $server['id']])) ? $_SESSION['consoleOutput' . $server['id']] : ''; ?></textarea>
                                                        </div>

                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="consoleInputServer<?php echo $server['id']; ?>" name="consoleInputServer<?php echo $server['id']; ?>" style="border-radius: 4px;" autocomplete="off" required />
                                                            <?php if (isset($server['status'])): ?>
                                                                <button type="submit" class="btn btn-outline-success ml-1"><i class="fa fa-share" aria-hidden="true"></i> Wyślij polecenie na serwer</button>
                                                            <?php else: ?>
                                                                <button type="button" class="btn btn-outline-danger disabled ml-1"><i class="fa fa-share" aria-hidden="true"></i> Wyślij polecenie na serwer</button>
                                                            <?php endif; ?>
                                                        </div>

                                                        <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                    </div>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>

                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>