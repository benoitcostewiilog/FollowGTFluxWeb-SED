<table class="table table-striped table-bordered table-hover dataTables display responsive no-wrap" width="100%" >
    <thead>
        <tr>
            <th><?php echo __('Création'); ?></th>
            <th><?php echo __('Fournisseur'); ?></th>
            <th><?php echo __('N° Tracking Fournisseur'); ?></th>

            <th><?php echo __('Transporteur'); ?></th>
            <th><?php echo __('Commande achat'); ?></th>
            <th><?php echo __('Fourchette date livraison'); ?></th>
            <th><?php echo __('Contact PFF'); ?></th>
             <th><?php echo __('Date arrivage'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($urgences as $urgence): ?>
            <tr id="<?php echo $urgence->getIdUrgence() ?>" onmousedown="setIdClic(event, '<?php echo $urgence->getIdUrgence() ?>');"  class="context-menu-one box menu-1">

                <td class="click"><?php echo date('d/m/Y H:i:s', strtotime($urgence->getCreatedAt())) ?></td>
                <td class="click"><?php echo ($urgence->getRefFournisseur() ? $urgence->getRefFournisseur()->getLibelle() : '') ?></td>
<td class="click"><?php echo ($urgence->getTrackingFour()) ?></td>

                <td class="click"><?php echo ($urgence->getRefTransporteur() ? $urgence->getRefTransporteur()->getLibelle() : '') ?></td>
                <td class="click"><?php echo ($urgence->getCommandeAchat()) ?></td>
               <td class="click"><?php echo ($urgence->getDateLivraisonDebut()?date('d/m/Y H:i:s', strtotime($urgence->getDateLivraisonDebut())):"")." - ".($urgence->getDateLivraisonFin()?date('d/m/Y H:i:s', strtotime($urgence->getDateLivraisonFin())):"") ?></td>
              <td class="click"><?php echo ($urgence->getRefInterlocuteur() ? ($urgence->getRefInterlocuteur()->getNom()." ".$urgence->getRefInterlocuteur()->getPrenom()) : '') ?></td>
                <td class="click"><?php echo ($urgence->getWrkArrivage() && $urgence->getWrkArrivage()->getCreatedAt() ? date('d/m/Y H:i:s', strtotime($urgence->getWrkArrivage()->getCreatedAt())) : "") ?></td>
              
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
          <th><?php echo __('Création'); ?></th>
            <th><?php echo __('Fournisseur'); ?></th>
            <th><?php echo __('N° Tracking Fournisseur'); ?></th>

            <th><?php echo __('Transporteur'); ?></th>
            <th><?php echo __('Commande achat'); ?></th>
            <th><?php echo __('Fourchette date livraison'); ?></th>
            <th><?php echo __('Contact PFF'); ?></th>
              <th><?php echo __('Date arrivage'); ?></th>
        </tr>
    </tfoot>
</table>

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