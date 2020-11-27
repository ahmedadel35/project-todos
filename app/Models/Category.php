<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function my_todos(): HasMany
    {
        return $this->todos()->where('user_id', auth()->id());
    }
}
