<table id="tableFerie" class="table table-striped table-bordered table-hover dataTablesFeries display responsive no-wrap" width="100%" >
    <thead>
        <tr>
            <th>Libelle</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($feries as $unFeries) {
            ?>
            <tr id="<?php echo $unFeries->getIdFerie() ?>" onmousedown="setIdClic(event, '<?php echo $unFeries->getIdFerie() ?>');"  class="context-menu-one-feries box menu-1">
                <td><?php echo $unFeries->getLibelle(); ?></td>
                <td><?php echo date('d/m/Y', strtotime($unFeries->getDate())) ?></td>
            </tr><?php }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Libelle</th>
            <th>Date</th>
        </tr>
    </tfoot>
</table>