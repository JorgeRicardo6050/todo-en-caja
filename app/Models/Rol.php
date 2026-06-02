<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $primaryKy = 'rol_id';

    public $timestamps = false;

    protected $filable = [
        'rol_id',
        'rol',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'rol', 'rol_id');
    }
}