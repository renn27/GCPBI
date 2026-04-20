<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['import_id', 'wilayah_id', 'petugas_id', 'assignment_status_alias', 'jumlah_dokumen'];
    public function import()  { return $this->belongsTo(Import::class); }
    public function wilayah() { return $this->belongsTo(Wilayah::class); }
    public function petugas() { return $this->belongsTo(Petugas::class); }
}
