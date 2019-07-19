<div id="modalSuppHoraires" class="modal inmodal fade" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Suppression des horaires'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"><?php echo __('Voulez-vous vraiment supprimer tous les horaires ? '); ?><span id="objectName"></span><br><strong><?php echo __('Cette action est irréversible !'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button onclick="deleteHoraires();" id="updateButton" type="button" class="btn btn-primary"><?php echo __('Supprimer'); ?></button>
            </div>
        </div>
    </div>
</div>