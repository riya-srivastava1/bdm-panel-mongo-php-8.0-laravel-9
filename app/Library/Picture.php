<?php
namespace App\Library;
use App\Library\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class Picture{
    
    /**
     * @method upload file
     * @param filename, foldername
     * @return image path
     */
    public function uploadfile($fileName,$folderName)
    {
        $file = $fileName->extension();
        $filename = $this->mediumSlug().'.'.$file;
        $path = "assets/".$folderName.'/'.$filename;
        $fileName->move("assets/".$folderName.'/',$filename);
        return $path;

    }

    /**
     * @method create mediun range slug
     * @param 
     * @return slug
     */
    public function mediumSlug(){
        return Str::random(40);
    }
   
}
?>