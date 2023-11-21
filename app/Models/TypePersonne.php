<?php

namespace App\Models;

use CodeIgniter\Model;

class TypePersonne extends Model
{
    protected $table            = 'typepersonne';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['libelle'];
    

     // Relation avec le modèle Personne
     protected $returnType = 'object';
     protected $useSoftDeletes = false;
     protected $useTimestamps = false;
     protected $skipValidation = false;
 
     protected $hasMany = [
         'personnes' => [
             'model' => 'Personne',
             'foreign_key' => 'idtypepersonne',
         ],
     ];


     public function getLibelle()
     {
    
         $libelles = [
             1 => 'etudiant',
             2 => 'enseignant',
         ];
 
         return $libelles[$this->idtypepersonne] ?? 'Inconnu';
     }
}
