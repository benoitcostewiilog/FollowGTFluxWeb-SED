<table>
  <tbody>
    <tr>
      <th>Code emplacement:</th>
      <td><?php echo $ref_emplacement->getCodeEmplacement() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $ref_emplacement->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $ref_emplacement->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $ref_emplacement->getCreatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('emplacements/edit?code_emplacement='.$ref_emplacement->getCodeEmplacement()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('emplacements/index') ?>">List</a>
