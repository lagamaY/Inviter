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

        #btn-job-submit-ajax {
            margin-left: 55px;
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
            <label for="edit-photo" >Photo :</label>
            <input type="file" name="photo" id="edit-photo" accept="image/*" required>
            <img id="previewPhoto" src="#" alt="Aperçu de la photo" style="display:none;">

        </div>


        <div class="btn-container">
            <a href="<?php echo base_url('/'); ?>" class="btn-add">Déjà enregistré ? </a>
            <button class="btn-submit" type="button" id="btn-job-submit-ajax">Enregistrer</button>
            <button class="btn-submit" type="submit" id="btn-job-submit-php" name="submit_php">Enregistrer & Quitter</button>

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


          // Afficher la nouvelle image chargée par la personne de type Enseignant

            $("#edit-photo").change(function () {
                var input = this;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        // Afficher l'aperçu de la photo
                        $('#previewPhoto').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });



        // Envoie des données du formulaire à la route PHP
            $('#btn-job-submit-php').on('click', function(event) {
            // Utilisez le formulaire standard pour l'envoi PHP
            $('#ajoutPersonneForm').attr('action', '<?php echo base_url('/enregistrer-avec-php'); ?>');
          });


        // Envoie des données du formulaire à la route Post avec AJAX
        $('#btn-job-submit-ajax').on('click', function(event) {
            event.preventDefault();
            sendFormData('<?php echo base_url('/enregistrer-avec-ajax'); ?>');
        });

        // Traitement des données du formulaire à la route Post avec AJAX
        function sendFormData(url) {
            $.ajax({
                url: url,
                method: "POST",
                data: new FormData($('#ajoutPersonneForm')[0]),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        alert(data.message); // Afficher le message de succès
                        $('body').html(data.html);
                    } else {
                        // Afficher un message d'erreur
                        alert("Échec de l'enregistrement, veuillez remplir tous les champs svp !");
                        console.log(response.message);
                    }
                },
                error: function() {
                    // Afficher un message d'erreur
                    alert("Échec de l'enregistrement, veuillez remplir tous les champs svp !");
                    console.error('Une erreur s\'est produite lors de la requête AJAX.');
                }
            });
        }
    });

    </script>
</body>
</html>

    
 