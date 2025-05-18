<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyTree extends Model
{
    use HasFactory;

    protected $table = 'trees';

    protected $fillable = ['tree_name', 'description', 'created_by'];

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'tree_id', 'id');
    }

}
