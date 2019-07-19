
                <?php
                foreach ($receptionNonAchemine as $reception) {
                    ?>
                    <tr>
                        <td><small><?php echo $reception['ref_produit'] ?></small></td>
                        <td><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y H:i:s', strtotime($reception['created_at'])) ?></td>
                    </tr>
                    <?php
                }
                ?>
