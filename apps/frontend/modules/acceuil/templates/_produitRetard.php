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
    </div>
</div>
<script>
    var timerEncour = 0;
    $(document).ready(function () {
        ajaxRequestProduitEnRetard();
        getListRetard();
    });
    function getListRetard() {
        if (timerEncour === 0) {
            setTimeout(function () {
                timerEncour--;
                ajaxRequestProduitEnRetard();
                getListRetard();
            }, 30000);
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
                url = '<?php echo url_for(array('sf_route' => 'acceuil-list-retard-excel')) ?>';
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'acceuil-list-retard-word')) ?>';
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'acceuil-list-retard-print')) ?>';
                break;
        }
        location.assign(url);
    }
</script>