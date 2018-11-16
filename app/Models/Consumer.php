<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consumers';
    public static $fields = ['name' , 'age' , 'city'];
}
