<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Libelle') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="libelle" name="libelle" class="form-control" value="<?php echo(isset($nature) ? $nature->getLibelle() : '') ?>"/>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Delais') ?>
    </label>
    <div class="col-sm-10 bootstrap-timepicker timepicker">
        <input type="text" id="delais" name="delais" class="form-control heure" value=" <?php echo(isset($nature) ? $nature->getDelais() : '') ?>"/>
    </div>
</div>



<script>
    $(document).ready(function () {
        $('.heure').timepicker({
            showSeconds: true,
            showMeridian: false,
            defaultTime: false,
            maxHours: 100,
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
            }
        });

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
        removeAllSet("#libelle");

        if ($("#libelle").val() === "") {
            erreur = true;
            setHasError("#libelle");
        }

        return !erreur;
    }
</script>