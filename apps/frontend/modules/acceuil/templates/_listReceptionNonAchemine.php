
                <?php
                foreach ($receptionNonAchemine as $reception) {
                    ?>
                    <tr>
                        <td><small><?php echo $reception['ref_produit'] ?></small></td>
                           <td><i class="fa fa-clock-o"></i> <?php echo $reception['dtearrivage']?date('d/m/Y H:i:s', strtotime($reception['dtearrivage'])):"N/C" ?></td>
                        <td><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y H:i:s', strtotime($reception['heure_prise'])) ?></td>
                    </tr>
                    <?php
                }
                ?>
