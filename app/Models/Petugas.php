<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $fillable = ['email', 'nama'];
    public function assignments() { return $this->hasMany(Assignment::class); }
}
