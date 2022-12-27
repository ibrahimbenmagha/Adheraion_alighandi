<?php
session_start();
if (!isset($_SESSION['nom'])) {
	header("location:connexion.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
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
	</style>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<header>
		<?php
		require "navbar.php";
		?>
	</header>
	<section>
		<h2 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2">Ajouter un responsable</h2>
		<h2 class="h2" id="h2"></h2>
		<div class="container">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<div class="singnup-form">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-5">
							<div class="row" id="div3">
								<h3 class="h3 font-weight-bold text-uppercase px-3 py-2 px-0 px-lg-2">entrez les information</h3>

								<div class="mb-3 col-md-6">
									<label>الاسم الشخصي للقائد</label>
									<input type="text" name="Fnam" class="form-control">
								</div>

								<div class="mb-3 col-md-6">
									<label>الاسم العائلي للقائد</label>
									<input type="text" name="Lnam" class="form-control">
								</div>


								<div class="mb-3 col-md-6">
									<label> رقم التسجيل للقائد </label>
									<input type="text" name="idres" class="form-control">
								</div>



								<div class="mb-3 col-md-6">
									<label>المسؤولية</label> <br>
									<select name="RS">
										<option value="0">chose one </option>
										<option value="قائد الوحدة"> قائد الوحدة</option>
										<option value="قائد بوحدة السرب">قائد بوحدة السرب</option>
										<option value="قائد بوحدة الكتيبة">  قائد بوحدة الكتيبة </option>
										<option value="الإعلام"> الإعلام </option>
										<option value="الإدارة">الإدارة</option>
									</select>
								</div>
								

								<div class="mb-3 col-md-6">
									<label>  التدريب المحصل عليه </label>
									<select name="GRP">
										<option value="none">Chose one </option>
										<option value="لم يحصل على تدريب"> لم يحصل على تدريب</option>
										<option value="دورة المعلومات العامة "> دورة المعلومات العامة</option>
										<option value="دورة المعلومات الأساسية"> دورة المعلومات الأساسية</option>
										<option value="دورة المعلومات المتقدمة"> دورة المعلومات المتقدمة</option>
										<option value="الشارة الخشبية">الشارة الخشبية</option>

									</select>
								</div>

								<div class="mb-3 col-md-6">
									<button type="submit" name="ajout" class="btn btn-success">إضافة قائد</button>
								</div>


							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</body>
<?php
if (isset($_POST['ajout'])) {
	if (!empty($_POST['Fnam']) && !empty(['Lnam']) && !empty($_POST['idres']) && !empty(['RS']) && !empty(['GRP'])) {
		require "connDatabase.php";
		$_SESSION["Fnam"] = $_POST['Fnam'];
		$_SESSION["Lnam"] = $_POST['Lnam'];
		$_SESSION["idrespo"] = $_POST['idres'];
		$_SESSION["RS"] = $_POST['RS'];
		$_SESSION["GRP"] = $_POST['GRP'];
		$Respon = $conn->prepare("SELECT * FROM responsables");
		$result = false;
		$Respon->execute();
		while ($Res = $Respon->fetch()) {
			if ($_SESSION["idrespo"] == $Res["num_respo"] || ($_SESSION["Fnam"] == $Res["prenom_respo"] && $_SESSION["Lnam"] == $Res["nom_respo"])) {
				$result = true;
			}
		}
		if($result==false){
			$addreponsable=$conn->prepare("INSERT INTO 	responsables VALUES(:idid, :nnom, :pprenom, :rrang, :tyype)");
			$addreponsable->bindvalue(":idid",$_SESSION["idrespo"]);
			$addreponsable->bindvalue(":nnom",$_SESSION["Lnam"]);
			$addreponsable->bindvalue(":pprenom",$_SESSION["Fnam"]);
			$addreponsable->bindvalue(":rrang",$_SESSION["GRP"] );
			$addreponsable->bindvalue(":ttype",$_SESSION["RS"]);
			$addreponsable->execute();
		}else{

		}
	} else { ?>
		<script>
			document.getElementById('h2').innerHTML = 'Veuillez remplire les champs'
		</script>
<?php }}?>
</html>