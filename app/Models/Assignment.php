<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //use HasFactory;
    use UsesUuid;

    protected $table = 'assignments';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'registry',
        'assignment',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
