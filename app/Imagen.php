<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Imagen extends Model
{
    protected $table = "imagenes";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deleteWhitImg()
    {
        Storage::delete('public/'.$this->url);
        return  $this->delete();
    }
}
