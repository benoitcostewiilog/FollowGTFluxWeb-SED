<?php
//Slot du titre de la page
slot('page_title', sprintf("Statistiques"));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <strong><a href="#"><?php echo __('Statistiques'); ?></a></strong>
            </li>
            <li class="active">
                <strong><?php echo __('Tracking en retard'); ?></strong>
            </li>

        </ol>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Numéro d’Arrivage en retard</h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="exporterProduitRetard('excel');" >Export Excel</a></li>
                                <li><a onclick="exporterProduitRetard('word');" >Export Word</a></li>
                                <li><a onclick="exporterProduitRetard('print');" >Imprimer</a></li>    
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content" style="max-height:350px; overflow:auto;">

                        <img id="retardLoader" class="img-responsive" style="display: block;margin: 0 auto;" src="<?php echo image_path('ajax_loader.gif') ?>"/>

                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Numéro d’Arrivage</th>
                                    <th>Date de réception</th>
                                    <th>Retard</th>
                                </tr>
                            </thead>
                            <tbody id="listRetard">
                                <?php
                                //include_partial('listRetard', array("produitEnRetard" => $produitEnRetard));
                                ?>
                            </tbody>
                        </table>
                        <div class="m-t-md">
                            <small class="pull-right" id="dateMiseAJour">
                            </small>
                            <br>
                        </div>
                            <div class="m-t-md">
            <small class="pull-left" i>
                 *Numéro d’Arrivage en retard = à l’instant T, les Numéro d’Arrivage ayant dépassé le délai (référentiel Nature de colis) depuis l’heure de réception sans 1ère dépose après Réception.
            </small>
            <br>
        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Arrivages en retard</h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="exporterArrivageRetard('excel');" >Export Excel</a></li>
                                <li><a onclick="exporterArrivageRetard('word');" >Export Word</a></li>
                                <li><a onclick="exporterArrivageRetard('print');" >Imprimer</a></li>    
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content" style="max-height:350px; overflow:auto;">
                        <img id="retardLoaderArrivage" class="img-responsive" style="display: block;margin: 0 auto;" src="<?php echo image_path('ajax_loader.gif') ?>"/>

                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Numéro d'arrivage</th>
                                    <th>Date d'arrivage</th>
                                    <th>Retard</th>
                                </tr>
                            </thead>
                            <tbody id="arrivageRetard">

                            </tbody>
                        </table>
                        <div class="m-t-md">
                            <small class="pull-right" id="dateMiseAJourArrivage">
                            </small>
                            <br>
                        </div>
                          <div class="m-t-md">
            <small class="pull-left" i>
                *Arrivages en retard = à l’instant T, les arrivages ayant dépassé le délai de 3h sans être passé en Réception.
            </small>
            <br>
        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Dépose</h5>
                          <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="exporterReceptionRetard('excel');" >Export Excel</a></li>
                                <li><a onclick="exporterReceptionRetard('word');" >Export Word</a></li>
                                <li><a onclick="exporterReceptionRetard('print');" >Imprimer</a></li>    
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content" style="max-height:350px; overflow:auto;">
                        <img id="retardLoaderReception" class="img-responsive" style="display: block;margin: 0 auto;" src="<?php echo image_path('ajax_loader.gif') ?>"/>

                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Numéro d’Arrivage</th>
                                          <th>Date d'arrivage</th>
                    <th>Date Reception</th>
                                    <th>Retard</th>
                                </tr>
                            </thead>
                            <tbody id="receptionRetard">

                            </tbody>
                        </table>
                        <div class="m-t-md">
                            <small class="pull-right" id="dateMiseAJourReception">
                            </small>
                            <br>
                        </div>
                                       <div class="m-t-md">
            <small class="pull-left" i>
                *Réceptions en retard = à l’instant T, les réceptions ayant dépassé le délai de 4h depuis l’heure d’arrivage avec une 1ère dépose après Réception.
            </small>
            <br>
        </div>
                    </div>
                </div>



                <script>
                    var timerEncourRec = 0;
                    $(document).ready(function () {
                        ajaxRequestReceptionEnRetard();
                        getListReceptionRetard();
                    });
                    function getListReceptionRetard() {
                        if (timerEncourRec === 0) {
                            setTimeout(function () {
                                timerEncourRec--;
                                ajaxRequestReceptionEnRetard();
                                getListReceptionRetard();
                            }, 35000);
                            timerEncourRec++;
                        }
                    }

                    function ajaxRequestReceptionEnRetard() {
                        $.ajax({
                            url: '<?php echo url_for('acceuil-reception-retard-ajax') ?>',
                            success: function (data) {
                                $('#receptionRetard').empty();
                                $('#receptionRetard').append(data);
                                var d = new Date(); // for now
                                var d = new Date(),
                                        h = (d.getHours() < 10 ? '0' : '') + d.getHours(),
                                        m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(),
                                        s = (d.getSeconds() < 10 ? '0' : '') + d.getSeconds();

                                var timeNow = h + ':' + m + ':' + s;
                                $('#dateMiseAJourReception').html('<i class="fa fa-clock-o"> </i> Mise à jour à ' + timeNow);
                                $('#retardLoaderReception').hide();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $("#suiviReception").removeAttr('checked');
                                $('#retardLoaderReception').hide();
                            }
                        });
                    }

                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Mise en ligne</h5>
                          <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="exporterDeposeRetard('excel');" >Export Excel</a></li>
                                <li><a onclick="exporterDeposeRetard('word');" >Export Word</a></li>
                                <li><a onclick="exporterDeposeRetard('print');" >Imprimer</a></li>    
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content" style="max-height:350px; overflow:auto;">
                        <img id="retardLoaderDepose" class="img-responsive" style="display: block;margin: 0 auto;" src="<?php echo image_path('ajax_loader.gif') ?>"/>

                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Numéro d’Arrivage</th>
                                            <th>Date d'arrivage</th>
                    <th>Date Reception</th>
                                    <th>Retard</th>
                                </tr>
                            </thead>
                            <tbody id="deposeRetard">

                            </tbody>
                        </table>
                        <div class="m-t-md">
                            <small class="pull-right" id="dateMiseAJourDepose">
                            </small>
                            <br>
                        </div>
                            <div class="m-t-md">
            <small class="pull-left" i>
                *Déposes en retard = à l’instant T, les Tracking n’ayant pas fait de 2e dépose après Réception avec un délai supérieur à 5,5h
            </small>
            <br>
        </div>
                    </div>
                </div>



                <script>
                    var timerEncour3 = 0;
                    $(document).ready(function () {
                        ajaxRequestDeposeEnRetard();
                        getListDeposeRetard();
                    });
                    function getListDeposeRetard() {
                        if (timerEncour3 === 0) {
                            setTimeout(function () {
                                timerEncour3--;
                                ajaxRequestDeposeEnRetard();
                                getListDeposeRetard();
                            }, 35000);
                            timerEncour3++;
                        }
                    }

                    function ajaxRequestDeposeEnRetard() {
                        $.ajax({
                            url: '<?php echo url_for('acceuil-depose-retard-ajax') ?>',
                            success: function (data) {
                                $('#deposeRetard').empty();
                                $('#deposeRetard').append(data);
                                var d = new Date(); // for now
                                var d = new Date(),
                                        h = (d.getHours() < 10 ? '0' : '') + d.getHours(),
                                        m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(),
                                        s = (d.getSeconds() < 10 ? '0' : '') + d.getSeconds();

                                var timeNow = h + ':' + m + ':' + s;
                                $('#dateMiseAJourDepose').html('<i class="fa fa-clock-o"> </i> Mise à jour à ' + timeNow);
                                $('#retardLoaderDepose').hide();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $("#suiviDepose").removeAttr('checked');
                                $('#retardLoaderDepose').hide();
                            }
                        });
                    }

                </script>
            </div>
        </div>
    </div>
