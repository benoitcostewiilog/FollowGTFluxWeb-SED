<!DOCTYPE html>
<html>
    <head>
        <?php echo include_http_metas() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="<?php echo image_path("favicon.png"); ?>"/>

        <?php if (has_slot("page_title")) { ?>
            <title>MobileStock | <?php include_slot("page_title") ?></title>
        <?php } else { ?>
            <title>MobileStock</title>
        <?php } ?>

        <script src="/js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="/js/plugins/beepjs/beep.js" type="text/javascript"></script>
        <link href="/css/bootstrap.min.css" media="screen" type="text/css" rel="stylesheet">
        <link href="/css/style.css" media="screen" type="text/css" rel="stylesheet">
        <link href="/css/font-awesome/css/font-awesome.css" media="screen" type="text/css" rel="stylesheet">
    </head>
    <body class="gray-bg">
        <?php
        slot('page_title', sprintf('Association produit/BR'));
        ?>
        <!-- Debut header -->
        <div id="" class="gray-bg">
            <div class="row border-bottom" style="float: right;">
                <div class="navbar-header" style="float: right;">
                </div>
                <ul class="nav navbar-top-links navbar-right" style="float: right;">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">GTracking® | Logiciel de pilotage et gestion de marchandise</span>
                    </li>
                    <li>
                        <a href="<?php echo url_for("sf_guard_signout") ?>">
                            <i class="fa fa-sign-out"></i>Déconnexion
                        </a>
                    </li>
                </ul>
                </nav>
            </div>
            <!-- Fin header -->
            <div id="list-ajax-div" class="middle-box text-center">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class='form-horizontal'> 
                                        <h3><?php echo __('Enregistrer une réception') ?></h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12" id="colArrivage">
                                                <div class="form-group" id="form-group-arrivage">
                                                    <label class="col-sm-12 text-center">
                                                        <?php echo __('Numéro d\'arrivage') ?>
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input id="produit" name="produit" class="form-control" value=""/>
                                                            <span class="input-group-btn"> 
                                                                <button onclick="addNumArrivage()" class="btn btn-primary" type="button">+</button> 
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="numArrivageTemplate" class="col-sm-12" style="display: none;">
                                                        <div class="input-group">
                                                            <input id="arrivageSupp" name="arrivageSupp" class="form-control" value=""/>
                                                            <span class="input-group-btn"> 
                                                                <button onclick="$(this).parent().parent().parent().remove();" class="btn btn-primary" type="button">X</button> 
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="col-sm-12 text-center">
                                                        <?php echo __('Numéro de réception') ?>
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <input id="brsap" name="brsap" class="form-control" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 text-center">
                                                <div class="form-group">
                                                    <button id="btnAjout" class="btn btn-primary"><?php echo __('Enregistrer'); ?></button>
                                                    <?php
                                                    //Si l'utilisateur n'a que le droit d'access a ce modules il ne peut pas retourner en arriere
                                                    $listeModulesUser = sfGuardUserTable::getModulesUtilisateur($sf_user->getGroups());
                                                    if (count($listeModulesUser) !== 1) { //l'utilisateur a acces a + d'un module
                                                        ?>
                                                        <button class="btn btn-default" onclick="retour(event);"><?php echo __('Retour'); ?></button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 text-center">
                                                <div class="form-group">
                                                    <img src="<?php echo image_path('ajax_loader.gif'); ?>" id="imageFonction" style="width:30px; visibility:hidden;">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 text-center">
                                                <div class="form-group">
                                                    <input id="sansArrivage" class="btn btn-default" type="button" value="Sans N° arrivage"/>
                                                    <input style="display: none;" id="avecArrivage" class="btn btn-default" type="button" value="Avec N° arrivage"/>
                                                </div>
                                            </div>

                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Debut footer -->
            <div class="footer">
                <div class="pull-right">
                    <strong>www.mobileit.fr</strong>
                </div>
                <div>
                    <strong>Copyright</strong> MobileIT &copy; 2013-2015
                </div>
            </div>
            <!-- Fin footer -->
        </div>
        <script>
            var nbRetry = 5;
            $(document).ready(function () {
                if (typeof console === "undefined") {
                    console = {
                        log: function () {
                        },
                        debug: function () {
                        }
                    };
                }
                $('#produit').keypress(function (e) {
                    if (e.which === 13) {
                        (e.preventDefault) ? e.preventDefault() : e.returnValue = false;
                        $('#brsap').select();
                    }
                });
                $('#brsap').keypress(function (e) {
                    if (e.which === 13) {
                        (e.preventDefault) ? e.preventDefault() : e.returnValue = false;
                        nbRetry = 5;
                        validerAss();
                    }
                });
                $('#btnAjout').click(function () {
                    nbRetry = 5;
                    validerAss();
                });
                $('#produit').val('');
                $('#brsap').val('');
                $('#produit').select();

                $('#sansArrivage').click(function () {
                    $('#produit').val('Absent');
                    $('#colArrivage').hide();
                    $('#avecArrivage').show();
                    $('#sansArrivage').hide();
                    $('#brsap').select();
                });

                $('#avecArrivage').click(function () {
                    $('#produit').val('');
                    $('#colArrivage').show();
                    $('#avecArrivage').hide();
                    $('#sansArrivage').show();
                    $('#produit').select();
                });

            });
            function validerAss() {
                removeAllSet('#produit');
                removeAllSet('#brsap');
                removeAllSet('.arrivageSupp');
                arrivageSuppJson = checkAndGetArrivageSupp();
                if (arrivageSuppJson) {
                    if ($('#produit').val() !== "") {
                        if ($('#brsap').val() !== "") {
                            $('#imageFonction').css('visibility', 'visible');
                            $.post("<?php echo url_for('association-br-validerAssAjax') ?>", {'prod': $('#produit').val(), 'sap': $('#brsap').val(), 'arrivageSuppJson': arrivageSuppJson}, function (data) {
                                console.log('erreurProduit = ' + data.erreurProduit);
                                console.log('erreurSap = ' + data.erreurSap);
                                console.log('erreurArrivageSupp = ' + data.jsonErrorArrivageSupp);
                                var erreurArrivageSupp = checkErreurArrivageSupp(data.jsonErrorArrivageSupp);
                                if (data.erreurProduit === 0) {
                                    console.log('pas erreur produit');
                                    setHasSuccess('#produit');
                                    if (data.erreurSap === 1) {
                                        console.log('erreur sap');
                                        setHasError('#brsap');
                                        $('#brsap').select();
                                    } else {
                                        console.log('pas erreur sap');
                                        setHasSuccess('#brsap');
                                        if (!erreurArrivageSupp) {
                                            beep();
                                            $('.arrivageSuppContainer').remove();
                                            if ($('#produit').val() == 'Absent') {
                                                $('#avecArrivage').click();
                                                $('#produit').val('');
                                                $('#brsap').val('');
                                                $('#produit').select();
                                            } else {
                                                $('#produit').val('');
                                                $('#brsap').val('');
                                                $('#produit').select();
                                            }
                                        }
                                    }
                                } else {
                                    if (data.erreurSap === 1) {
                                        console.log('erreur sap');
                                        setHasError('#brsap');
                                    } else {
                                        console.log('pas erreur sap');
                                        setHasSuccess('#brsap');
                                    }
                                    console.log('erreur produit');
                                    setHasError('#produit');
                                    $('#produit').select();
                                }
                                console.log('fin retour ajax');
                            }, "json")
                                    .fail(function () {
                                        nbRetry--;
                                        if (nbRetry <= 0) {
                                            alert('Une erreur est survenue lors de la communication avec le serveur');
                                            window.location = '<?php echo url_for('association-br') ?>';
                                        } else {
                                            validerAss();
                                        }
                                    })
                                    .always(function () {
                                        $('#imageFonction').css('visibility', 'hidden');
                                    });
                        } else {
                            setHasError('#brsap');
                            $('#brsap').select();
                        }
                    } else {
                        if ($('#brsap').val() === "") {
                            setHasError('#brsap');
                        }
                        setHasError('#produit');
                        $('#produit').select();
                    }
                }
            }
            function retour(e) {
                (e.preventDefault) ? e.preventDefault() : e.returnValue = false;
                window.location = '<?php echo url_for('homepage') ?>';
            }

            function setHasError(id) {
                $(id).parent().parent().removeClass('has-success');
                $(id).parent().parent().addClass('has-error');
            }
            function setHasSuccess(id) {
                $(id).parent().parent().removeClass('has-error');
                $(id).parent().parent().addClass('has-success');
            }
            function removeAllSet(id) {
                $(id).parent().parent().removeClass('has-error');
                $(id).parent().parent().removeClass('has-success');
            }


            function addNumArrivage() {
                var el = $('#numArrivageTemplate').clone(true);
                el.find('#arrivageSupp').addClass('arrivageSupp');
                el.addClass('arrivageSuppContainer');
                el.appendTo('#form-group-arrivage');
                el.show();
            }

            function checkAndGetArrivageSupp() {
                arrivages = new Array();
                error = false;
                $('.arrivageSupp').each(function (index, element) {
                    var val = $(element).val();
                    if (val !== "") {
                        arrivages[index] = val;
                    } else {
                        setHasError(element);
                        error = true;
                    }
                });

                if (error) {
                    return false;
                }
                return JSON.stringify(arrivages);
            }
            function checkErreurArrivageSupp(jsonArrivageSupp) {
                var error = false;
                var arrayArrivageError = JSON.parse(jsonArrivageSupp);
                $('.arrivageSupp').each(function (index, element) {
                    var val = $(element).val();
                    if ($.inArray(val, arrayArrivageError) !== -1) {
                        if (!error) {
                            $(element).select();
                        }
                        console.log(val);
                        setHasError(element);
                        error = true;
                    }
                });

                return error;
            }
            function beep() {
                 var audio = new Audio('<?php echo  '/audio/beep.mp3' ?>');
                 audio.play();
            }
        </script>
        <style>
            .has-error{
                color:red;
            }
            .has-success{
                color:green;
            }
        </style>
    </body>
</html>