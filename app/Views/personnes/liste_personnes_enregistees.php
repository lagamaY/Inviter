<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">



</head>
<body>
  <!-- View: liste_personnes_enregistrees.php --> 
 

<a href=" <?php echo base_url('/enregistrer-une-personne'); ?>" class="btn-add">Enregistrer une personne</a>


  <h1>Liste des personnes enregistrées</h1>
  <table>
      <thead>
          <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Type de personne</th>
              <th>Sexe</th>
              <th>Date de naissance</th>
              <th>Photo</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach ($personnes as $personne) : ?>
              <tr id="personne-<?= $personne->id ?>">
                  <td id-personne="<?= $personne->id ?>"><?= $personne->nom ?></td>
                  <td id-personne="<?= $personne->id ?>"><?= $personne->prenom ?></td>
                  <td id-personne="<?= $personne->id ?>">Type de personne</td>
                  <td id-personne="<?= $personne->id ?>"><?= $personne->sexe ?></td>
                  <td id-personne="<?= $personne->id ?>"><?= $personne->datenaissance ?></td>
                  
                  <td id-personne="<?= $personne->id ?>" ><img src="<?php echo base_url('/public/photos/' . $personne->photo) ?>" width="100" height="100"></td>
                  
                  <td>
                      <a class="edit-btn" id-personne="<?= $personne->id ?>">Modifier</a>
                      <a class="supprimer-personne delete-btn" id-personne="<?= $personne->id ?>">Supprimer</a>
                  </td>
                 
              </tr>
          <?php endforeach; ?>
      </tbody>
  </table>
   

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        console.log(response);  // Pour le débogage
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

