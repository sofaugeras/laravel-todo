<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Todos extends Model

{
    use SoftDeletes;

    protected $fillable = ['texte', 'termine', 'important'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categories::class);
    }
}
