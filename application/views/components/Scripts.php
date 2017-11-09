<!--
 * Created with ♥ by Verlikylos on 11.09.2017 21:03.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
-->

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/tether.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sweetalert2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/app.js'); ?>"></script>
<script type="text/javascript" src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

<?php if (($this->uri->rsegment('1') == "servers") || ($this->uri->rsegment('1') == "services")): ?>
    <script type="text/javascript">
        function uSure(f = null) {
            var bg = $('.bg-faded').css('background');
            swal({
                title: 'Jesteś pewien?',
                text: '<?php echo ($this->uri->rsegment('1') == "servers") ? "Potwierdzenie tej operacji usunie serwer i wszystkie powiązane z nim usługi, vouchery oraz historię zakupów!" : "Potwierdzenie tej operacji usunie usługę i wszystkie powiązane z nią vouchery oraz historię zakupów!"; ?>',
                width: 600,
                padding: 100,
                background: bg,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak, usuń!',
                cancelButtonText: 'Anuluj'
            }).then(function () {
                swal({
                    title: '<?php echo ($this->uri->rsegment('1') == "servers") ? "Trwa usuwanie serwera..." : "Trwa usuwanie usługi..."; ?>',
                    width: 600,
                    padding: 100,
                    background: bg,
                    onOpen: function () {
                        swal.showLoading()
                    }
                });
                if (f != null) {
                    setTimeout(function(){ f.form.submit(); }, 1000);
                }
            });
        }
    </script>
<?php endif; ?>
<?php if (($this->uri->rsegment('1') == "payments") || ($this->uri->rsegment('1') == "settings") || ($this->uri->rsegment('1') == "account")): ?>
    <script type="text/javascript">
        function showLoading( msg = 'Trwa zapisywanie ustawień...', f = null) {
            var bg = $('.bg-faded').css('background');
            swal({
                title: msg,
                width: 600,
                padding: 100,
                background: bg,
                onOpen: function () {
                    swal.showLoading()
                }
            });
            if (f != null) {
                setTimeout(function(){ f.form.submit(); }, 1000);
            }
        }
    </script>
<?php endif; ?>
<?php if (isset($_SESSION['messageSuccess'])): ?>
    <script type="text/javascript">
        var bg = $('.bg-faded').css('background');
        swal({
            type: 'success',
            html: '<div class="mb-5"><?php echo $_SESSION['messageSuccess']; ?></div>',
            showCloseButton: true,
            confirmButtonText: '<i class="fa fa-times-circle" aria-hidden="true"></i> Zamknij',
            width: 600,
            padding: 50,
            background: bg
        })
    </script>
<?php endif; ?>
<?php unset($_SESSION['messageSuccess']); ?>
<?php if (isset($_SESSION['messageDanger'])): ?>
    <script type="text/javascript">
        var bg = $('.bg-faded').css('background');
        swal({
            type: 'error',
            html: '<div class="mb-5"><?php echo $_SESSION['messageDanger']; ?></div>',
            showCloseButton: true,
            confirmButtonText: '<i class="fa fa-times-circle" aria-hidden="true"></i> Zamknij',
            width: 600,
            padding: 50,
            background: bg
        })
    </script>
<?php endif; ?>
<?php unset($_SESSION['messageDanger']); ?>
<?php if (($this->uri->rsegment('1') == "paypal") || ($this->uri->rsegment('1') == "logs") || ($this->uri->rsegment('1') == "home") || ($this->uri->rsegment('1') == "purchases") || ($this->uri->rsegment('1') == "shop") || ($this->uri->rsegment('1') == "settings") || ($this->uri->rsegment('1') == "payments") || ($this->uri->rsegment('1') == "account")): ?>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
<?php endif; ?>
<?php if ($this->uri->rsegment('1') == "paypal" && $this->uri->rsegment('2') == "index"): ?>
    <script type="text/javascript">
        $('#paypalForm').submit();
    </script>
<?php endif; ?>
<?php if (($this->uri->rsegment('1') == "services") || (($this->uri->rsegment('1') == "edit") && ($this->uri->rsegment('2') == "service"))): ?>
    <script type="text/javascript">
        tinymce.init({
            selector: '#serviceDesc',
            browser_spellcheck: true,
            branding: false,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor'
            ],
            menubar: '',
            toolbar: 'undo redo | format | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link | fullscreen preview'
        });
    </script>
<?php endif; ?>
<?php if (($this->uri->rsegment('1') == "pages") || (($this->uri->rsegment('1') == "edit") && ($this->uri->rsegment('2') == "page"))): ?>
    <script type="text/javascript">
        tinymce.init({
            selector: '#pageContent',
            browser_spellcheck: true,
            height: 300,
            branding: false,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor'
            ],
            menubar: '',
            toolbar: 'undo redo | format | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link | fullscreen preview'
        });
    </script>
<?php endif; ?>
<?php if ($this->uri->rsegment('1') == "settings"): ?>
    <script type="text/javascript">
        tinymce.init({
            selector: '#settingPageBroadcast',
            browser_spellcheck: true,
            height: 150,
            branding: false,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor'
            ],
            menubar: '',
            toolbar: 'undo redo | format | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | link fullscreen preview'
        });
    </script>
<?php endif; ?>
