<?php 

namespace App\Services;
use Illuminate\Support\Facades\Storage; 
use InterventionImage;

class ImageService{
    public static function upload($imageFile, $folderName){

        $fileName = uniqid(rand().'_');
        // extentionにて拡張子を取得
        $extension = $imageFile->extension();
    // ファイル名を取得
        $fileNameToStore = $fileName. '.' . $extension;
    // 画像を調整して変数に格納する
        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

        // dd($imageFile,$resizedImage);
        Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage );

        return $fileNameToStore;
    }
}
?>