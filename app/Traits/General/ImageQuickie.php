<?php

namespace App\Traits\General;

use Illuminate\Support\Str;

trait ImageQuickie{

    public function uploadImage($image, $storePath=null, $maxSize=null, $old=null) // Taking input image as parameter
    {
        $image_name = Str::random(20);
        $extension = strtolower($image->getClientOriginalExtension()); // You can use also getClientOriginalName()

        $allowedfileExtension = ['jpg', 'png', 'bmp', 'jpeg', 'gif'];

        $check = in_array(strtolower($extension), $allowedfileExtension);
        if(!$check){
            return [false, 'Image format not supported'];
        }

        if(!empty($maxSize)){
            $size = $image->getSize();
            if ($size > $maxSize) {
                return [false, 'This passport is too large. Compress and try again'];
            }
        }

        $image_full_name = $image_name.'.'.$extension;
        $upload_path = 'uploads/images';
        if(!empty($storePath)){
            $upload_path = 'uploads/'.$storePath;    //Creating Sub directory in Public folder to put image
        }


        $image->move(public_path($upload_path) ,$image_full_name);
//        $image->storeAs($upload_path, $image_full_name, 'public'); //alternative code

        //try to delete old if not null
        if(!empty($old)){
            if(file_exists($old)){
                try{
                    unlink($old);
                }catch (\Exception $e){

                }
            }
        }

        $image_url = $upload_path."/".$image_full_name;


        return [true, $image_url]; //
    }
}