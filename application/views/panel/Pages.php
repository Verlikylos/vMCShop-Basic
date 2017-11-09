<!--
 * Created with ♥ by Verlikylos on 13.10.2017 20:08.
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
                    <li class="breadcrumb-item active">Własne strony</li>
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
                                        <h4><i class="fa fa-file-code-o" aria-hidden="true"></i> Własne strony</h4>
                                    </div>

                                    <div class="col-sm-12 col-md-6 text-center text-md-right">
                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#pageAddModal"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Dodaj nową stronę</button>
                                    </div>

                                </div>

                                <div class="card card-outline-primary mt-3">
                                    <div class="card-block pb-2">

                                        <?php if (!$pages): ?>

                                            <h4 class="text-center pb-1"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aktualnie nie ma żadnych stron do wyświetlenia!</h4>

                                        <?php else: ?>
                                            <table class="table table-responsive d-md-table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Typ</th>
                                                        <th class="text-center">Tytuł</th>
                                                        <th class="text-center">Ikona</th>
                                                        <th class="text-center">Zawartość strony/Odnośnik</th>
                                                        <th class="text-center">Aktywne</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($pages as $page): ?>
                                                        <tr>
                                                            <td><?php echo ($page['link'] != null) ? '<span class="badge badge-success">Odnośnik</span>' : '<span class="badge badge-primary">Strona</span>'; ?></td>
                                                            <td><?php echo $page['title']; ?></td>
                                                            <td><?php echo ($page['icon'] != null) ? '<i class="fa ' . $page['icon'] . ' fa-2x" aria-hidden="true"></i>' : 'Brak'; ?></td>
                                                            <td><?php echo ($page['link'] != null) ? '<a class="btn btn-sm btn-info" href="' . $page['link'] . '" style="margin-top: -3px;"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Przejdź</a>' : '<button type="button"  data-toggle="modal" data-target="#pagePreview' . $page['id'] . '" class="btn btn-sm btn-info" style="margin-top: -3px;"><i class="fa fa-search" aria-hidden="true"></i> Podgląd</button>'; ?></td>
                                                            <td>
                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/pages/changeStatus')) : ''; ?>
                                                                    <input type="hidden" name="pageId" value="<?php echo $page['id']; ?>" />

                                                                    <label class="custom-control custom-checkbox" style="margin: 0;">
                                                                        <input type="checkbox" class="custom-control-input" name="pageStatus" onChange="this.form.submit()" <?php echo ($page['active'] == 0) ? '' : 'checked' ?>>
                                                                        <span class="custom-control-indicator"></span>
                                                                    </label>
                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>
                                                            </td>
                                                            <td class="td-actions">

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/edit/page'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="pageId" value="<?php echo $page['id']; ?>">

                                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                                                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/pages/remove'), 'class="inline-form"') : ''; ?>

                                                                <input type="hidden" name="pageId" value="<?php echo $page['id']; ?>">

                                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>

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