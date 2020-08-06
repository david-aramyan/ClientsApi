<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientEmail extends Model
{
    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table = "emails";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'client_id'];

    /**
     * The attributes that should be hidden from select.
     *
     * @var array
     */
    protected $hidden = ['client_id','created_at', 'updated_at'];
}