</div>

<script>
    var timerEncour2 = 0;
    $(document).ready(function () {
        ajaxRequestArrivageEnRetard();
        getListArrivageRetard();
    });
    function getListArrivageRetard() {
        if (timerEncour2 === 0) {
            setTimeout(function () {
                timerEncour2--;
                ajaxRequestArrivageEnRetard();
                getListArrivageRetard();
            }, 35000);
            timerEncour2++;
        }
    }

    function ajaxRequestArrivageEnRetard() {
        $.ajax({
            url: '<?php echo url_for('acceuil-arrivage-retard-ajax') ?>',
            success: function (data) {
                $('#arrivageRetard').empty();
                $('#arrivageRetard').append(data);
                var d = new Date(); // for now
                var d = new Date(),
                        h = (d.getHours() < 10 ? '0' : '') + d.getHours(),
                        m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(),
                        s = (d.getSeconds() < 10 ? '0' : '') + d.getSeconds();

                var timeNow = h + ':' + m + ':' + s;
                $('#dateMiseAJourArrivage').html('<i class="fa fa-clock-o"> </i> Mise à jour à ' + timeNow);
                $('#retardLoaderArrivage').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#suiviArrivage").removeAttr('checked');
                $('#retardLoaderArrivage').hide();
            }
        });
    }

</script>

<script>

    var timerEncour = 0;
    $(document).ready(function () {
        $('#lytHrchy').html($('#tpltLstHrchy').html());
        ajaxRequestProduitEnRetard();
        getListRetard();
    });
    function getListRetard() {
        if (timerEncour === 0) {
            setTimeout(function () {
                timerEncour--;
                ajaxRequestProduitEnRetard();
                getListRetard();
            }, 35000);
            timerEncour++;
        }
    }

    function ajaxRequestProduitEnRetard() {
        $.ajax({
            url: '<?php echo url_for('acceuil-list-retard-ajax') ?>',
            success: function (data) {
                $('#listRetard').empty();
                $('#listRetard').append(data);
                var d = new Date(); // for now
                $('#dateMiseAJour').html('<i class="fa fa-clock-o"> </i> Mise à jour à ' + timeNow());
                $('#retardLoader').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#suivi").removeAttr('checked');
                $('#retardLoader').hide();
            }
        });
    }

    function timeNow() {
        var d = new Date(),
                h = (d.getHours() < 10 ? '0' : '') + d.getHours(),
                m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(),
                s = (d.getSeconds() < 10 ? '0' : '') + d.getSeconds();

        return h + ':' + m + ':' + s;
    }

    function exporterProduitRetard(type) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=excel&list=tracking';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=word&list=tracking';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=print&list=tracking';
                break;
        }
        location.assign(url);
    }
    
    function exporterArrivageRetard(type) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=excel&list=arrivage';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=word&list=arrivage';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=print&list=arrivage';
                break;
        }
        location.assign(url);
    }
    
     function exporterReceptionRetard(type) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=excel&list=reception';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=word&list=reception';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=print&list=reception';
                break;
        }
        location.assign(url);
    }
    
     function exporterDeposeRetard(type) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=excel&list=depose';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=word&list=depose';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'statistiques-globale-export')) ?>?type=print&list=depose';
                break;
        }
        location.assign(url);
    }
</script>