<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['nom'])) {
	header("location:connexion.php");
}
?>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="bootstrap.min.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style type="text/css">
		#bor {
			border-style: solid;
		}

		#div3 {
			background-color: grey;
		}

		.h3 {
			text-align: center;
			font-family: cursive;
		}

		.h2 {
			text-align: center;
			color: red;
			font-family: serif;
		}

		.j {
			visibility: hidden;
		}

		.bg-secondary {
			margin: 12px 12px;
		}
	</style>
</head>
<header>
	<?php
	require "navbar.php";
	?>
</header>

<body>
	<h2 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2">Modifier l'adhérant</h2>
	<h2 class="h2" id="h2"></h2>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="singnup-form">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-5">
						<div class="row" id="div3">
							<h3 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2">Modifier les informations</h3>
							<div class="mb-3 col-md-6">
								<label>Prenom</label>
								<input type="text" disabled name="Fname" class="form-control" value=<?= $_SESSION["prenomediter"] ?>>
							</div>

							<div class="mb-3 col-md-6">
								<label>Nom</label>
								<input type="text" disabled name="Lname" class="form-control" value=<?= $_SESSION["nomediter"] ?>>
							</div>

							<div class="mb-3 col-md-6">
								<label>Age </label>
								<input type="number" name="newage" class="form-control" value=<?= $_SESSION["ageediter"] ?>>
							</div>

							<div class="mb-3 col-md-6">
								<label> Valeur d'apport </label>
								<input type="number" name="Vappo" class="form-control" value=<?= $_SESSION["mosa"] ?>>
							</div>


							<div class="mb-3 col-md-6">
								<label> Numero d'adhération </label>
								<input type="text" name="idad" class="form-control" disabled value=<?=$_SESSION["idediter"] ?>>
							</div>


							<div class="mb-3 col-md-6">
								<label>Rang de scouts</label>
								<select name="NRSC">
									<option value="0">chose one </option>
									<option value="الاشبال والزهرات"> الاشبال والزهرات </option>
									<option value="الكشافة والمرشدات"> الكشافة والمرشدات </option>
									<option value="الكشاف المتقدم والرائدات"> الكشاف المتقدم و الرائدات </option>
									<option value="الجوالة والدليلات"> الجوالة و الدليلات </option>
									<option value="لقادة و القائدات "> القادة و القائدات </option>
								</select>
							</div>

							<div class="mb-3 col-md-6">
								<label> Status d'adhration </label>
								<select name="statuss">
									<option value="none"> Chose one </option>
									<option value="مفعل "> مفعل </option>
									<option value="غير مفعل">غير مفعل</option>
								</select>
							</div>

							<div class="mb-3 col-md-6">
								<button type="submit" name="modifier" class="btn btn-success">Modifier l'adhérant</button>
							</div>

							<?php
							if (isset($_POST["modifier"])) {
								require "connDatabase.php";
								if (!empty($_POST["NRSC"]) && !empty($_POST["statuss"]) && !empty($_POST["newage"]) && !empty($_POST["Vappo"])) {
									require "connDatabase.php";
									$_SESSION["newrang"] = $_POST["NRSC"];
									$_SESSION["statuss"] = $_POST["statuss"];
									$_SESSION["newage"] = $_POST["newage"];
									$_SESSION["newvaleur"] = $_POST["Vappo"] + $_SESSION["mosa"];
									$editertout = $conn->prepare("UPDATE adherants set age= :newage, rang= :newrang, mossahama= :newmo where num_inscription = :idde");
									$editertout->bindValue(":newage", $_SESSION["newage"]);
									$editertout->bindValue(":newrang", $_SESSION["newrang"]);
									$editertout->bindValue(":newmo", $_SESSION["newvaleur"]);
									$editertout->bindValue(":idde", $_SESSION["idediter"]);
									// $editertout->bindValue(":nwestatus", $_SESSION["statuss"]);

									$editertout->execute();
								}else{
									?><script>document.getElementById('h2').innerHTML = 'Veuillez remplire les champs'</script>;<?php
								}
							}
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>