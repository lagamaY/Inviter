<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une personne</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Ajouter le style personnalisé ici */
        body {
            background-color: #fff;
        }

        .container {
            margin-top: 30px;
        }

        #formulaire-modification {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        #photoField {
            
            margin-bottom: 20px;
        }


        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .btn-add {
            
            color: #007bff;
            text-decoration: none;
            display: inline-block;
            padding-top: 10px;
            
        }

        .btn-update {
            background-color: #28a745; /* Couleur verte Bootstrap */
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-update:hover {
            background-color: #218838; /* Couleur verte plus foncée au survol */
        }

        h1{
            margin-top: 15px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <header class="text-center">
            <h1>Modifier une personne</h1>
        </header>
    </div>

    <div class="container" id="formulaire-modification">

    <input type="hidden" id="edit-id" name="id" />

    <label for="edit-nom">Nom :</label>
    <input type="text" name="nom" value="<?= $personne->nom ?>" id="edit-nom" required>
    <span class="error text-danger" id="nomError"></span>
    <?php if (isset($errors['nom'])): ?>
        <span class="error text-danger"><?= $errors['nom'] ?></span>
    <?php endif; ?>

    <label for="edit-prenom">Prénom :</label>
    <input type="text" name="prenom" value="<?= $personne->prenom ?>" id="edit-prenom" required>
    <span class="error text-danger" id="prenomError"></span>
    <?php if (isset($errors['prenom'])): ?>
        <span class="error text-danger"><?= $errors['prenom'] ?></span>
    <?php endif; ?>

    <label for="edit-sexe">Sexe :</label>
    <select name="sexe" id="edit-sexe" required>
        <option value="M" <?= ($personne->sexe === 'M') ? 'selected' : '' ?>>Masculin</option>
        <option value="F" <?= ($personne->sexe === 'F') ? 'selected' : '' ?>>Féminin</option>
    </select>
    <span class="error text-danger" id="sexeError"></span>
    <?php if (isset($errors['sexe'])): ?>
        <span class="error text-danger"><?= $errors['sexe'] ?></span>
    <?php endif; ?>

    <label for="type_personne">Type de personne :</label>
    <select name="type_personne" id="type_personne" required>
        <?php foreach ($typesPersonne as $type): ?>
            <option value="<?= $type->id ?>" <?= ($type->libelle === $personne->libelleTypePersonne) ? 'selected' : '' ?>>
                <?= $type->libelle ?>
            </option>
        <?php endforeach; ?>
    </select>
    <span class="error text-danger" id="typePersonneError"></span>
    <?php if (isset($errors['type_personne'])): ?>
        <span class="error text-danger"><?= $errors['type_personne'] ?></span>
    <?php endif; ?>

    <label for="edit-date-naissance">Date de naissance :</label>
    <input type="date" name="date_naissance" value="<?= date('Y-m-d', strtotime($personne->datenaissance)) ?>" id="edit-date-naissance" required>
    <span class="error text-danger" id="datenaissanceError"></span>
    <?php if (isset($errors['datenaissance'])): ?>
        <span class="error text-danger"><?= $errors['datenaissance'] ?></span>
    <?php endif; ?>

    <div id="photoField" <?= ($personne->photo === "etudiant_photo") ? 'style="display:none;"' : ''; ?>>
        <label for="edit-photo">Photo :</label>
        <input type="file" name="photo" id="edit-photo" class="affichePhotoSelectionnee" accept="image/*">
        <?php if ($personne->photo !== "etudiant_photo"): ?>
            <img id="current-photo" src="<?= base_url('/public/photos/' . $personne->photo) ?>" alt="Photo actuelle">
        <?php endif; ?>
        <br>
        <span class="error text-danger" id="photoError"></span>
        <?php if (isset($errors['photo'])): ?>
            <span class="error text-danger"><?= $errors['photo'] ?></span>
        <?php endif; ?>
    </div>

    <div class="btn-container">
        <a href="<?php echo base_url('/'); ?>" class="btn-add">Déjà enregistré ? voir la liste.</a>
        <button type="submit" class="btn-update" id-personne="<?= $personne->id ?>">Mettre à jour</button>
    </div>

</div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- Gestion du champ photo -->
    
    <script>
        $(document).ready(function() {



            

            // Gestion de l'image
            var photoField = $("#photoField");

            var currentPhoto = $("#current-photo");

            // Afficher ou cacher le champ photo en fonction tu type de personnes sélectionné

            $("#type_personne").change(function() {

                var selectedType = $(this).val();

                if (selectedType === "2") {
                    // Affiche le champ de la photo si type personne = "Enseignant"
                    photoField.show();
                } else {
                    // Cache le champ de la photo pour les types autres que "Enseignant"
                    photoField.hide();
                }
            });




            // Afficher la nouvelle image chargée par la personne de type Enseignant
            // lors de l'édition du formulaire à la place de la précédente image

            $("#edit-photo").change(function() {

                // Affiche la nouvelle image sélectionnée

                var input = this;

                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function(e) {

                        currentPhoto.attr('src', e.target.result);
                        

                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
   




    // <!-- ajax update  -->
    
     

            $('.btn-update').on('click', function () {
                var idPersonne = $(this).attr('id-personne');
                $('#edit-id').val(idPersonne);

                var formData = new FormData();
                formData.append('id', $('#edit-id').val());
                formData.append('nom', $('#edit-nom').val());
                formData.append('prenom', $('#edit-prenom').val());
                formData.append('sexe', $('#edit-sexe').val());
                formData.append('type_personne', $('#type_personne').val());
                formData.append('date_naissance', $('#edit-date-naissance').val());

                if ($("#type_personne").val() === "2") {
                    // Ajouter la gestion du champ photo si nécessaire
                    var photo = $('#edit-photo')[0].files[0];
                    formData.append('photo', photo);
                }

                $.ajax({
                    url: '<?php echo base_url('/update-personne'); ?>',
                    type: 'post',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.success) {
                            alert(data.message); // Afficher le message de succès
                            $('body').html(data.html);
                        } else {
                            // Si des erreurs sont présentes, remplissez les balises span correspondantes
                            $.each(data.errors, function (key, value) {
                                $('#' + key + 'Error').html(value);
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Erreur lors de la communication avec le serveur');
                    }
                });
            });
       

    </script>
</body>
</html>
