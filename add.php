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
		.bg-secondary{
			margin: 12px 12px;
		}
	</style>
	<title></title>
</head>

<body>
	<section>
		<header>
			<?php
			require "navbar.php";
			require "connDatabase.php";
			$infos = $conn->prepare("SELECT * FROM responsables where num_respo = :numrespo");
			$infos->bindValue(":numrespo", $_SESSION['num']);
			$infos->execute();
			while ($info = $infos->fetch()) {
				$_SESSION["prenom_respo"] = $info["prenom_respo"];
				$_SESSION['type_responsabilte'] = $info["type_responsabilte"];
				$_SESSION['rang_scout'] = $info["rang_scout"];
			}
			?>
		

		<h2 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2">Ajouter un adhérant</h2>
		<h2 class="h2" id="h2"></h2>
		<div class="container">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<div class="singnup-form">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-5">
							<div class="row" id="div3">
								<h3 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2">entrez les information</h3>
								<div class="mb-3 col-md-6">
									<label>Prenom</label>
									<input type="text" name="Fname" class="form-control">
								</div>

								<div class="mb-3 col-md-6">
									<label>Nom</label>
									<input type="text" name="Lname" class="form-control">
								</div>

								<div class="mb-3 col-md-6">
									<label>Age </label>
									<input type="number" name="age" class="form-control">
								</div>

								<div class="mb-3 col-md-6">
									<label>date de naissance </label>
									<input type="date" name="DateN" class="form-control">
								</div>

								<div class="mb-3 col-md-6">
									<label>date d'adhération </label>
									<input type="date" name="DateA" class="form-control">
								</div>


								<div class="mb-3 col-md-6">
									<label> Valeur d'apport </label>
									<input type="number" name="Vapp" class="form-control">
								</div>


								<div class="mb-3 col-md-6">
									<label> Numero d'adhération </label>
									<input type="text" name="idad" class="form-control">
								</div>

								<div class="mb-3 col-md-6">
									<label> Le sex </label> <br>
									<div id="bor">
										<input type="radio" class="j">
										<input type="radio" class="j">

										<input type="radio" name="sex" value="masculin"> M
										<input type="radio" name="sex" value="feminin"> F
									</div>
								</div>

								<div class="mb-3 col-md-6">
									<label>Rang de scouts</label>
									<select name="RSC">
										<option value="0">chose one </option>
										<option value="الاشبال والزهرات"> الاشبال والزهرات </option>
										<option value="الكشافة والمرشدات"> الكشافة والمرشدات </option>
										<option value="الكشاف المتقدم والرائدات"> الكشاف المتقدم و الرائدات </option>
										<option value="الجوالة والدليلات"> الجوالة و الدليلات </option>
										<option value="لقادة و القائدات "> القادة و القائدات </option>
									</select>
								</div>

								<div class="mb-3 col-md-6">
									<label> Groupe de scout </label>
									<select name="grp">
										<option value="none">Chose one </option>
										<option value="group éducatif Najma"> group éducatif Najma</option>
										<option value="group éducatif Andaloss">group éducatif Andaloss</option>
									</select>
								</div>

								<div class="mb-3 col-md-6">
									<button type="submit" name="ajouter" class="btn btn-success">Ajouter adhérant</button>
								</div>


							</div>
						</form>
					</div>
				</div>
			</div>
		</div>



		<?php
		if (isset($_POST['ajouter'])) {
			if (
				!empty($_POST['Fname']) && !empty($_POST["Lname"]) && !empty($_POST["age"]) && !empty($_POST["DateN"]) && !empty($_POST["DateA"]) &&
				!empty($_POST["RSC"]) && !empty($_POST["Vapp"]) && !empty($_POST["grp"]) && !empty($_POST['sex']) && !empty($_POST['idad'])
			) {
				require "connDatabase.php";
				$_SESSION['fname'] = $_POST['Fname'];
				$_SESSION['lname'] = $_POST["Lname"];
				$_SESSION['id'] = $_POST['idad'];
				$_SESSION['age'] = $_POST["age"];
				$_SESSION['daten'] = $_POST["DateN"];
				$_SESSION['DateA'] = $_POST["DateA"];
				$_SESSION['RSC'] = $_POST["RSC"];
				$_SESSION['vapp'] = $_POST["Vapp"];
				$_SESSION['grp'] = $_POST["grp"];
				$_SESSION['sex'] = $_POST['sex'];

				$baghi = $_SESSION['id'];
				$testid = $conn->prepare("SELECT * From adherants");
				$testid->execute();
				$ch = false;
				while ($ts = $testid->fetch()) {
					if ($_SESSION['id'] == $ts["num_inscription"] || ($_SESSION['fname'] == $ts["prenom_adherant"] && $_SESSION['lname'] == $ts["nom_adherant"])) {
						$ch = true;
					}
				}
				if ($ch == false) {
					$adherant = $conn->prepare("INSERT INTO adherants
						(num_inscription,nom_adherant, prenom_adherant, age, date_naissance, dateadhe, rang, gender, mossahama, group_scout)
					  VALUES(:id, :nom, :prenom, :age, :date_naissance, :dateadh, :rang, :gender, :mon, :groupe)");
					$adherant->bindvalue(":id", $_SESSION['id']);
					$adherant->bindvalue(":nom", $_SESSION['lname']);
					$adherant->bindvalue(":prenom", $_SESSION['fname']);
					$adherant->bindvalue(":age",	$_SESSION['age'] = $_POST["age"]);
					$adherant->bindvalue(":date_naissance", $_SESSION['daten']);
					$adherant->bindvalue(":dateadh", $_SESSION['DateA']);
					$adherant->bindvalue(":rang", $_SESSION['RSC']);
					$adherant->bindvalue(":gender", $_SESSION['sex']);
					$adherant->bindvalue(":groupe", $_SESSION['grp']);
					$adherant->bindvalue(":mon", $_SESSION['vapp']);
					$adherant->execute();
				} else {
		?>
					<script>
						document.getElementById('h2').innerHTML = 'Ce numero de reponsable existe deja Veuillez ajouter un nouveau  '
					</script>
				<?php
				}
			} else { ?>
				<script>
					document.getElementById('h2').innerHTML = 'Veuillez remplire les champs'
				</script>
		<?php
			}
		}

		?>



	</section>
</body>

</html>