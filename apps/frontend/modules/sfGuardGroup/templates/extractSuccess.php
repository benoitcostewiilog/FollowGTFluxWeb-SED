<html>
	<body>

	<h2 text-align: center>Gestion des groupes</h2><br/></th>

	<table>
  		<thead>
		    <tr class="entete">
		      <th><?php echo __('Nom')?></th>
		      <th><?php echo __('Description')?></th>
			 </tr>
		 </thead>
 <tbody>
    <?php $ligne=0;
	foreach ($groupes as $groupe):
		$tr = ($ligne%2 == 0) ? "<tr> " : "<tr class='surligne' >";
		echo $tr; ?>
	  <td style="text-align:center;"><?php echo $groupe->getName() ?></td>
      <td style="text-align:center;"><?php echo $groupe->getDescription() ?></td>
	</tr>
    <?php $ligne++;
		endforeach; ?>
  </tbody>
	</table>
	</body>
</html>


