<table>
  <tbody>
    <tr>
      <th>Id chauffeur:</th>
      <td><?php echo $ref_chauffeur->getIdChauffeur() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $ref_chauffeur->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $ref_chauffeur->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $ref_chauffeur->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('chauffeurs/edit?id_chauffeur='.$ref_chauffeur->getIdChauffeur()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('chauffeurs/index') ?>">List</a>
