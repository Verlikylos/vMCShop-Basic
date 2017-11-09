<!--
 * Created with ♥ by Verlikylos on 14.10.2017 18:09.
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
                    <li class="breadcrumb-item active">Ustawienia strony</li>
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

                            <div class="col-sm-12 col-md-9 text-center">

                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_open(base_url('panel/settings/update')) : ''; ?>

                                    <div class="row mt-3 mt-sm-0 text-left">

                                        <div class="col-sm-12 col-md-6 text-center text-md-left">
                                            <h4><i class="fa fa-gears" aria-hidden="true"></i> Ustawienia strony</h4>
                                        </div>

                                        <div class="col-sm-12 col-md-6 text-center text-md-right">
                                            <button type="button" class="btn btn-outline-success" onclick="showLoading('Trwa zapisywanie ustawień...', this)"><i class="fa fa-floppy-o" aria-hidden="true"></i> Zapisz ustawienia</button>
                                        </div>

                                    </div>

                                    <div class="card card-outline-primary mt-3 text-left">
                                        <div class="card-block pb-2">

                                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#pageGeneral" role="tab"><i class="fa fa-gear" aria-hidden="true"></i> Ogólne</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#pageVoucher" role="tab"><i class="fa fa-key" aria-hidden="true"></i> Vouchery</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#pageLayout" role="tab"><i class="fa fa-columns" aria-hidden="true"></i> Układ i wygląd strony</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="pageGeneral" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 offset-md-3 pt-3">

                                                            <div class="form-group">
                                                                <label for="settingPageTitle">Tytuł strony<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                <input type="text" class="form-control" id="settingPageTitle" name="settingPageTitle" value="<?php echo $settings['pageTitle']; ?>" aria-describedby="settingPageTitleHelp" autocomplete="off" required />
                                                                <small id="settingPageTitleHelp" class="form-text text-muted">Używany w tagu &lt;title&gt;. Pojawia się w nazwie karty przeglądarki.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingPageDesc">Opis strony</label>
                                                                <textarea class="form-control" id="settingPageDesc" name="settingPageDesc" aria-describedby="settingPageDescHelp" rows="3"><?php echo $settings['pageDesc']; ?></textarea>
                                                                <small id="settingPageDescHelp" class="form-text text-muted">Wyświetlany przez wyszukiwarki internetowe.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingPageTags">Tagi strony</label>
                                                                <input type="text" class="form-control" id="settingPageTags" name="settingPageTags" value="<?php echo $settings['pageTags']; ?>" aria-describedby="settingPageTagsHelp" autocomplete="off" />
                                                                <small id="settingPageTagsHelp" class="form-text text-muted">Pozycjonują stronę w wyszukiwarce internetowej. Oddzielane przecinkami bez spacji.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingFavicon">Ikona ulubionych</label>
                                                                <input type="text" class="form-control" id="settingFavicon" name="settingFavicon" value="<?php echo $settings['favicon']; ?>" aria-describedby="settingFaviconHelp" autocomplete="off" />
                                                                <small id="settingFaviconHelp" class="form-text text-muted">Link do ikony o wymiarach 16x16. Wyświetlana ona jest obok nazwy karty przeglądarki oraz po dodaniu strony do zakładek. Najlepiej użyć ścieżki bezwzględnej do obrazka.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingPageLogo">Logo strony</label>
                                                                <input type="text" class="form-control" id="settingPageLogo" name="settingPageLogo" value="<?php echo $settings['pageLogo']; ?>" aria-describedby="settingPageLogoHelp" autocomplete="off" />
                                                                <small id="settingPageLogoHelp" class="form-text text-muted">Link do loga, które wyświetlane jest w lewym górnym rogu, na każdej stronie. Najlepiej użyć ścieżki bezwzględnej do obrazka. Można też wpisać zwykły tekst, wtedy zostanie on wyświetlony zamiast obrazka.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingPageBackground">Tło strony<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                <input type="text" class="form-control" id="settingPageBackground" name="settingPageBackground" value="<?php echo $settings['pageBackground']; ?>" aria-describedby="settingPageBackgroundHelp" autocomplete="off" />
                                                                <small id="settingPageBackgroundHelp" class="form-text text-muted">Link do obrazka, który pojawi się w tle strony. Najlepiej użyć ścieżki bezwzględnej. Można też użyć koloru zapisanego w postaci heksadecymalnej (Razem z poprzedzającym hashem. Przykład "#2c3e50")</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingPageBroadcast">Ogłoszenie</label>
                                                                <textarea class="form-control" id="settingPageBroadcast" name="settingPageBroadcast" aria-describedby="settingPageBroadcastHelp"><?php echo $settings['pageBroadcast']; ?></textarea>
                                                                <small id="settingPageBroadcastHelp" class="form-text text-muted">Pojawia się na górze każdej strony sklepu. Pozostaw pole puste, aby ukryć ogłoszenie.</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="pageVoucher" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 offset-md-3 pt-3">

                                                            <div class="form-group">
                                                                <label for="settingVoucherPrefix">Przedrostek vouchera</label>
                                                                <input type="text" class="form-control" id="settingVoucherPrefix" name="settingVoucherPrefix" value="<?php echo $settings['voucherPrefix']; ?>" aria-describedby="settingVoucherPrefixHelp" autocomplete="off" />
                                                                <small id="settingVoucherPrefixHelp" class="form-text text-muted">Pojawia się przed wygenerowanym kodem vouchera. Można w ten sposób stworzyć np. vouchery z nazwą serwera w ich kodzie.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingVoucherLenght">Długość kodu<span style="color: red;" data-toggle="tooltip" data-html="true" title="Pole wymagane">*</span></label>
                                                                <input type="text" class="form-control" id="settingVoucherLenght" name="settingVoucherLenght" value="<?php echo $settings['voucherLength']; ?>" aria-describedby="settingVoucherLenghtHelp" autocomplete="off" required />
                                                                <small id="settingVoucherLenghtHelp" class="form-text text-muted">Określa długość wygenerowanego kodu vouchera. Prefix nie jest wliczany.</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="pageLayout" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 offset-md-3 pt-3">

                                                            <div class="form-group">
                                                                <label for="settingPageTheme">Motyw</label>
                                                                <select class="form-control" id="settingPageTheme" name="settingPageTheme" value="<?php echo $settings['pageTheme']; ?>" aria-describedby="settingPageThemeHelp">
                                                                    <option value="custom" <?php echo ($settings['pageTheme'] == "custom") ? 'selected' : ''; ?>>vMCShop.pro</option>
                                                                    <option value="cerulean" <?php echo ($settings['pageTheme'] == "cerulean") ? 'selected' : ''; ?>>Cerulean</option>
                                                                    <option value="cosmo" <?php echo ($settings['pageTheme'] == "cosmo") ? 'selected' : ''; ?>>Cosmo</option>
                                                                    <option value="cyborg" <?php echo ($settings['pageTheme'] == "cyborg") ? 'selected' : ''; ?>>Cyborg</option>
                                                                    <option value="darkly" <?php echo ($settings['pageTheme'] == "darkly") ? 'selected' : ''; ?>>Darkly</option>
                                                                    <option value="flatly" <?php echo ($settings['pageTheme'] == "flatly") ? 'selected' : ''; ?>>Flatly</option>
                                                                    <option value="journal" <?php echo ($settings['pageTheme'] == "journal") ? 'selected' : ''; ?>>Journal</option>
                                                                    <option value="litera" <?php echo ($settings['pageTheme'] == "litera") ? 'selected' : ''; ?>>Litera</option>
                                                                    <option value="lumen" <?php echo ($settings['pageTheme'] == "lumen") ? 'selected' : ''; ?>>Lumen</option>
                                                                    <option value="lux" <?php echo ($settings['pageTheme'] == "lux") ? 'selected' : ''; ?>>Lux</option>
                                                                    <option value="materia" <?php echo ($settings['pageTheme'] == "materia") ? 'selected' : ''; ?>>Materia</option>
                                                                    <option value="minty" <?php echo ($settings['pageTheme'] == "minty") ? 'selected' : ''; ?>>Minty</option>
                                                                    <option value="pulse" <?php echo ($settings['pageTheme'] == "pulse") ? 'selected' : ''; ?>>Pulse</option>
                                                                    <option value="sandstone" <?php echo ($settings['pageTheme'] == "sandstone") ? 'selected' : ''; ?>>Sandstone</option>
                                                                    <option value="simplex" <?php echo ($settings['pageTheme'] == "simplex") ? 'selected' : ''; ?>>Simplex</option>
                                                                    <option value="slate" <?php echo ($settings['pageTheme'] == "slate") ? 'selected' : ''; ?>>Slate</option>
                                                                    <option value="solar" <?php echo ($settings['pageTheme'] == "solar") ? 'selected' : ''; ?>>Solar</option>
                                                                    <option value="spacelab" <?php echo ($settings['pageTheme'] == "spacelab") ? 'selected' : ''; ?>>Spacelab</option>
                                                                    <option value="superhero"  <?php echo ($settings['pageTheme'] == "superhero") ? 'selected' : ''; ?>>Superhero</option>
                                                                    <option value="united" <?php echo ($settings['pageTheme'] == "united") ? 'selected' : ''; ?>>United</option>
                                                                    <option value="yeti" <?php echo ($settings['pageTheme'] == "yeti") ? 'selected' : ''; ?>>Yeti</option>
                                                                </select>
                                                                <small id="settingPageThemeHelp" class="form-text text-muted">Wybierz kolorystykę strony.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingSidebarPos">Sidebar</label>
                                                                <select class="form-control" id="settingSidebarPos" name="settingSidebarPos" aria-describedby="settingSidebarPosHelp">
                                                                    <option value="1" <?php echo ($settings['sidebarPos'] == 1) ? 'selected' : ''; ?>>Po prawej</option>
                                                                    <option value="2" <?php echo ($settings['sidebarPos'] == 2) ? 'selected' : ''; ?>>Po lewej</option>
                                                                </select>
                                                                <small id="settingSidebarPosHelp" class="form-text text-muted">Po której stronie mają się wyświetlać panele boczne na stronie wybranego serwera.</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="settingLastBuyersPos">Ostatni kupujący</label>
                                                                <select class="form-control" id="settingLastBuyersPos" name="settingLastBuyersPos" value="<?php echo $settings['lastBuyersPos']; ?>" aria-describedby="settingLastBuyersPosHelp">
                                                                    <option value="1" <?php echo ($settings['lastBuyersPos'] == 1) ? 'selected' : ''; ?>>W sidebar</option>
                                                                    <option value="2" <?php echo ($settings['lastBuyersPos'] == 2) ? 'selected' : ''; ?>>Nad stopką</option>
                                                                </select>
                                                                <small id="settingLastBuyersPosHelp" class="form-text text-muted">Określa gdzie ma znajdować się karta z ostatnimi klientami sklepu.</small>
                                                            </div>

                                                            <!--<div class="form-group">
                                                                <label for="settingServicesListLayout">Wyświetlanie listy usług</label>
                                                                <select class="form-control" id="settingServicesListLayout" name="settingServicesListLayout" value="<?php //echo $settings['serviceListLayout']; ?>" aria-describedby="settingServicesListLayoutHelp">
                                                                    <option value="1" <?php //echo ($settings['serviceListLayout'] == 1) ? 'selected' : ''; ?>>Pionowo</option>
                                                                    <option value="2" <?php //echo ($settings['serviceListLayout'] == 2) ? 'selected' : ''; ?>>Poziomo</option>
                                                                </select>
                                                                <small id="settingServicesListLayoutHelp" class="form-text text-muted">Określa sposób wyświetlania listy usług w sklepie.</small>
                                                            </div>-->

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                <?php echo (strpos(base_url() , 'vmcshop.pro') != true) ? form_close() : ''; ?>

                            </div>

                        </div>

                    </div>
                </div>

            </div>