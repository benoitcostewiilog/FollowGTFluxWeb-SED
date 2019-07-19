<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Code emplacement') ?>
    </label>
    <div class="col-sm-10">
        <input <?php echo(isset($ref_emplacement) ? 'readonly' : '') ?> type="text" id="codeEmplacement" name="code_emplacement" class="form-control" value="<?php echo(isset($ref_emplacement) ? $ref_emplacement->getCodeEmplacement() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Libelle') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="libelle" name="libelle" class="form-control" value="<?php echo(isset($ref_emplacement) ? $ref_emplacement->getLibelle() : '') ?>"/>
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
                }
            }});

    });


    function controleValeur() {
        var erreur = false;
        removeAllSet("#codeEmplacement");
        removeAllSet("#libelle");

        codeEmplacement = $("#codeEmplacement").val() + '';
        if (codeEmplacement.trim() === "") {
            erreur = true;
            setHasError("#codeEmplacement");
        } else {
<?php if (!isset($ref_emplacement)) { ?>
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url_for(array('sf_route' => 'referentiels-emplacement-check-code')) ?>',
                    data: {code_emplacement: codeEmplacement.trim()},
                    async: false,
                    success: function (res) {
                        if (res === '1') {

                        } else {
                            erreur = true;
                            setHasError("#codeEmplacement");
                        }

                    }});
<?php } ?>
        }
        if ($("#libelle").val() === "") {
            erreur = true;
            setHasError("#libelle");
        }

        return !erreur;
    }
</script>