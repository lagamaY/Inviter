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
            display: none;
            margin-bottom: 20px;
        }

        .btn-update {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;

        }

        .btn-update:hover {
            background-color: #0056b3;
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

<div class="container">
    <form id="formulaire-modification" enctype="multipart/form-data" >
    
        <?= csrf_field() ?>

        <input type="hidden" id="edit-id" name="id"  />

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
    
</div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
    <script>
        $(document).ready(function() {


            // Affichage de la photo quand Enseignant est selectionné


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

            $('#edit-id').val(idPersonne);
            
            var formData = new FormData($('#formulaire-modification')[0]);

            // console.log("Données envoyées au serveur :");

            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ', ' + pair[1]);
            // }

            // debugger;
            $.ajax({
                url: '<?php echo base_url('/update-personne'); ?>',
                type: 'post',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status === 'success') {
 
                        //  window.location.reload();

                         window.location.href = '<?php echo base_url('/enregistrer-une-personne'); ?> ';

                        //  console.log(window.location.href);

                    } else {
                        alert('Échec de la mise à jour de la personne');
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
