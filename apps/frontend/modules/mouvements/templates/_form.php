<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Numéro d’arrivage') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="uniteTracking" name="uniteTracking" class="form-control" value="<?php echo(isset($mouvement) ? $mouvement->getRefProduit() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Action') ?>
    </label>
    <div class="col-sm-10">
        <select id="typeForm" name="type" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($types as $type) { ?>
                <option <?php echo ( isset($mouvement) && $mouvement->getType() == $type ? 'selected' : '') ?> value="<?php echo $type; ?>"><?php echo $type ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Emplacement') ?>
    </label>
    <div class="col-sm-10">
        <select id="emplacementForm" name="emplacement" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($emplacements as $emplacement) { ?>
                <option <?php echo ( isset($mouvement) && $mouvement->getCodeEmplacement() === $emplacement->getCodeEmplacement() ? 'selected' : '') ?>  value="<?php echo $emplacement->getCodeEmplacement(); ?>" ><?php echo $emplacement->getLibelle() ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div id="form-group-commentaire" class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Commentaire') ?>
    </label>
    <div class="col-sm-10">
        <textarea id="commentaire" name="commentaire" class="form-control"><?php echo (isset($mouvement) ? $mouvement->getCommentaire() : '') ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Groupe') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="groupe" name="groupe" class="form-control" value="<?php echo(isset($mouvement) ? $mouvement->getGroupe() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Date/Heure') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="heurePrise" name="heurePrise" class="form-control dateHeure" value="<?php echo(isset($mouvement) ? date('d/m/Y H:i:s', strtotime($mouvement->getHeurePrise())) : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Utilisateur') ?>
    </label>
    <div class="col-sm-10">
        <select id="users" name="users" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($users as $user) { ?>
                <option <?php echo (isset($mouvement) && $mouvement->getIdUtilisateur() == $user->getId() ? 'selected' : '') ?> value="<?php echo $user->getId(); ?>"><?php echo $user->getUsername() ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<script>
    $(document).ready(function () {
        var config = {
            disable_search_threshold: 10, //on cache le champs de recherche si il y a moins de 10 elements
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false,
            display_disabled_options: false
        };
        $('.chosen-select').chosen(config);
        $(".chosen-container").css("width", "100%");
        
         $('.dateHeure').datetimepicker({
            format: 'DD/MM/YYYY HH:mm:ss',
            useCurrent: true,
            locale: moment.locale('fr'),
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-crosshairs',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });

        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res === '1') {
                    goBack();
                    $("#formFiltre").submit();
                } else {
                }
            }});
    });

    function controleValeur() {
        var erreur = false;
        removeAllSet("#uniteTracking");
        removeAllSet("#typeForm");
        removeAllSet("#emplacementForm");
        removeAllSet("#heurePrise");
        removeAllSet("#users");

        if ($("#uniteTracking").val() === "") {
            erreur = true;
            setHasError("#uniteTracking");
        }
        if ($("#typeForm").val() === "") {
            erreur = true;
            setHasError("#typeForm");
        }

        if ($("#emplacementForm").val() === "") {
            erreur = true;
            setHasError("#emplacementForm");
        }

        if ($("#heurePrise").val() === "") {
            erreur = true;
            setHasError("#heurePrise");
        }

        if ($("#users").val() === "") {
            erreur = true;
            setHasError("#users");
        }

        return !erreur;
    }

</script>