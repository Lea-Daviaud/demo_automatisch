<?php
session_start();

if (isset($_POST['connexion'])) {
    if (empty($_POST['pseudo'])) {
        echo "Le champ Pseudo est vide.";
    } else {
        if (empty($_POST['mdp'])) {
            echo "Le champ Mot de passe est vide.";
        } else {
            $Pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES, "UTF-8");
            $MotDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "UTF-8");

            $mysqli = new mysqli("localhost", "root", "root", "demo_vik");

            if ($mysqli->connect_error) {
                echo "Erreur de connexion à la base de données.";
            } else {
                $stmt = $mysqli->prepare("SELECT * FROM membres WHERE pseudo = ? AND mdp = ?");
                $stmt->bind_param("ss", $Pseudo, $MotDePasse);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
                } else {
                    $_SESSION['pseudo'] = $Pseudo;
                    echo "Vous êtes à présent connecté !";
                }

                $stmt->close();
                $mysqli->close();
            }
        }
    }
}
?>
