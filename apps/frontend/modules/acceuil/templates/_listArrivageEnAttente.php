<?php
foreach ($receptionNonAchemine as $prod) {
    ?>
    <tr>
        <td><small><?php echo $prod['ref_produit'] ?></small></td>
        <td><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y H:i:s', strtotime($prod['created_at'])) ?></td>
    </tr>
<?php
} 