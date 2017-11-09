<!--
 * Created with ♥ by Verlikylos on 11.10.2017 19:47.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<div class="container">

    <div id="header">

        <div class="row">

            <div class="col-sm-6">
                <?php if (substr($settings['pageLogo'], 0, 4) == "http"): ?>
                    <a href="<?php echo base_url(); ?>"><img class="img-fluid" src="<?php echo $settings['pageLogo']; ?>" alt="Page Logo" /></a>
                <?php else: ?>
                    <h1><a class="text-custom" href="<?php echo base_url(); ?>"><?php echo $settings['pageLogo']; ?></a></h1>
                <?php endif; ?>
            </div>

            <div class="col-sm-6">

            </div>

        </div>

    </div>

    <nav class="navbar navbar-toggleable navbar-inverse bg-primary rounded">

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item ml-0<?php echo ($this->uri->rsegment('1') == "home") ? ' active' : '' ?>">
                    <a class="nav-link text-custom" href="<?php echo ($this->uri->rsegment('1') == "home") ? '#' : base_url() ?>"><i class="fa fa-home" aria-hidden="true"></i> Strona Główna</a>
                </li>
                <?php if ($pages): ?>
                    <?php foreach ($pages as $page): ?>
                        <?php if ($page['active'] == "1"): ?>
                            <?php if ($page['link'] == null): ?>
                                <li class="nav-item ml-0<?php echo ($this->uri->rsegment('3') == str_replace(' ', '-', $page['title'])) ? ' active' : '' ?>">
                                    <a class="nav-link text-custom" href="<?php echo ($this->uri->rsegment('1') == str_replace(' ', '-', $page['title'])) ? '#' : base_url('page/' . str_replace(' ', '-', $page['title'])) ?>"><?php echo ($page['icon'] != null) ? '<i class="fa ' . $page['icon'] . '" aria-hidden="true"></i>' : ''; ?> <?php echo $page['title']; ?></a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item ml-0">
                                    <a class="nav-link text-custom" href="<?php echo $page['link']; ?>"><?php echo ($page['icon'] != null) ? '<i class="fa ' . $page['icon'] . '" aria-hidden="true"></i>' : ''; ?> <?php echo $page['title']; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php if ($settings['pageBroadcast'] != null): ?>
        <div class="card card-outline-primary bg-faded mt-3">
            <div class="card-block">
                <?php echo $settings['pageBroadcast']; ?>
            </div>
        </div>
    <?php endif; ?>

</div>