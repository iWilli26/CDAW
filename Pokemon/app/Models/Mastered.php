<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Mastered extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mastered';
    public $timestamps = false;
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';
    protected $fillable = [
        'user_id',
        'energy_id',
    ];
}