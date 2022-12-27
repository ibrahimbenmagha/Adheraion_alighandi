<?php
session_start();
session_unset()
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
	<h2 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2"></h2>
	<h2 class="h2" id="h2"></h2>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="singnup-form">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-5">
						<div class="row" id="div3">

							<h1>Connexion :</h1>
							<hr>
							<h2 id="msg"></h2>
							<label class="form-label" for="email">Nom d'utilisateur :</label>
							<input class="form-control" type="text" name="username"><br>
							<label class="form-label" for="pass">Mot de passe :</label>
							<input class="form-control" type="password" name="pass">
							<input class="btn btn-success" type="submit" name="connet" value="Se connecter">
							<br>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



	<?php
	if (isset($_POST['connet'])) {
		if (!empty($_POST["username"]) && !empty($_POST["pass"])) {
			require "connDatabase.php";
			$users = $conn->prepare("SELECT * FROM maktab_lfar3");
			$users->execute();
			while ($use = $users->fetch()) {
				if ($use["num_respo"] == $_POST["pass"] && $use["nom_respo"] == $_POST["username"]) {
					// $iddd = $_POST["pass"];
					// $uusers = $conn->prepare("SELECT * FROM responsables ");
					// $uusers->execute(array($iddd));
					// while ($uus = $uusers->fetch()) {
					// 	if ($uus["num_respo"] = $iddd) {
					// 		$_SESSION['nom'] = $uus["nom_respo"];
					// 		$_SESSION['prenom'] = $uus["prenom_respo"];
					// 		$_SESSION['type_responsabilte'] = $uus["type_responsabilte"];
					// 		$_SESSION['rang_scout'] = $uus["rang_scout"];
					// 	}
					// }
					$_SESSION['nom']=$use["nom_respo"];
					$_SESSION["num"]=$use["num_respo"];
					header("location:add.php");
				}
				echo "error";
			}
		}
	}


	?>

</body>

</html>