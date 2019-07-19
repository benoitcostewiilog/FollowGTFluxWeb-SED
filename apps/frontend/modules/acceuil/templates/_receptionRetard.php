<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Dépose</h5>
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
            }, 60000);
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

        var timeNow= h + ':' + m + ':' + s;
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