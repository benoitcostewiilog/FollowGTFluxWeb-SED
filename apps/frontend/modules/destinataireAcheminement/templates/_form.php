<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Destinataire') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="destinataire" name="destinataire" class="form-control" value="<?php echo(isset($destinataire) ? $destinataire->getDestinataire() : '') ?>"/>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res === '1') {
                    goBack();
                    reloadList();
                } else {
                    setHasError("#destinataire");
                }
            }});
    });


    function controleValeur() {
        var erreur = false;
        removeAllSet("#destinataire");


        if ($("#destinataire").val() === "") {
            erreur = true;
            setHasError("#destinataire");
        }

        return !erreur;
    }
</script>