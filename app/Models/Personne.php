<?php

namespace App\Models;

use CodeIgniter\Model;

class Personne extends Model
{
    protected $table            = 'personne';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['nom', 'prenom', 'sexe', 'photo', 'datenaissance', 'idtypepersonne'];

   
   // Relation avec le modèle TypePersonne
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $skipValidation = false;

    protected $belongsTo = [
        'type_personne' => [
            'model' => 'TypePersonne',
            'foreign_key' => 'idtypepersonne',
        ],
    ];
}
