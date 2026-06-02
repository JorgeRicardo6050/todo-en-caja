<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'cte_id';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'apepat',
        'apemat',
        'correo',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apepat . ' ' . $this->apemat);
    }
}