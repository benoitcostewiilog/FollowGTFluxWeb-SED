<div id="modalHoraires" class="modal inmodal fade" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Ajouter un horaire'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Jour :'); ?></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="selectDayHoraire" multiple="" data-placeholder="Choisir des jours">
                                <?php
                                $days = RefHoraire::getDays();
                                for ($i = 0; $i < count($days); $i++) {
                                    ?>
                                    <option value="<?php echo $i ?>"><?php echo $days[$i] ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Heure de début :'); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input id="heureDebutHoraire" class="form-control timepicker" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Heure de fin :'); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input id="heureFinHoraire" class="form-control timepicker" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button onclick="newHoraires();" id="updateButton" type="button" class="btn btn-primary"><?php echo __('Ajouter'); ?></button>
            </div>
        </div>
    </div>
</div>