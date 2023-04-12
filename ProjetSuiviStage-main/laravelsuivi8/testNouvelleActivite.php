<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=suivi';
$username = 'root';
$password = 'root_pwd';

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

// Données à insérer dans la table "activite"
$id_template = 3;
$utilisateur_referent = 3;
$utilisateur_suivi = 100;
$date_debut = "2023-04-04 13:14:19";
$est_cloture = 0;

// Requête pour insérer les données dans la table "activite"
$sql_activite = "INSERT INTO activite (id_template, id_utilisateur_referent, id_utilisateur_suivi, date_debut, est_cloture) VALUES (:id_template, :id_utilisateur_referent, :id_utilisateur_suivi, :date_debut, :est_cloture)";
$stmt_activite = $db->prepare($sql_activite);
$stmt_activite->bindParam(':id_template', $id_template);
$stmt_activite->bindParam(':id_utilisateur_referent', $utilisateur_referent);
$stmt_activite->bindParam(':id_utilisateur_suivi', $utilisateur_suivi);
$stmt_activite->bindParam(':date_debut', $date_debut);
$stmt_activite->bindParam(':est_cloture', $est_cloture);



$stmt_activite->execute();

// ID de l'activité insérée
$id_activite = $db->lastInsertId();

// Données à insérer dans la table "valeur_attribut"
$id_localisation=1;
$localisation="Paris";
$id_nom_entreprise=2;
$nom_entreprise="EDF";
$id_sujet_stage=3;
$sujet_stage="Ce stage est l’occasion pour l’élève-ingénieur de développer à la fois sa compréhension des enjeux stratégiques de l'entreprise mais aussi de mieux appréhender la contribution des ingénieurs à la performance et au développement de celle-ci.";
$id_tuteur_externe=4;
$tuteur_externe="Jean Dupont";
$id_taches_confiees=5;
$taches_confiees="travailler";

// Requête pour insérer les données dans la table "valeur_attribut"
$sql_attribut = "INSERT INTO valeur_attribut (id_activite, id_attribut, valeur) VALUES (:id_activite, :id_attribut, :valeur)";
$stmt_attribut = $db->prepare($sql_attribut);
$stmt_attribut->bindParam(':id_activite', $id_activite);
$stmt_attribut->bindParam(':id_attribut', $id_localisation);
$stmt_attribut->bindParam(':valeur', $localisation);
$stmt_attribut->execute();

$stmt_attribut->bindParam(':id_activite', $id_activite);
$stmt_attribut->bindParam(':id_attribut', $id_nom_entreprise);
$stmt_attribut->bindParam(':valeur', $nom_entreprise);
$stmt_attribut->execute();

$stmt_attribut->bindParam(':id_activite', $id_activite);
$stmt_attribut->bindParam(':id_attribut', $id_sujet_stage);
$stmt_attribut->bindParam(':valeur', $sujet_stage);
$stmt_attribut->execute();

$stmt_attribut->bindParam(':id_activite', $id_activite);
$stmt_attribut->bindParam(':id_attribut', $id_tuteur_externe);
$stmt_attribut->bindParam(':valeur', $tuteur_externe);
$stmt_attribut->execute();

$stmt_attribut->bindParam(':id_activite', $id_activite);
$stmt_attribut->bindParam(':id_attribut', $id_taches_confiees);
$stmt_attribut->bindParam(':valeur', $taches_confiees);
$stmt_attribut->execute();



?>
