<div id="modalFeries" class="modal inmodal fade" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Ajouter un jour férié'); ?></h4>
            </div>
            <div class="modal-body">
                <legend><input type="radio" id="jourRadio" name="typeFerie" checked="checked"> Ajouter un jour férié</legend>
                <div id="jourTable" class="form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Libellé :'); ?></label>
                        <div class="col-sm-10"><input id="libFerie" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('Date :'); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input id="dateJourFerie" class="form-control datetimepicker" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <legend><input type="radio" id="ferieRadio" name="typeFerie"> Ajouter les jours fériés français  </legend>
                <div id="feriesTable" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Année :'); ?></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="selectAnnee" disabled="disabled">
                                <?php for ($i = date('Y'); $i <= date('Y') + 10; $i++) { ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button onclick="enregistrerFeries();" id="saveButton" type="button" class="btn btn-primary" data-dismiss="modal"><?php echo __('Enregistrer'); ?></button>
            </div>
        </div>
    </div>
</div>