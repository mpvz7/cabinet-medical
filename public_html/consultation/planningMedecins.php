<?php
  
    require('../verifAuth.php');
    
    //Affichage de tous les rendez-vous de tous les médecins à venir
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Consultation</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
         <?php
	        include('menu.php');
	   ?>
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron bg-info'>
                        <h1>Consultations</h1>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card p-2">
                        <div class="card-title">
                            <h2>Rendez-vous à venir</h2>
                        </div>
                        <div class="card-body">
                            <?php
                                if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>
                            <a class="btn btn-success" style="margin-left: 40%; margin-right: 40%" href="saisir.php">Ajouter une consultation</a>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <?php 
                    require('../connexionBD.php');
                    //Recupération des medecins
                    $requeteRecupMedecin = $linkpdo->prepare('SELECT id_medecin, nom FROM Medecin');
                    $requeteRecupMedecin->execute();
                  
                    while($medecin = $requeteRecupMedecin->fetch()){
                     
                        echo '<div class="col-6">
                                <div class="card p-5">
                                    <h3 class="card-title">Médecin : '.$medecin['nom'].'</h3>';
                           
                        //récupération des rendez-vous des médecins   
                        $today = date('Y-m-d');
                        $requeteRecupRdvMedecin = $linkpdo->prepare('SELECT nom, prenom, id_rdv, date_rdv, heure, duree 
                                                        FROM Rendez_vous, Patient
                                                        WHERE Rendez_vous.id_medecin = :idmedecin
                                                        AND date_rdv > :today
                                                        AND Patient.id_patient = Rendez_vous.id_patient
                                                        ORDER BY date_rdv, heure');
                                                        
                        $requeteRecupRdvMedecin->execute(array('idmedecin'=>$medecin['id_medecin'],
                                                'today'=>$today));
                        
                       
                        while($rdv = $requeteRecupRdvMedecin->fetch()){
                            $j = new DateTime($rdv['date_rdv']);
                            $j = $j->format('j-F-Y');
                            echo "Rendez-vous le ".$j." à : ".$rdv['heure']." avec le patient : <br/><strong>".$rdv['nom']." ".$rdv['prenom']."</strong>";
                            echo "<form method='POST' action='supprimerRdv.php'>
                                    <input type='hidden' value='".$rdv['id_rdv']."' name='idRdv'/>
                                    <input class='btn btn-danger' type='submit' name='supprimer' value='Annuler' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cette consultation ?');\"/>
                                    
                                </form>";
                       }
                        echo '  </div>
                            </div>';   
                    }
                ?>
                
            </div>
        </div>


</body>
</html>