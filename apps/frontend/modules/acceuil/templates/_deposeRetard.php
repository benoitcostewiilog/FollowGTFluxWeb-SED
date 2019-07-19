<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Mise en ligne</h5>
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
            }, 60000);
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

        var timeNow= h + ':' + m + ':' + s;
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