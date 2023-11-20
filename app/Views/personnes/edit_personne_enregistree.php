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

        <input type="hidden" id="edit-id" name="id" />

        <label for="edit-nom">Nom :</label>
        <input type="text" name="nom" value="<?= $personne->nom ?>" id="edit-nom" required><br>

        <label for="edit-prenom">Prénom :</label>
        <input type="text" name="prenom" value="<?= $personne->prenom ?>" id="edit-prenom" required><br>

        <label for="edit-sexe">Sexe :</label>
        <select name="sexe" id="edit-sexe" required>
            <option value="M" <?= ($personne->sexe === 'M') ? 'selected' : '' ?>>Masculin</option>
            <option value="F" <?= ($personne->sexe === 'F') ? 'selected' : '' ?>>Féminin</option>
        </select><br>

        <label for="type_personne">Type de personne :</label>
        <select name="type_personne" id="type_personne" required>
            <?php foreach ($typesPersonne as $type): ?>
                <option value="<?= $type->id ?>" >
                    <?= $type->libelle ?>
                </option>
            <?php endforeach; ?>
        </select><br>


        <label for="edit-date-naissance">Date de naissance :</label>
        <input type="date" name="date_naissance" value="<?= $personne->datenaissance?>" id="edit-date-naissance"  required><br>


        <div id="photoField" style="display: none;">
            <label for="edit-photo">Photo :</label>
            <input type="file" name="photo" id="edit-photo"><br>
        </div>

        <button type="submit" class="btn-update" id-personne="<?= $personne->id ?>">Mettre à jour</button>


    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
    <script>
        $(document).ready(function() {


            // Affichage de la photo quand Enseignant est selectionné
            $("#type_personne").change(function() {
                var selectedType = $(this).val();
                var photoField = $("#photoField");
                if (selectedType === "2") { 
                    photoField.show();
                } else {
                    photoField.hide();
                }
            });

        });


        
          // Ajax Update

          $('.btn-update').on('click', function () {
                 var idPersonne = $(this).attr('id-personne');
                // var idPersonne = $('#edit-id').val();
                var nom = $('#edit-nom').val();
                var prenom = $('#edit-prenom').val();
                var sexe = $('#edit-sexe').val();
                var typePersonne = $('#type_personne').val();
                var dateNaissance = $('#edit-date-naissance').val();
                var photo = $('#edit-photo').val();
                
                 console.log(idPersonne);  // Pour le débogage

                    $.ajax({
                        url: '<?php echo base_url('/update-personne'); ?>',
                        type: 'post',
                        data: {
                        id: idPersonne,
                        nom: nom,
                        prenom: prenom,
                        sexe: sexe,
                        type_personne: typePersonne,
                        date_naissance: dateNaissance,
                        photo: photo,
                    
                        },
                        dataType: 'json',  
                        success: function (response) {
                           
                            if (response.success) {

                                // Rechargez la page pour afficher la liste mise à jour des personnes
                                 window.location.reload();

                                //  alert('Personne mise à jour avec succès');        

                            } else {
                                // console.log(response);
                                alert('Échec de la mise à jour de la personne');
                            }
                        },
                        error: function (xhr, status, error) {
                            // console.log(idPersonne);
                            console.error(xhr.responseText); // Affiche la réponse complète dans la console
                            alert('Erreur lors de la communication avec le serveur');
                        }
                    });
                
            });

    </script>
</body>
</html>
