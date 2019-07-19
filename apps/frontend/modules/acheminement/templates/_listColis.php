<div class="row">
    <div class="col-lg-12" style="padding-top: 30px;">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo __('Formulaire de création d\'un acheminement : ajout désignation colis'); ?></h5>
            </div>
            <div class="ibox-content">
                <form method="POST" action="<?php echo url_for(array('sf_route' => 'acheminement-save-colis')) ?>" id="formNew" class="form-horizontal">
                   
                    <input type="hidden" name="nbColis" value="<?php echo $nbColis ?>">
                    <input type="hidden" name="idAcheminement" value="<?php echo $idAchm ?>">
                    
                    <?php foreach ($lstColis as $colis) { ?>
        
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Désignation colis ') . $colis->getNumeroColis() ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="<?php echo $colis->getIdColis() ?>" name="colis<?php echo $colis->getNumeroColis() ?>" class="form-control" value="<?php echo $colis->getDesignation() ?>"/>
                        </div>
                    </div>  


                    <?php } ?>
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



<script>
    $(document).ready(function () {

    });

    function valideForm() {

            


    }

</script>