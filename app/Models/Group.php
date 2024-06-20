<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Group
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection<Activity> $activities
 * @property-read Collection<User> $users
 */
class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
