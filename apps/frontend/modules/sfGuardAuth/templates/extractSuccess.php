<html>
	<body>

	<h2 text-align: center>Gestion des utilisateurs</h2><br/></th>

	<table>
  		<thead>
		    <tr class="entete">
		      <th><?php echo __('Numéro d\'utilisateur')?></th>
		      <th><?php echo __('Identifiant')?></th>
		      <th><?php echo __('Actif')?></th>
		      <th><?php echo __('Derniere connexion')?></th>
		      <th><?php echo __('Groupe')?></th>
			 </tr>
		 </thead>
 <tbody>
    <?php $ligne=0;
    foreach ($utilisateurs as $utilisateur):
    $tr = ($ligne%2 == 0) ? "<tr> " : "<tr class='surligne' >";
    echo $tr; ?>
	  <td style="text-align:center;"><?php echo $utilisateur->getId() ?></td>
	  <td style="text-align:center;"><?php echo $utilisateur->getUsername() ?></td>
      <td style="text-align:center"><?php echo $actif = ($utilisateur->getIsActive()) ? __('Oui') : __('Non');?></td>
	  <td><?php echo format_date($utilisateur->getLastLogin(),'U') ?></td>
	  <td style="text-align:center"><?php echo $utilisateur->getGroup() ?></td>
	</tr>
    <?php $ligne++;
    endforeach; ?>
  </tbody>
	</table>
	</body>
</html>


