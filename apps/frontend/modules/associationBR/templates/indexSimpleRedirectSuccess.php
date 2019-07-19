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
                                    <form method="POST" id="formAjout" action="<?php echo url_for('association-br-validerAss') ?>" class='form-horizontal'> 
                                        <h3><?php echo __('Ajouter une association :') ?></h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="col-sm-12 text-center">
                                                        <?php echo __('Numéro d\'arrivage') ?>
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <input id="produit" width="100%" name="produit" class="form-control" value="<?php echo (isset($prod) ? $prod : '') ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="col-sm-12 text-center">
                                                        <?php echo __('Numéro de réception') ?>
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <input id="brsap" name="brsap" class="form-control" value="<?php echo (isset($sap) ? $sap : '') ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 text-center">
                                                <div class="form-group">
                                                    <button id="btnAjout" class="btn btn-primary"><?php echo __('Ajouter'); ?></button>
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
                                                    <input class="btn btn-default" type="button" onclick="window.location = '<?php echo url_for('association-br') ?>'" value="Sans redirection"/>
                                                </div>
                                            </div>

                                            <div>
                                            </div>
                                        </div>
                                    </form>
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
            <script>
                $(document).ready(function () {
                    $('#produit').keypress(function (e) {
                        if (e.which === 13) {
                            (e.preventDefault) ? e.preventDefault() : e.returnValue = false;
                            $('#brsap').select();
                        }
                    });
                    $('#brsap').keypress(function (e) {
                        if (e.which === 13) {
                            (e.preventDefault) ? e.preventDefault() : e.returnValue = false;
                            validerAss();
                        }
                    });
                    $('#btnAjout').click(function (e) {
                        (e.preventDefault) ? e.preventDefault() : e.returnValue = false;
                        validerAss();
                    });
                    $('#produit').select();
<?php if (isset($sapErreur) && $sapErreur) { ?>
                        setHasError('#brsap');
                        $('#brsap').select();
<?php } ?>
<?php if (isset($prodErreur) && $prodErreur) { ?>
                        setHasError('#produit');
                        $('#produit').select();
<?php } ?>
<?php if (isset($sapErreur) && isset($prodErreur) && !$prodErreur && !$sapErreur) { ?>
                        setHasSuccess('#brsap');
                        setHasSuccess('#produit');
<?php } ?>


                });
                function validerAss() {
                    removeAllSet('#produit');
                    removeAllSet('#brsap');
                    if ($('#produit').val() !== "") {
                        if ($('#brsap').val() !== "") {
                            $('#imageFonction').css('visibility', 'visible');
                            $('#formAjout').submit();
                        } else {
                            setHasError('#brsap');
                            $('#brsap').select();
                        }
                    } else {
                        setHasError('#produit');
                        $('#produit').select();
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