<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color', 'order_position', 'is_final'];

    protected function casts(): array
    {
        return ['is_final' => 'boolean'];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Status $status) {
            if (empty($status->slug)) {
                $status->slug = Str::slug($status->name);
            }
        });
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
