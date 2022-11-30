<?php
    include('../verifAuth.php');
    
  //Ajout des informations du médecin

    if(isset($_POST['ajouter'])){

        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['civilite'])){

            require('../connexionBD.php');

            $ajoutMedecin = $linkpdo->prepare('INSERT INTO  Medecin 
                                               VALUES (null,
                                                        :civilite,
                                                        :nom,
                                                        :prenom)');

            $ajoutMedecin->execute(array('civilite'=>$_POST['civilite'],
                                                       'nom'=>$_POST['nom'],
                                                        'prenom'=>$_POST['prenom']));

            $_SESSION['msg'] = "Le médecin a été ajouté";
            header('Location: medecin.php');
            exit();

        }else{
            $_SESSION['msg'] = "<p>Veuillez renseigner tout les champs.<p>";
            header('Location: ajouter.php');
            exit();
        }
    }


?>