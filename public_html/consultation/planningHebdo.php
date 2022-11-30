<?php
    require('../verifAuth.php');
    
    //Affichage d'un planning par semaine d'un médecin sélectionné
    
    if((!isset($_POST['access']) && !isset($_POST['suivant']) && !isset($_POST['precedent'])) || empty($_POST['nom']) || empty($_POST['id'])){
        $_SESSION['msg'] = "Veuillez choisir un calendrier de médecin.";
        header('Location: choixMedecin.php');
        exit();
        
    }else{
        $nom = $_POST['nom'];
        $id = $_POST['id'];
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Patient</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="styleTableau.css" />

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
                    <div class ="card">
                        <div class="card-title"><h4>Tableau de la semaine du medecin : <?php echo $nom; ?></h4></div>
                        
                        <div class="card-body">
                            
                            
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>" />
                                <input type="hidden" name="nom" value="<?php echo $_POST['nom']; ?>" />
                                <input class="btn btn-warning" type="submit" value="<<" name="precedent"/>
                                <a style="margin-right: 40%; margin-left: 40%;" class="btn btn-primary" href="choixMedecin.php">Retour</a>
                                
                                <input class="btn btn-warning" type="submit" value=">>" name="suivant"/>
                            </form>
                            <table>
                                <?php
                                
                                    //Changement de semaine
                                    if(isset($_POST['precedent'])){
                                        if($_SESSION['semaine'] != 0){
                                            $_SESSION['semaine'] -= 7;
                                        }
                                    }else if(isset($_POST['suivant'])){
                                        $_SESSION['semaine'] += 7;
                                    }else{
                                        $_SESSION['semaine'] = 0;
                                    }
                                    $premierJour = strftime(date("m/d", strtotime("this week"))); 
                                    
                                    
                                    $premierJour = strftime(date("m/d", strtotime($premierJour. ' + '.$_SESSION['semaine'].' days')));
                                    
                                    require('../connexionBD.php');
                                    
                                    
                                    $jour = array(null, 
                                    "Lundi ".strftime("%d-%m", strtotime($premierJour)), 
                                    "Mardi ".strftime("%d-%m", strtotime($premierJour. ' + 1 days')), 
                                    "Mercredi ".strftime("%d-%m", strtotime($premierJour. ' + 2 days')), 
                                    "Jeudi ".strftime("%d-%m", strtotime($premierJour. ' + 3 days')), 
                                    "Vendredi ".strftime("%d-%m", strtotime($premierJour. ' + 4 days')), 
                                    "Samedi ".strftime("%d-%m", strtotime($premierJour. ' + 5 days')), 
                                    "Dimanche ".strftime("%d-%m", strtotime($premierJour. ' + 6 days')));
                                    
                                    $jourEnDate = array(
                                        strftime("%d-%m", strtotime($premierJour)), 
                                        strftime("%d-%m", strtotime($premierJour. ' + 1 days')), 
                                        strftime("%d-%m", strtotime($premierJour. ' + 2 days')), 
                                        strftime("%d-%m", strtotime($premierJour. ' + 3 days')), 
                                        strftime("%d-%m", strtotime($premierJour. ' + 4 days')), 
                                        strftime("%d-%m", strtotime($premierJour. ' + 5 days')), 
                                        strftime("%d-%m", strtotime($premierJour. ' + 6 days')));
                                    
                                    
                                    echo "<tr><th>Heure</th>";
                                    
                                    //Affichage de l'entete du tableau
                                    
                                    for($x = 1; $x < 8; $x++)
                                        echo "<th>".$jour[$x]."</th>";
                                    echo "</tr>";
                                    
                                    //Declaration du dernier rendez-vous avec pour indice le nom du patient et l'heure à laquelle se termine le rendez vous
                                    $dernierRdv = array (null, null);
                                    
                                    //Tableau associant le jour de la semaine avec le dernierRdv de la journee actuel
                                    $dernierRendezVous = array($jourEnDate[0]=>$dernierRdv,
                                                         $jourEnDate[1]=>$dernierRdv,
                                                         $jourEnDate[2]=>$dernierRdv,
                                                         $jourEnDate[3]=>$dernierRdv,
                                                         $jourEnDate[4]=>$dernierRdv,
                                                         $jourEnDate[5]=>$dernierRdv,
                                                         $jourEnDate[6]=>$dernierRdv);
                                    
                                    //Affichage des heures de la grille
                                    //Parcours ligne par ligne
                                    for($j = 8; $j <= 19; $j += 0.5) {
                                        echo "<tr>";
                                        $heure = 0;
                                        
                                        for($i = 0; $i < 7; $i++) {
                                            //Affichage de la première colonne
                                            if($i == 0) {
                                                $heure = $j."h00";
                                                $heure = str_replace(".5h00", "h30", $heure);
                                                echo "<td class=\"time\">".$heure."</td>";
                                            }
                                            //Affichage des autres jours
                                            echo "<td>";
                                                
                                                $dateactuelle = $jourEnDate[$i];
                                               
                                                $heureactuelle;
                                                
                                                if($heure < 10){
                                                    $heureactuelle = '0';
                                                    $heureactuelle .= str_replace("h", ":", $heure).':00';
                                                }else{
                                                    $heureactuelle = str_replace("h", ":", $heure).':00';
                                                }
                                                
                                                //recuperation du rendez vous à l'heure et date courante
                                                $requete = $linkpdo->prepare('SELECT * FROM Rendez_vous 
                                                    WHERE id_medecin = :id 
                                                    AND DATE_FORMAT(date_rdv, \'%d-%m\') LIKE :dateactuelle
                                                    AND heure LIKE :heureactuelle ');
    
                                                $requete->execute(array('heureactuelle'=>$heureactuelle,
                                                                        'dateactuelle'=>$dateactuelle,
                                                                        'id'=>$id));
                                                                        
                                               
                                                //Si un rendez-vous est trouvé alors    
                                                if($requete->rowCount() != 0){
                                                    
                                                    while($data = $requete->fetch()){
                                                        
                                                        //Recuperation du nom du patient qui a pris rendez_vous
                                                        $requeteNomPatient = $linkpdo->prepare('SELECT nom, prenom FROM Patient WHERE id_patient = :id');
                                                        
                                                        $requeteNomPatient->execute(array('id'=>$data['id_patient']));
                                                        
                                                        while($donnee = $requeteNomPatient->fetch()){
                                                            $dernierPatient = $donnee['nom'].'<br/>'.$donnee['prenom'];
                                                            echo $dernierPatient.'<form action="supprimerRdv.php" method="POST">
                                                                    <input type="hidden" value="'.$data['id_rdv'].'" name="idRdv"/>
                                                                    <input class="btn btn-danger" type="submit" value="X" name="supprimer" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette consultation ?\');"/>
                                                                    </form>';
                                                        }
                                                        
                                                        //Stockage des informations du dernier rendez vous de la journee
                                                        $heureDernierRdv = date('H:i', strtotime($heureactuelle) + strtotime($data['duree']));
                                                        $dernierRdv = array($dernierPatient, $heureDernierRdv);
                                                        $dernierRendezVous[$dateactuelle] = $dernierRdv;
                                                    }    
                                                }else{
                                                    if($dernierRendezVous[$dateactuelle][1] >= $heureactuelle){
                                                        echo $dernierRendezVous[$dateactuelle][0];
                                                        
                                                    }else{
                                                          echo '<a href="saisir.php"><img height="45em" src="../images/ajouter.png" alt="Ajouter"/></a>';
                                                    }
                                                }

                                            echo "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


</body>
</html>