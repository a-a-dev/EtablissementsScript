<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Etablissements Script</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
</head>
<body>
<div class="container">
<?php include 'dbConfig.php'; ?>

	<h1>Liste des établissements</h1>

	<table id="table" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Identifiant</th>
				<th class="text-center">Nom</th>
				<th class="text-center">Adresse</th>
				<th class="text-center">Code Postal</th>
				<th class="text-center">Horaire d'ouverture</th>
				<th class="text-center">Nombre de chambres</th>
				<th class="text-center">Types de chambres</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$document = '<?xml version = "1.0" encoding="UTF-8" standalone="yes" ?>'."\n";
			$document .= '<hotels>'."\n";

			$query = "SELECT * FROM `etablissement`";

			if ($result = $connection->query($query)) {
				while ($row = $result->fetch_assoc()) {
					
					$document .=  "\t".'<hotel Identifient="'.$row['id_etablissement'].'">'."\n";

					?>
					<tr>
						<td><?php echo $row['id_etablissement'] ?></td>
						<?php $document .=  "\t\t".'<nom><![CDATA['.utf8_encode($row['nom_etablissement']).']]></nom>'."\n"; ?>
						<td class="text-center"><?php echo utf8_encode($row['nom_etablissement']) ?></td>
						<?php $document .= "\t\t".'<adresse><![CDATA['.utf8_encode($row['adresse']).']]></adresse>'."\n"; ?>
						<td class="text-center"><?php echo utf8_encode($row['adresse']) ?></td>
						<?php $document .= "\t\t".'<code_postal>'.$row['code_postal'].'</code_postal>'."\n"; ?>
						<td class="text-center"><?php echo $row['code_postal'] ?></td>
						<?php $document .= "\t\t".'<horaire_ouverture><![CDATA['.utf8_encode($row['horaire_ouverture']).']]></horaire_ouverture>'."\n"; ?>
						<td class="text-center"><?php echo $row['horaire_ouverture'] ?></td>
						<?php 
							$query1 = "SELECT `numero_chambre` FROM `etablissement_num_chambre` WHERE `id_etablissement` = ". $row['id_etablissement'];
							$nb = 0;

							if ($result1 = $connection->query($query1)) {
								while ($row1 = $result1->fetch_assoc()) {
									$nb = $nb + $row1['numero_chambre'];
								}
								$result1->free();
							}
						?>
						<?php $document .= "\t\t".'<nombres_chambres>'.$nb.'</nombres_chambres>'."\n"; ?>
						<td class="text-center"><?php echo $nb; ?></td>
						<?php $document .= "\t\t".'<types>'."\n"; ?>
						<?php 
							$query2 = "SELECT `nom` FROM `etablissement_type_chambre` WHERE `id_etablissement` = ".  $row['id_etablissement'];
							$type = "";
							if ($result2 = $connection->query($query2)) {
								while ($row2 = $result2->fetch_assoc()) {
									$document .= "\t\t\t".'<type><![CDATA['.utf8_encode($row2['nom']).']]></type>'."\n";;
									$type .= $row2['nom'] ." ";
								}
								$result2->free();
							}
						?>
						<?php $document .= "\t\t".'</types>'."\n"; ?>
						<td class="text-center"><?php echo $type; ?></td>
					</tr>
				<?php
					$document .= "\t".'</hotel>'."\n\n";
				}
				$result->free();
			} 

			$document .= '</hotels>'."\n";

			file_put_contents("etablissements_script.xml", $document);

			?>
		</tbody>
	</table>

	<a href='etablisements_sans_jointure.xml' class="btn btn-primary" target='_blank'>Export en XML</a>
	<br><br>
		
</div>

	<script type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.table').DataTable(
				{
                    language: {
                        processing: "Traitement en cours...",
                        search: "Rechercher&nbsp;:",
                        lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                        info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                        infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                        infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                        infoPostFix: "",
                        loadingRecords: "Chargement en cours...",
                        zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                        emptyTable: "Aucune donnée disponible dans le tableau",
                        paginate: {
                            first: "Premier",
                            previous: "Pr&eacute;c&eacute;dent",
                            next: "Suivant",
                            last: "Dernier"
                        },
                        aria: {
                            sortAscending: ": activer pour trier la colonne par ordre croissant",
                            sortDescending: ": activer pour trier la colonne par ordre décroissant"
                        }
                    }
                }
			);

		});
	</script>
</body>
</html>