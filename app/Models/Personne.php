<?php

namespace App\Models;

use CodeIgniter\Model;
use \Tatter\Relations\Traits\ModelTrait;
use \Tatter\Relations\Traits\EntityTrait;

class Personne extends Model
{
    protected $table            = 'personne';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['nom', 'prenom', 'sexe', 'photo', 'datenaissance', 'idtypepersonne'];
    protected $with = 'TypePersonne';

   
   
   // Relation avec le modèle TypePersonne
    protected $returnType = 'object';
    
    
    // Dates
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    protected $belongsTo = [
        'typePersonnes' => [
            'model' => 'TypePersonne',
            'foreign_key' => 'idtypepersonne',
        ],
    ];


    // Validation des champs
    protected $validationRules = [
        'nom'             => 'required',
        'prenom'          => 'required',
        'sexe'            => 'required',
        'datenaissance'   => 'required',
        'idtypepersonne'  => 'required',
        'photo'           => 'required',
    ];


    
}
