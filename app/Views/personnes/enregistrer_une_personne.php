<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une personne</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Ajouter le style personnalisé ici */
        body {
            background-color: #fff;
        }

        .container {
            margin-top: 50px;
        }

        #ajoutPersonneForm {
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

        .btn-submit {
            background-color: #28a745; /* Couleur verte Bootstrap */
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-submit:hover {
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
        <h1>Enregistrez-vous !</h1>
    </header>
</div>

<div class="container">
    <form id="ajoutPersonneForm" method="post" action="" enctype="multipart/form-data">
        <div class="form-row">
            <div class="col">
                <label>Nom :</label>
                <input type="text" name="nom" required>
            </div>
            <div class="col">
                <label>Prénom :</label>
                <input type="text" name="prenom" required>
            </div>
        </div>

        <label>Sexe :</label>
        <select name="sexe" required>
            <option value="M">Masculin</option>
            <option value="F">Féminin</option>
        </select>

        <label>Type de personne :</label>
        <select name="type_personne" id="type_personne" required>
            <?php foreach ($typesPersonne as $typePersonne): ?>
                <option value="<?= $typePersonne->id ?>">
                    <?= $typePersonne->libelle ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Date de naissance :</label>
        <input type="date" name="date_naissance" required>

        <div id="photoField">
            <label>Photo :</label>
            <input type="file" name="photo">
        </div>

        <div class="btn-container">
                <a href="<?php echo base_url('/'); ?>" class="btn-add">Déjà enregistré ? voir la liste.</a>
                <input class="btn-submit" type="submit" id="btn-job-submit" value="VALIDER">
        </div>

    </form>
</div>



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

    
 