<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ajouter une personne</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    


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
                <input type="text" name="nom" >
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
        <input type="text" name="date_naissance" id="date" placeholder="Choisir une date" required>

        <div id="photoField">
            <label for="edit-photo" >Photo :</label>
            <input type="file" name="photo" id="edit-photo" accept="image/*" >
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

    <?php if (session()->has('alert')) : ?>
    <script>
        alert("<?= session('alert') ?>");
    </script>
    <?php endif; ?>
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>                       
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>                     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.fr.min.js"></script>  


    
    <script>



        $(document).ready(function() {


            // Gestion de l'input date 
            $('#date').datepicker({
                isRTL: true,
                autoclose: true,
                todayHighlight: true,
                language: 'fr',
                format: 'dd-mm-yyyy',
                endDate: '-15y',  // Limiter la date maximale à aujourd'hui moins 15 ans
                beforeShowDay: function (date) {
                    // Calculer l'âge en années
                    var today = new Date();
                    var age = today.getFullYear() - date.getFullYear();

                    // Si l'âge est inférieur à 15 ans, désactiver la date
                    return [age >= 15, ''];
                }
            });
                
 


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
            // Vérifier le type de personne
            var selectedType = $('#type_personne').val();
            
            // Si le type de personne est égal à 2, vérifier si un fichier a été sélectionné
            if (selectedType === "2") {
                var photoInput = $('#edit-photo');

                // Vérifier si un fichier a été sélectionné
                if (photoInput[0].files.length === 0) {
                    alert("Veuillez sélectionner une photo.");
                    return false; // Empêcher l'envoi du formulaire
                }
            }

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

    
 