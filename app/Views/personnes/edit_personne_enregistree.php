<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Ajouter une personne</h1>
    <form id="ajoutPersonneForm" method="post" action=""  enctype="multipart/form-data">
        <label>Nom :</label>
        <input type="text" name="nom" required><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" required><br>

        <label>Sexe :</label>
        <select name="sexe" required>
            <option value="M">Masculin</option>
            <option value="F">Féminin</option>
        </select><br>

        <label>Type de personne :</label>
        <select name="type_personne" id="type_personne" required>
            <?php foreach($typesPersonne as $typePersonne): ?>
                <option value="<?= $typePersonne->id ?>"> 
                        <?= $typePersonne->libelle  ?> 
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" required><br>

        <div id="photoField" style="display: none;">
            <label>Photo :</label>
            <input type="file" name="photo"><br>
        </div>

        <input class="btn-submit" type="submit" id="btn-job-submit" value="VALIDER">
    </form>
</body>
</html>