<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    /** @use HasFactory<\Database\Factories\FamilyMemberFactory> */

    use HasFactory;

    protected $table = 'family_members';

    protected $fillable = [
        'name',
        'birth_date',
        'gender',
        'address',
        'tree_id',
        'parent_id',
        'photo',
        'urutan',
        // [partner]
        'partner_name', 
        'partner_birth_date', 
        'partner_gender', 
        'partner_address', 
        'partner_photo', 
    ];

    public function tree()
    {
        return $this->belongsTo(FamilyTree::class);
    }

    public function parent()
    {
        return $this->belongsTo(FamilyMember::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FamilyMember::class, 'parent_id');
    }
}
