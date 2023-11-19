<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une personne</title>
</head>
<body>
    
    <form id="formulaire-modification" >
    
    <h1>Modifier une personne</h1>
        <?= csrf_field() ?>

        <label>Nom :</label>
        <input type="text" name="nom" value="<?= $personne->nom ?>" required><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= $personne->prenom ?>" required><br>

        <label>Sexe :</label>
        <select name="sexe" required>
            <option value="M" <?= ($personne->sexe === 'M') ? 'selected' : '' ?>>Masculin</option>
            <option value="F" <?= ($personne->sexe === 'F') ? 'selected' : '' ?>>Féminin</option>
        </select><br>

        <label>Type de personne :</label>
        <select name="type_personne" id="type_personne" required>
            <?php foreach ($typesPersonne as $type): ?>
                <option value="<?= $type->id ?>" >
                    <?= $type->libelle ?>
                </option>
            <?php endforeach; ?>
        </select><br>


        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" value="<?= $personne->datenaissance?>" required><br>

        <div id="photoField" style="display: none;">
            <label>Photo :</label>
            <input type="file" name="photo"><br>
        </div>

        <button type="button" id="btn-update">Mettre à jour</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
    <script>
        $(document).ready(function() {
            // Affichage de la photo quand Professeur est selectionné
            $("#type_personne").change(function() {
                var selectedType = $(this).val();
                var photoField = $("#photoField");
                if (selectedType === "2") { 
                    photoField.show();
                } else {
                    photoField.hide();
                }
            });


            // Envoie des données du formulaire à la route Post
            $('#btn-job-submit').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:'<?= route_to('personnes.store') ?>',
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data) {
                    if (data.status === 'success') {
                        
                    } else {
                        // Afficher un message d'erreur
                        alert('Erreur : ' + data.message);
                    }
                },
                
            error: function () {
                console.error('Une erreur s\'est produite lors de la requête AJAX.');
            }
                })
            })

        });
    </script>
</body>
</html>
