<?php
//Slot du titre de la page
slot('page_title', sprintf("En cours"));
?>

<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
                      <li class="active">
                <strong><?php echo __('En cours'); ?></strong>
            </li>

        </ol>
    </div>
    <div class="wrapper wrapper-content">
        
        <?php
        $array=array(
            array(
                "REC ADM",
                "RECADM"
                ),
             array(
                "CTL SPL",
                "CTLSPL"
                ),
             array(
                "CTL CPL",
                "CTLCPL"
                ),
             array(
                "ACH",
                "ACH"
                )
            );
        foreach ($array as $value) {
              $emplacement =$value[0] ; $idHtml = $value[1] ;?>
        
        
      
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>En cours sur le segment <?php echo $emplacement?></h5>
                               <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a onclick="exporter('excel','<?php echo $emplacement?>');" >Export Excel</a></li>
                                <li><a onclick="exporter('word','<?php echo $emplacement?>');" >Export Word</a></li>
                                <li><a onclick="exporter('print','<?php echo $emplacement?>');" >Imprimer</a></li>    
                            </ul>
                        </div>
                    </div>
                    <div class="ibox-content" style="max-height:350px; overflow:auto;">
                        <img id="retardLoader<?php echo $idHtml?>" class="img-responsive" style="display: block;margin: 0 auto;" src="<?php echo image_path('ajax_loader.gif') ?>"/>

                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Numéro d’Arrivage</th>
                                            <th>Date de dépose</th>
                                    <th>Délais</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $idHtml?>">

                            </tbody>
                        </table>
                        <div class="m-t-md">
                            <small class="pull-right" id="dateMiseAJour<?php echo $idHtml?>">
                            </small>
                            <br>
                        </div>
                            <div class="m-t-md">
         
            <br>
        </div>
                    </div>
                </div>



                <script>
                    var timerEncour<?php echo $idHtml?> = 0;
                    $(document).ready(function () {
                        ajaxRequest<?php echo $idHtml?>();
                        getList<?php echo $idHtml?>();
                    });
                    function getList<?php echo $idHtml?>() {
                        if (timerEncour<?php echo $idHtml?> === 0) {
                            setTimeout(function () {
                                timerEncour<?php echo $idHtml?>--;
                                ajaxRequest<?php echo $idHtml?>();
                                getList<?php echo $idHtml?>();
                            }, 35000);
                            timerEncour<?php echo $idHtml?>++;
                        }
                    }

                    function ajaxRequest<?php echo $idHtml?>() {
                        $.ajax({
                            url: '<?php echo url_for('acceuil-encours-ajax') ?>',
                            data: {emplacement:"<?php echo $emplacement?>"},
                            success: function (data) {
                                $('#<?php echo $idHtml?>').empty();
                                $('#<?php echo $idHtml?>').append(data);
                                var d = new Date(); // for now
                                var d = new Date(),
                                        h = (d.getHours() < 10 ? '0' : '') + d.getHours(),
                                        m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(),
                                        s = (d.getSeconds() < 10 ? '0' : '') + d.getSeconds();

                                var timeNow = h + ':' + m + ':' + s;
                                $('#dateMiseAJour<?php echo $idHtml?>').html('<i class="fa fa-clock-o"> </i> Mise à jour à ' + timeNow);
                                $('#retardLoader<?php echo $idHtml?>').hide();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                $("#suivi<?php echo $idHtml?>").removeAttr('checked');
                                $('#retardLoader<?php echo $idHtml?>').hide();
                            }
                        });
                    }

                </script>
            </div>
        </div>
        <?php } ?>
    </div>
</div>


<script>
    
    
    function exporter(type,emplacement) {
        url = '';
        switch (type) {
            case 'excel':
                url = '<?php echo url_for(array('sf_route' => 'encours-export')) ?>?type=excel&emplacement='+emplacement;
                break;
            case 'word':
                url = '<?php echo url_for(array('sf_route' => 'encours-export')) ?>?type=word&emplacement='+emplacement;
                break;
            case 'print':
                url = '<?php echo url_for(array('sf_route' => 'encours-export')) ?>?type=print&emplacement='+emplacement;
                break;
        }
        location.assign(url);
    }
    
    </script>