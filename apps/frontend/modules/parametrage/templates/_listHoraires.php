<table id="tableHoraire" class="table table-striped table-bordered table-hover dataTablesHoraires display responsive no-wrap" width="100%" >
    <thead>
        <tr>
            <th>Jour</th>
            <th>Heure début</th>
            <th>Heure fin</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($horaires as $horaire) {
            $days = RefHoraire::getDays();
            ?>
            <tr id="<?php echo $horaire->getIdHoraire() ?>"  onmousedown="setIdClic(event, '<?php echo $horaire->getIdHoraire() ?>');"  class="context-menu-one-horaires box menu-1">
                <td data-order="<?php echo $horaire->getJour(); ?>"><?php echo (isset($days[$horaire->getJour()]) ? $days[$horaire->getJour()] : ""); ?></td>
                <td id="horaire-debut-<?php echo $horaire->getJour() ?>"><?php echo $horaire->getHeureDebut(); ?></td>
                <td id="horaire-fin-<?php echo $horaire->getJour() ?>"><?php echo $horaire->getHeureFin(); ?></td>
            </tr><?php }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Jour</th>
            <th>Heure début</th>
            <th>Heure fin</th>
        </tr>
    </tfoot>
</table>