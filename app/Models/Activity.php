<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * Class Activity
 *
 * @property  integer id
 * @property integer group_id
 * @property string name
 * @property string status
 * @property string place
 * @property Carbon start_time
 * @property Carbon end_time
 * @property string description
 *
 * @property-read  Group group
 */
class Activity extends Model
{
    use HasFactory;

    CONST PROCCESSING = 'processing';
    CONST FENCE = 'fence';

    protected $fillable = [
        'group_id',
        'name',
        'place',
        'description',
        'start_time',
        'end_time',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
