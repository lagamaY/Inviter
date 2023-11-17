<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <!-- View: liste_personnes_enregistrees.php --> 
 

  <a href=" " class="btn-add">Enregistrer une personne</a>


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
                  <td><?= $personne->nom ?></td>
                  <td><?= $personne->prenom ?></td>
                  <td><?= $personne->photo ?></td>
                  <td><?= $personne->sexe ?></td>
                  <td><?= $personne->datenaissance ?></td>
                  
                  <td><img src="<?php echo base_url('/testlagama/public/photos/' . $personne->photo) ?>" width="100" height="100"></td>
                  
                  <td>
                      <a class="supprimer-personne delete-btn" id-personne="<?= $personne->id ?>">Supprimer</a>
                  </td>
              </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.delete-btn').on('click', function () {
                var idPersonne = $(this).attr('id-personne');
                
                console.log(idPersonne);  // Pour le débogage

                if (confirm("Êtes-vous sûr de vouloir supprimer cette personne?")) {
                    $.ajax({
                        url: '<?php echo base_url('/testlagama/supprimer-personne'); ?>',
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



</body>
</html>

