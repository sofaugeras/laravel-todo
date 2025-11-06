<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todos extends Model
{
    use SoftDeletes;

    protected $fillable = ['texte', 'termine', 'important'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categories::class);
    }

    // Un todo appartient à une et une seule liste
    public function listes(): BelongsTo
    {
        return $this->belongsTo(Listes::class)->withDefault();
    }

    // Un todo appartient à un et un seul utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
