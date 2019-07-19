<table class="table table-striped table-bordered table-hover dataTables ">
    <thead>
        <tr>
            <th><?php echo __('N° arrivage') ?></th>
            <th><?php echo __('N° reception') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($assBR as $uneAss) { ?>
            <tr>
                <td><?php echo $uneAss->getRefProduit() ?></td>
                <td><?php echo $uneAss->getBrSap() ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php echo __('N° arrivage') ?></th>
            <th><?php echo __('N° reception') ?></th>
        </tr>
    </tfoot>
</table>