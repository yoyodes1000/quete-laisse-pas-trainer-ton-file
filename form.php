<?php

$errors = [];
$isUpload = false;
if($_SERVER['REQUEST_METHOD'] === "POST"){ 
    // Securité en php
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
    $uploadDir = 'public/uploads/';
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    // Je récupère l'extension du fichier
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // Les extensions autorisées
    $authorizedExtensions = ['jpg','jpeg','png','gif','webp'];
    // Le poids max géré par PHP par défaut est de 2M
    $maxFileSize = 1000000;

    $newName = uniqid('', true) . '.' . $extension;
  
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
    }
    /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
    $errors[] = "Votre fichier doit faire moins de 1M !";
    }
    /****** Si je n'ai pas d"erreur alors j'upload *************/
   /**
 */ if (empty($errors)) {
    $isUpload = move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $newName);
    }
}


?>
<?php 
foreach ($errors as $error) {
    echo $error;
} ?>

<form method="post" enctype="multipart/form-data">
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom">
    <br><br>
    <label for="prenom">Prenom</label>
    <input type="text" name="prenom" id="prenom">
    <br><br>
    <label for="imageUpload">Upload an profile image</label>    
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>

</form>
<?php if ($isUpload) {?>
<img src="/public/uploads/<?= $newName ?>" alt="une image de profil">
<p><?= $_POST['prenom'] . ' ' . $_POST['nom']?></p>
<?php } ?>