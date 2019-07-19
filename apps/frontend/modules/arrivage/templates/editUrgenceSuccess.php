
<div class="wrapper wrapper-content animated fadeInRight">
    <div id="tpltEdtHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Historique'); ?></a>
            </li>
            <li>
                <a onclick="goBack();"><?php echo __('Arrivages'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Saisie d\'une urgence'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Formulaire de saisie d\'une urgence'); ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo url_for(array('sf_route' => 'arrivage-urgence-update')) ?>" id="formEdit" class="form-horizontal">
                        <input type="hidden" name="idArrivage" value="<?php echo $arrivage->getIdArrivage() ?>"/> 

                        <div class="form-group" style="<?php echo ( isset($arrivage) && $arrivage->getUrgent() ? '' : 'display: none;') ?>">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Fourchette date de livraison') ?>
                            </label>
                            <div class="col-sm-10">
                                <input <?php echo $editUrgence ? "" : "disabled=''" ?> type="text" id="date_livraison_debut" name="date_livraison_debut" class="form-control dateHeure"  value="<?php echo isset($arrivage) && $arrivage->getDateLivraisonDebut() ? DateTime::createFromFormat('Y-m-d H:i:s', $arrivage->getDateLivraisonDebut())->format('d/m/Y H:i:s') : ''; ?>" />
                                <input <?php echo $editUrgence ? "" : "disabled=''" ?>  type="text" id="date_livraison_fin" name="date_livraison_fin" class="form-control dateHeure" value="<?php echo isset($arrivage) && $arrivage->getDateLivraisonFin() ? DateTime::createFromFormat('Y-m-d H:i:s', $arrivage->getDateLivraisonFin())->format('d/m/Y H:i:s') : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group" style="<?php echo ( isset($arrivage) && $arrivage->getUrgent() ? '' : 'display: none;') ?>">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Contact PFF') ?>
                            </label>
                            <div class="col-sm-10">
                                <select <?php echo $editUrgence ? "" : "disabled=''" ?>  id="contact_pff" class="chosen-select" name="contact_pff">
                                    <option value="-1" <?php echo (!isset($arrivage) ? 'selected' : '') ?>>N/C</option>
                                    <?php foreach ($interlocuteurs as $interlocuteur) { ?>

                                        <option <?php echo ( isset($arrivage) && $interlocuteur->getId() == $arrivage->getIdInterlocuteur() ? 'selected' : '') ?> value="<?php echo $interlocuteur->getId(); ?>" idTransporteur="<?php echo $interlocuteur->getId(); ?>"><?php echo $interlocuteur ?></option>
                                    <?php } ?>
                                </select>
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
</script>


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
            success: function (res) {
                if (res === '1') {
                    goBack();
                    reloadList();
                } else {
                }
            }});

    });



        
</script>