<div class="wrapper wrapper-content animated fadeInRight">
    <div id="tpltEdtHrchy" class="hidden">
        <ol class="breadcrumb">
        
            <li>
                <a onclick="goBack();"><?php echo __('Gestion des non conformités'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Traitement'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Formulaire de traitement d\'une non-conformité'); ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo url_for(array('sf_route' => 'nonconforme-update')) ?>" id="formEdit" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php echo $mouvement->getIdMouvement() ?>"/> 
                     <div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Anomalie') ?>
    </label>
    <div class="col-sm-10 bootstrap-timepicker timepicker">
        <input type="text" id="anomalie" name="anomalie" class="form-control" value=" <?php echo $mouvement->getAnomalie()  ?>"/>
    </div>
</div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" onclick="goBack();" type="button"><?php echo __('Annuler'); ?></button>
                                <button class="btn btn-primary" type="submit"><?php echo __('Enregistrer'); ?></button>
                            </div>
                            <span class="form-mandatory-end"><span class="form-mandatory">* </span><?php echo __('champs obligatoires') ?></span>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltEdtHrchy').html());
    });
    
      $(document).ready(function () {
        $('#formEdit,#formNew').ajaxForm({
            success: function (res) {
                 goBack();
                   window.location.reload();
               
            }});
    });
</script>
