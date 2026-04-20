<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = ['filename', 'original_name', 'imported_at', 'total_rows', 'status', 'notes'];
    protected function casts(): array {
        return ['imported_at' => 'datetime'];
    }
    public function assignments() { return $this->hasMany(Assignment::class); }
}
