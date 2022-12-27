<?php
session_start();
if (!isset($_SESSION['nom'])) {
	header("location:connexion.php");
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap.min.css">

	<title></title>
</head>

<body>
	<?php
	require "navbar.php";
	?>
	<div class="">
		<div>
			<table class="table table-striped">
				<tr>
					<td>Nom</td>
					<td>prenom</td>
					<td>numero d'inscription</td>
					<td>age </td>
					<td>date de date_naissance</td>
					<td>Group scout </td>
					<td>Rang scout</td>
					<td>Action</td>
					<td>Status d'adheration</td>
				</tr>
				<?php
				require "connDatabase.php";
				$affall = $conn->prepare("SELECT * FROM adherants");
				$affall->execute();

				while ($afa = $affall->fetch()) {
				?>
					<tr>
						<td><?= $afa["nom_adherant"] ?></td>
						<td><?= $afa["prenom_adherant"] ?></td>
						<td><?= $afa["num_inscription"] ?></td>
						<td><?= $afa["age"] ?></td>
						<td><?= $afa["date_naissance"] ?></td>
						<td><?= $afa["group_scout"] ?></td>
						<td> <?= $afa["rang"] ?></td>
						<td> <?= $afa["Statut_de_l'adheration"] ?></td>
						<td>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
								<button type="submit" name="del" class="btn btn-warning">Suprimer l'adherant</button>
								<button type="submit" name="edit" class="btn btn-warning">Modifier l'adherant</button>
								<input type="text" name="det" value="<?= $afa["num_inscription"] ?>" hidden>
							</form>
							<?php
							if (isset($_POST['del'])) {
								$_SESSION["iddel"] = $afa["num_inscription"];
								$findidtodell = $conn->prepare("DELETE FROM adherants WHERE num_inscription= :iidd");
								$findidtodell->bindValue(":iidd", $_SESSION["iddel"]);
								$findidtodell->execute();
							}
							if (isset($_POST["edit"])) {
								$idedit = $conn->prepare("SELECT * from adherants where num_inscription=:ditethis");
								$_SESSION["idediter"] = $afa["num_inscription"];
								$idedit->bindValue(":ditethis", $_SESSION["idediter"]);
								$_SESSION["nomediter"] = $afa["nom_adherant"];
								$_SESSION["prenomediter"] = $afa["prenom_adherant"];
								$_SESSION["ageediter"] = $afa["age"];
								$_SESSION["rang_editer"] = $afa["rang"];
								$_SESSION["mosa"]=$afa["mossahama"];
								$_SESSION["statusediter"] = $afa["Statut_de_l'adheration"];
								header("location:editadherant.php");
							}
							?>

						</td>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
	</div>
</body>

</html>