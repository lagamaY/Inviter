<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des personnes enregistrées</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

  

  <style>
    

    .container {
    padding: 2rem 0rem;
    }

    h4 {
    margin: 2rem 0rem 1rem;
    }

    .table-image td,
    .table-image th {
    vertical-align: middle;
    }

    
    .btn-enregistrer-container {
        text-align: right; 
        margin-top: 2rem;
        margin-right: 230px;
    }

    .btn-enregistrer {
        display: inline-block;
    }

    h1{

        text-align: center;
        margin: 2rem 0rem 1rem;
        text-decoration: underline;
        
    }

  </style> 
    

</head>
<body>
 
    <h1>Liste des personnes enregistrées</h1>

    <div class="btn-enregistrer-container">
        <a href="<?= base_url('/enregistrer-une-personne'); ?>" class="btn btn-primary btn-enregistrer">Enregistrer une personne</a>
    </div>

    <div class="container">
    <div class="row">
        <div class="col-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Type de personne</th>
                <th scope="col">Sexe</th>
                <th scope="col">Date de naissance</th>
                <th scope="col">Photo</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($personnes as $personne) : ?>

            <tr id="personne-<?= $personne->id ?>">

                    <th scope="row"><?= $personne->id ?></th>

                    <td id-personne="<?= $personne->id ?>"><?= $personne->nom ?></td>
                    <td id-personne="<?= $personne->id ?>"><?= $personne->prenom ?></td>
                    <td id-personne="<?= $personne->id ?>">Type de personne</td>
                    <td id-personne="<?= $personne->id ?>"><?= $personne->sexe ?></td>
                    <td id-personne="<?= $personne->id ?>"><?= $personne->datenaissance ?></td>
                    <td id-personne="<?= $personne->id ?>" ><img src="<?php echo base_url('/public/photos/' . $personne->photo) ?>" width="100" height="100"></td>

                    <td>
                    
                    <button type="button"  class="edit-btn  btn btn-success " id-personne="<?= $personne->id ?>">Modifier</button>
                    <button type="button"  class="supprimer-personne delete-btn btn btn-danger" id-personne="<?= $personne->id ?>">Supprimer</button>

                    </td>

            </tr>

        <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>



    <!-- STYLE FIN  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            // Ajax edit 
            $('.edit-btn').on('click', function () {
            var idPersonne = $(this).attr('id-personne');
            // console.log(idPersonne);
            $.ajax({
                url: '<?php echo base_url('/edit-personne'); ?>',
                type: 'post',
                data: { id: idPersonne },
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    if (response.success) {

                        $('body').html(response.html);
                    
                    } else {
                        console.log(response);
                        alert('Échec de la récupération des données');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Erreur lors de la communication avec le serveur');
                }
            });
        });


      // Ajax Delete 

        $('.delete-btn').on('click', function () {
            var idPersonne = $(this).attr('id-personne');
            
            // console.log(idPersonne);  // Pour le débogage

            if (confirm("Êtes-vous sûr de vouloir supprimer cette personne?")) {
                $.ajax({
                    url: '<?php echo base_url('/supprimer-personne'); ?>',
                    type: 'post',
                    data: {id: idPersonne},
                    dataType: 'json',  // Indique le type de données attendu dans la réponse
                    success: function (response) {
                        // console.log(response);  // Pour le débogage
                        if (response.success) {
                            $('#personne-' + idPersonne).remove();
                        } else {
                            alert('Erreur lors de la suppression : ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText); // Affiche la réponse complète dans la console
                        alert('Erreur lors de la communication avec le serveur');
                    }
                });
            }
        });
     });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</body>
</html>

