<?php
	session_start();
?>	
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/GameNasaYuwe/nasayuwe/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	</head>
	<body>
		<form method="POST" >
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="font-size:15px;">
				<img style="height:105px;" src="/GameNasaYuwe/nasayuwe/images/escudo.jpeg" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<ul class="navbar-nav ml-auto">
					<a style="font-weight:bold;color:#ffffff" class="nav-link dropdown-toggle" href="/GameNasaYuwe/nasayuwe/web/index.php" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuario: <?php echo $_SESSION['txtUsuario']; ?></a>
				</ul>
			</nav>
		</form>
	</body>
</html>