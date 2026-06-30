<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'level', 'color'];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Priority $priority) {
            if (empty($priority->slug)) {
                $priority->slug = Str::slug($priority->name);
            }
        });
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
