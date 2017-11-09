<!--
 * Created with ♥ by Verlikylos on 13.10.2017 15:31.
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
                    <li class="breadcrumb-item active">Serwery</li>
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

                                    <div class="col-sm-12 col-md-6 text-center text-md-left">
                                        <h4><i class="fa fa-server" aria-hidden="true"></i> Serwery</h4>
                                    </div>

                                    <div class="col-sm-12 col-md-6 text-center text-md-right">
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#serverAddModal"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nowy serwer</button>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$servers): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych serwerów do wyświetlenia!</h4>

                                        <?php else: ?>

                                            <table class="table table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nazwa</th>
                                                        <th class="text-center">Obrazek</th>
                                                        <th class="text-center">Adres IP</th>
                                                        <th class="text-center">Port</th>
                                                        <th class="text-center">Port RCON</th>
                                                        <th class="text-center">Hasło RCON</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($servers as $server): ?>

                                                        <tr>
                                                            <td><?php echo $server['name']; ?></td>
                                                            <td><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#serverImage<?php echo $server['id']; ?>" style="margin-top: -3px;"><i class="fa fa-search" aria-hidden="true"></i> Podgląd</button></td>
                                                            <td><?php echo $server['ip']; ?></td>
                                                            <td><?php echo $server['port']; ?></td>
                                                            <td><?php echo $server['rcon_port']; ?></td>
                                                            <td><?php echo $server['rcon_pass']; ?></td>
                                                            <td class="td-actions">

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/edit/server'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="serverId" value="<?php echo $server['id']; ?>">

                                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>


                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/servers/remove'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="serverId" value="<?php echo $server['id']; ?>">

                                                                <button type="button" onclick="uSure(this);" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                            </td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>