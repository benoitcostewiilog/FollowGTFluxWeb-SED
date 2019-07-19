<?php
foreach ($mouvements as $mouvement) {
    ?>
    <tr>
        <td><small><?php echo $mouvement['ref_produit'] ?></small></td>
        <td><i class="fa fa-clock-o"></i> <?php echo $mouvement['heure_prise']?date('d/m/Y H:i:s', strtotime($mouvement['heure_prise'])):"N/C" ?></td>
        <td  > <?php echo $mouvement['time'] ?> </td>
    </tr>
<?php
} 