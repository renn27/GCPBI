<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = [
        'level_1_code','level_1_name','level_2_code','level_2_name',
        'level_3_code','level_3_name','level_4_code','level_4_name'
    ];
    public function assignments() { return $this->hasMany(Assignment::class); }
}
