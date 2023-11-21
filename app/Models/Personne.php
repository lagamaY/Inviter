<?php

namespace App\Models;

use CodeIgniter\Model;
use \Tatter\Relations\Traits\ModelTrait;
use \Tatter\Relations\Traits\EntityTrait;

class Personne extends Model
{
    // ...

    protected $table = 'personne';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'sexe', 'photo', 'datenaissance', 'idtypepersonne'];
    protected $returnType = 'object';

    protected $with = ['typePersonnes']; // Charger la relation typePersonnes

    protected $belongsTo = [
        'typePersonnes' => [
            'model' => 'App\Models\TypePersonne', // Utilisez le chemin complet du modèle
            'foreign_key' => 'idtypepersonne',
        ],
    ];

  
    // ...

    public function getPersonnesWithTypePersonne()
    {
        $this->join('typepersonne', 'personne.idtypepersonne = typepersonne.id');
        return $this->findAll();
    }
}

