<table class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
    <thead>
        <tr>
            <th><?php echo __('N° d\'expédition'); ?></th>
            <th><?php echo __('Transporteur'); ?></th>
            <th><?php echo __('Chauffeur'); ?></th>
            <th><?php echo __('Immatriculation'); ?></th>
            <th><?php echo __('Lettre voiture'); ?></th>
            <th><?php echo __('Nb UM'); ?></th>
            <th><?php echo __('Date'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($expeditions as $expedition):?>
            <tr id="<?php echo $expedition->getIdExpedition() ?>" onmousedown="setIdClic(event, '<?php echo $expedition->getIdExpedition() ?>');"  class="context-menu-one box menu-1">
                <td class="click"><?php echo $expedition->getNumExpedition() ?></td>		
                <td class="click"><?php echo ($expedition->getRefTransporteur() ? $expedition->getRefTransporteur()->getLibelle() : $expedition->getIdTransporteur()) ?></td>
                <td class="click"><?php echo ($expedition->getRefChauffeur() ? $expedition->getRefChauffeur() : '') ?></td>
                <td class="click"><?php echo $expedition->getImmatriculation() ?></td>
                <td class="click"><?php echo $expedition->getLettreVoiture() ?></td>
                <td class="click"><?php echo $expedition->getNbColis() ?></td>
                <td class="click"><?php echo date('d/m/Y H:i:s', strtotime($expedition->getCreatedAt())) ?></td>
            </tr>
<?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('N° d\'expédition'); ?></th>
            <th><?php echo __('Transporteur'); ?></th>
            <th><?php echo __('Chauffeur'); ?></th>
            <th><?php echo __('Immatriculation'); ?></th>
            <th><?php echo __('Lettre voiture'); ?></th>
            <th><?php echo __('Nb UM'); ?></th>
            <th><?php echo __('Date'); ?></th>
        </tr>
    </tfoot>
</table>


<?php
foreach ($expeditions as $expedition) {
    $produits = array();
    foreach ($expedition->getWrkExpeditionProduit() as $expeditionProduits) {
        $produits[] = $expeditionProduits->getRefProduit();
    }
    include_partial('modalProduit', array('expedition' => $expedition, 'idExpedition' => $expedition->getIdExpedition(), 'produits' => $produits));
}
?>
<script>
    var table = null;
    $(document).ready(function () {
        $('.modalProduit').appendTo('body');
        $('table tr td.click').click(function () {
            showProduits($(this).parent().attr('id'));
        });
    });
</script>
<style>
    .mignature{
        width: 25px;
        height: 25px;
        cursor:zoom-in;
    }
    table tr td:not(.click){
        cursor: default;
    }
</style>