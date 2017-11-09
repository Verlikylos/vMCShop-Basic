<!--
 * Created with ♥ by Verlikylos on 02.11.2017 01:41.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<body>

<?php $this->load->view('components/Navigation'); ?>

<div class="container">

    <div class="row">

        <div class="col-sm-12">

            <div class="card card-outline-primary bg-faded space-box" style="margin-top: 1em;">
                <div class="card-block">

                    <h3><?php echo ($page['icon'] != null) ? '<i class="fa ' . $page['icon'] . '" aria-hidden="true"></i>' : ''; ?> <?php echo $page['title']; ?></h3>
                    <hr />

                    <div class="mt-5">
                        <?php echo $page['content']; ?>
                    </div>

                </div>
            </div>

        </div>