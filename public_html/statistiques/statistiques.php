<?php
    require('../verifAuth.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Statistiques</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="styleTableau.css" />

    </head>
    <body>
        <?php include('menu.php'); ?>
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron bg-info'>
                        <h1>Statistiques</h1>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class ="card">
                        <h4 class="card-title">Tableau de répartition des patients selon l'âge et le sexe</h4>
                        <div class="card-body">
                                <?php
                                    
                                    require('../connexionBD.php');
                                
                                    $requeteHommeMoins25ans = 'Inconnu';
                                    $requeteHommeMoins25ans = $linkpdo->prepare('SELECT count(*) AS res FROM Patient WHERE DATEDIFF(NOW(), date_naissance)/365 < 25 AND civilite LIKE \'Monsieur\'');
                                    $requeteHommeMoins25ans->execute();
                                    $hommeMoins25 = $requeteHommeMoins25ans->fetch()['res'];
                                    
                                    $requeteFemmeMoins25ans = 'Inconnu';
                                    $requeteFemmeMoins25ans = $linkpdo->prepare('SELECT count(*) AS res FROM Patient WHERE DATEDIFF(NOW(), date_naissance)/365 < 25 AND civilite LIKE \'Madame\' ');
                                    $requeteFemmeMoins25ans->execute();
                                    $femmeMoins25 = $requeteFemmeMoins25ans->fetch()['res'];
                                   
                                    $hommeEntre25et50= 'Inconnu';
                                    $requeteHommeEntre25et50 = $linkpdo->prepare('SELECT count(*) AS res FROM Patient WHERE DATEDIFF(NOW(), date_naissance)/365 BETWEEN 25 AND 50 AND civilite LIKE \'Monsieur\'');
                                    $requeteHommeEntre25et50->execute();
                                    $hommeEntre25et50 = $requeteHommeEntre25et50->fetch()['res'];
                                    
                                    $femmeEntre25et50 = 'Inconnu';
                                    $requeteFemmeEntre25et50 = $linkpdo->prepare('SELECT count(*) AS res FROM Patient WHERE DATEDIFF(NOW(), date_naissance)/365 BETWEEN 25 AND 50 AND civilite LIKE \'Madame\' ');
                                    $requeteFemmeEntre25et50->execute();
                                    $femmeEntre25et50 = $requeteFemmeEntre25et50->fetch()['res'];
                                    
                                    $hommePlus50= 'Inconnu';
                                    $requeteHommePlus50 = $linkpdo->prepare('SELECT count(*) AS res FROM Patient WHERE DATEDIFF(NOW(), date_naissance)/365 > 50 AND civilite LIKE \'Monsieur\'');
                                    $requeteHommePlus50->execute();
                                    $hommePlus50 = $requeteHommePlus50->fetch()['res'];
                                    
                                    $femmePlus50 = 'Inconnu';
                                    $requeteFemmePlus50 = $linkpdo->prepare('SELECT count(*) AS res FROM Patient WHERE DATEDIFF(NOW(), date_naissance)/365 > 50 AND civilite LIKE \'Madame\' ');
                                    $requeteFemmePlus50->execute();
                                    $femmePlus50 = $requeteFemmePlus50->fetch()['res'];
                                    
                                   
                                    
                                    $resultat = array("Moins de 25 ans"=>array($hommeMoins25, $femmeMoins25),
                                                    "Entre 25 et 50 ans"=>array($hommeEntre25et50, $femmeEntre25et50),
                                                    "Plus de 50 ans"=>array($hommePlus50, $femmePlus50));
                                    
                                ?>
                                
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Tranche d'âges</th>
                                        <th>Hommes</th>
                                        <th>Femmes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Moins de 25 ans</td>
                                        <td><?php echo $resultat["Moins de 25 ans"][0]; ?></td>
                                        <td><?php echo $resultat["Moins de 25 ans"][1]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Entre 25 et 50 ans</td>
                                        <td><?php echo $resultat["Entre 25 et 50 ans"][0]; ?></td>
                                        <td><?php echo $resultat["Entre 25 et 50 ans"][1]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Plus de 50 ans</td>
                                        <td><?php echo $resultat["Plus de 50 ans"][0]; ?></td>
                                        <td><?php echo $resultat["Plus de 50 ans"][1]; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col">
                    <div class ="card">
                        <h4 class="card-title">Tableau des durées de consultations de chaque médecin en heure</h4>
                        <div class="card-body">
                        
                        
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Médecin</th>
                                        <th>Durée des consultations effectuées</th>
                                        <th>Durée des consultations à venir</th>
                                        <th>Moyenne d'une consultation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include('../fonction.php');
                                        $recuperationMedecin = $linkpdo->prepare('SELECT id_medecin, nom FROM Medecin');
                                        $recuperationMedecin->execute();
                                        while($medecin = $recuperationMedecin->fetch()){
                                            $idMedecin = $medecin['id_medecin'];
                                            $nomMedecin = $medecin['nom'];
                                            
                                            
                                            $requeteDureeConsultEffectue = $linkpdo->prepare('SELECT SUM(TIME_TO_SEC(duree)) AS res FROM Rendez_vous WHERE id_medecin = :idmedecin AND date_rdv < NOW()');
                                            $requeteDureeConsultEffectue->execute(array('idmedecin'=>$idMedecin));
                                            $dureeEff = $requeteDureeConsultEffectue->fetch()['res'];
                                            $dureeEff = ConvertisseurTime($dureeEff);
                                            
                                            $requeteDureeConsultAvenir = $linkpdo->prepare('SELECT SUM(TIME_TO_SEC(duree)) AS res FROM Rendez_vous WHERE id_medecin = :idmedecin AND date_rdv >= NOW()');
                                            $requeteDureeConsultAvenir->execute(array('idmedecin'=>$idMedecin));
                                            $dureeAv = $requeteDureeConsultAvenir->fetch()['res'];
                                            $dureeAv = ConvertisseurTime($dureeAv);
                                            
                                            $requeteDureeConsultMoy = $linkpdo->prepare('SELECT AVG(TIME_TO_SEC(duree)) AS res FROM Rendez_vous WHERE id_medecin = :idmedecin');
                                            $requeteDureeConsultMoy->execute(array('idmedecin'=>$idMedecin));
                                            $dureeMoy = $requeteDureeConsultMoy->fetch()['res'];
                                            $dureeMoy = ConvertisseurTime($dureeMoy);
                                            
                                            echo "
                                            <tr>
                                                <td>$nomMedecin</td>
                                                <td>$dureeEff</td>
                                                <td>$dureeAv</td>
                                                <td>$dureeMoy</td>
                                            
                                            </tr>
                                            
                                            ";

                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>