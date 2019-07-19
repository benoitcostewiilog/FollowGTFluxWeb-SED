<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Arrivages en retard</h5>
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
            }, 60000);
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

        var timeNow= h + ':' + m + ':' + s;
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