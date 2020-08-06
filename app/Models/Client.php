<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'lastname'];

    /**
     * The attributes that should be hidden from select.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Client has many emails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany;
     */
    public function emails()
    {
        return $this->hasMany('App\Models\ClientEmail');
    }

    /**
     * Client has many phone numbers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany;
     */
    public function phoneNumbers()
    {
        return $this->hasMany('App\Models\ClientPhone');
    }
}
