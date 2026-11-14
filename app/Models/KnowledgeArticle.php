<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeArticle extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['embedding' => 'array'];
    }
}
