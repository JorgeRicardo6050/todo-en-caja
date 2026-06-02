<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $primaryKey = 'numempleado';

    public $timestamps = false;

    protected $fillable = [
        'numempleado',
        'nombre',
        'apepat',
        'apemat',
        'correo',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
    ];

    public function rolEmpleado()
    {
        return $this->belongsTo(Rol::class, 'rol', 'rol_id');
    }

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apepat . ' ' . $this->apemat);
    }
}