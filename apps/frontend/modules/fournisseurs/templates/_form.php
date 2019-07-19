<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Libelle') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="libelle" name="libelle" class="form-control" value="<?php echo(isset($fournisseur) ? $fournisseur->getLibelle() : '') ?>"/>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res !== '') {
                    goBack();
                    reloadList();
                } else {
                    setHasError("#libelle");
                }
            }});
    });


    function controleValeur() {
        var erreur = false;
        removeAllSet("#libelle");


        if ($("#libelle").val() === "") {
            erreur = true;
            setHasError("#libelle");
        }

        return !erreur;
    }
</script>