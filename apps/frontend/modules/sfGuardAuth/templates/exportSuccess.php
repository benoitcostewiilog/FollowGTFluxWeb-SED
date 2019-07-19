<?php echo include_http_metas() ?>
<style>
table, tr, td, th {
	border:1px solid black;
	border-collapse:collapse;
	text-align:center;
	vertical-align:middle;
	margin-left: auto;
	margin-right: auto;
}
#logo {
	width:125px;
}

#printer {
    width:45px;
    height:45px;
    opacity:0.5;
    position:fixed;
    top:50px;
    right:50px;
    text-indent:-9999px;
    cursor:pointer;
}

#back {
    width:45px;
    height:45px;
    opacity:0.5;
    position:fixed;
    top:100px;
    right:50px;
    text-indent:-9999px;
    cursor:pointer;
}


</style>
<script type="text/javascript">

function imprimer() {
	document.getElementById('printer').style.display = 'none'; 
	document.getElementById('back').style.display = 'none'; 
	history.back();
	window.print();
}

</script>

<div>


<img id="logo" src="
<?php 
if($print) {
	echo image_path('logo_aeroport.jpg');
} else 
	echo sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.'logo_aeroport.jpg'; 
?>">

<?php if($print) {
	?><img id="printer" src="<?php echo image_path('printer.png') ?>" onclick="imprimer();">
	<img id="back" src="<?php echo image_path('retour.png') ?>" onclick="history.back();"><?php 
} ?>
</div>
<div style="text-align:center; margin-bottom:70px">
	<div style="width:500px; margin-left:auto; margin-right:auto;">
		<h1 style="margin-bottom:-1px">Liste des utilisateurs</h1>
		<h3 style="margin-top:-1px">Date : <?php echo $date ?></h3>
	</div>
	<div style="width:500px; margin-left:auto; margin-right:auto;">
		<span>©2013 - MobileStock - MobileIT</span>
	</div>
</div>


<table cellpadding="5">
<thead>
	<tr>
      <th><?php echo __('Numéro d\'utilisateur')?></th>
      <th><?php echo __('Identifiant')?></th>
      <th><?php echo __('Actif')?></th>
      <th><?php echo __('Dernière connexion')?></th>
      <th><?php echo __('Groupe')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($utilisateurs as $utilisateur){ ?>
 	<tr>
	  <td style="text-align:center;"><?php echo $utilisateur->getId() ?></td>
	  <td style="text-align:center;"><?php echo $utilisateur->getUsername() ?></td>
      <td style="text-align:center"><?php echo $actif = ($utilisateur->getIsActive()) ? __('Oui') : __('Non');?></td>
	  <td><?php echo format_date($utilisateur->getLastLogin(),'U') ?></td>
	  <td style="text-align:center"><?php echo $utilisateur->getGroup() ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>