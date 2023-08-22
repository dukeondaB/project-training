<?php

namespace App\Helper;

class FileHelper
{
    public static function uploadImage($request, $data, $fieldName, $folder)
    {
        if ($request->hasFile($fieldName)) {
            $image = $request->file($fieldName);
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/' . $folder, $imageName);
            $data[$fieldName] = $imageName;
        }
        return $data;
    }

}
