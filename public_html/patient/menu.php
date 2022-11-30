<div class="container">
	<div class="row ">			
		<nav class="col navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
			<form method='POST' action="../accueil.php">
	            <input class="btn btn-primary" type="submit" name="deconnexion" value="Deconnexion"/>
	        </form> 		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
			   <span class="navbar-toggler-icon"></span>
			</button>
			
			<div id="navbarContent" class="collapse navbar-collapse menu">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item mr-5"><a class="nav-link" href="../accueil.php">Accueil</a></li>
					<li class="nav-item mr-5"><a class="nav-link active" href="patient.php">Patients</a></li>
					<li class="nav-item mr-5"><a class="nav-link" href="../medecin/medecin.php">Médecins</a></li>
					<li class="nav-item mr-5"><a class="nav-link" href="../consultation/consultation.php">Consultations</a></li>
				</ul>
			</div>
		</nav>
	</div>
</div>