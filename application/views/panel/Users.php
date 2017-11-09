<!--
 * Created with ♥ by Verlikylos on 13.10.2017 14:58.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

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
                    <li class="breadcrumb-item active">Użytkownicy ACP</li>
                </ol>

                <?php if (isset($_SESSION['newUserInfo'])): ?>
                    <div class="card card-info mb-3 mt-3 text-center" style="color: #ffffff;">
                        <div class="card-block">
                            <p class="mb-0">
                                <?php echo $_SESSION['newUserInfo']; ?>
                            </p>
                        </div>
                    </div>
                    <?php unset($_SESSION['newUserInfo']); ?>
                <?php endif; ?>

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
                                        <h4><i class="fa fa-users" aria-hidden="true"></i> Użytkownicy ACP</h4>
                                    </div>

                                    <div class="col-sm-12 col-md-6 text-center text-md-right">
                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#userAddModal"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nowego użytkownika</button>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$users): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych użytkowników do wyświetlenia!</h4>

                                        <?php else: ?>

                                            <table class="table table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nazwa</th>
                                                        <th class="text-center">Ostatnie IP</th>
                                                        <th class="text-center">Ostatnie logowanie</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($users as $user): ?>
                                                        <tr>
                                                            <td><?php echo $user['name']; ?></td>
                                                            <td><?php echo ($user['lastIp'] != null) ? $user['lastIp'] : 'Brak'; ?></td>
                                                            <td><?php echo ($user['lastLogin'] != null) ? formatDate($user['lastLogin']) : 'Brak'; ?></td>
                                                            <?php if ($user['name'] != $_SESSION['name']): ?>
                                                                <td class="td-actions">

                                                                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/users/remove'), 'class="inline-form"') : ''; ?>

                                                                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">

                                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>

                                                                    <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                                </td>
                                                            <?php else: ?>
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

                        </div>

                    </div>
                </div>

            </div>