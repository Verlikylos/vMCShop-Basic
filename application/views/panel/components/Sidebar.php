<!--
 * Created with ♥ by Verlikylos on 12.10.2017 16:57.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "dashboard") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "dashboard") ? "#" : base_url('panel/dashboard'); ?>"><i class="fa fa-desktop" aria-hidden="true"></i> Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "users") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "users") ? "#" : base_url('panel/users'); ?>"><i class="fa fa-users" aria-hidden="true"></i> Użytkownicy ACP</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "servers") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "servers") ? "#" : base_url('panel/servers'); ?>"><i class="fa fa-server" aria-hidden="true"></i> Serwery</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "services") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "services") ? "#" : base_url('panel/services'); ?>"><i class="fa fa-diamond" aria-hidden="true"></i> Usługi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "vouchers") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "vouchers") ? "#" : base_url('panel/vouchers'); ?>"><i class="fa fa-key" aria-hidden="true"></i> Vouchery</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "pages") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "pages") ? "#" : base_url('panel/pages'); ?>"><i class="fa fa-file-code-o" aria-hidden="true"></i> Własne strony</a>
    </li>
    <li class="nav-item">
        &nbsp;
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "purchases") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "purchases") ? "#" : base_url('panel/purchases'); ?>"><i class="fa fa-history" aria-hidden="true"></i> Historia zakupów</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "logs") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "logs") ? "#" : base_url('panel/logs'); ?>"><i class="fa fa-database" aria-hidden="true"></i> Logi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "console") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "console") ? "#" : base_url('panel/console'); ?>"><i class="fa fa-terminal" aria-hidden="true"></i> Konsola</a>
    </li>
    <li class="nav-item">
        &nbsp;
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "account") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "account") ? "#" : base_url('panel/account'); ?>"><i class="fa fa-user" aria-hidden="true"></i> Ustawienia konta</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "payments") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "payments") ? "#" : base_url('panel/payments'); ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Ustawienia płatności</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($this->uri->rsegment('1') == "settings") ? "active" : ""; ?>" href="<?php echo ($this->uri->rsegment('1') == "settings") ? "#" : base_url('panel/settings'); ?>"><i class="fa fa-gears" aria-hidden="true"></i> Ustawienia strony</a>
    </li>
    <li class="nav-item">
        &nbsp;<a class="nav-link" href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Wyloguj się</a>
    </li>
</ul>