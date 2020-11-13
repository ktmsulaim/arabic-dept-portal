<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Photo extends Model
{
    protected $fillable = ['student_id', 'filename', 'status'];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function scopeProfile($query)
    {
        return $query->where('status', 1);
    }

    public static function createFromBase64($filename, $dir = null)
    {
        $image_64 = $filename; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = Str::random(10) . '.' . $extension;

        if (!$dir) {
            $dir = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        }

        file_put_contents($dir . $imageName, base64_decode($image));

        return $imageName;
    }

    public function deleteWithFile($dir = null)
    {
        $ds = DIRECTORY_SEPARATOR;

        if (empty($dir)) {
            $dir = public_path() . $ds . 'uploads' . $ds . 'images' . $ds;
        }

        if (file_exists($dir . $this->filename)) {
            unlink($dir . $this->filename);
        }

        $this->delete();
    }
}
