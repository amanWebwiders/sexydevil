<?php

namespace App\Traits;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Laravel\Facades\Image;
trait ImageUploadTrait {

    /**

     * Upload an image to the 'public/images' directory.

     *

     * @param \Illuminate\Http\UploadedFile $file

     * @return string Uploaded file name or error message.

     */

    public function uploadImage($image, $path)

    {

        try {
            $name = time() . rand(99,1000).'.' . $image->getClientOriginalExtension();
            if($path == "user_videos") {
                $imageData = $image->storeAs($path, $name, 'public');                
            } else {
                $img = Image::read($image->getRealPath());
                $watermark = Image::read(public_path('watermark.png'));
                $watermark->scale(width: $img->width() * 0.2);
                $img->place($watermark, 'bottom-right', 10, 10);
                $imageData = $path.'/'. $name;

                Storage::disk('public')->put($imageData, (string) $img->encode());
                /* $img = Image::make($image->getRealPath());
                $watermark = public_path('watermark.png');
                $img->insert($watermark, 'bottom-right', 10, 10);
                $imageData = $img->storeAs($path, $name, 'public');                
                $img->save($path); */
            }
            return $imageData;
            // $path = $file->store('images', 'public');
            // if (!$path) {
            //     throw new Exception("Image upload failed.");
            // }
            // return basename($path);

        } catch (Exception $e) {

            Log::error(__CLASS__ . "::" . __FUNCTION__ . " - " . $e->getMessage());

            return "Error: " . $e->getMessage();

        }

    }


        public function uploadWatermarkImage($image, $path) {

        try {
            $name = time() . rand(99,1000).'.' . $image->getClientOriginalExtension();
            $original = time() . rand(1001,9999).'.' . $image->getClientOriginalExtension();
            $watermarked = "";
            if($path == "user_videos") {
                $imageData = $image->storeAs($path, $original, 'public');  
            } else {
                $img = Image::read($image->getRealPath());
                $watermark = Image::read(public_path('watermark.png'));
                $watermark->scale(width: $img->width() * 1);
                $img->place($watermark, 'center');
                $imageData = $path.'/'. $name;
                $watermarked = $imageData;
                Storage::disk('public')->put($imageData, (string) $img->encode());
                $orignal = $image->storeAs($path, $original, 'public');
            }
            return ["orignal" => $orignal, "watermarked" => $watermarked];
        } catch (Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . " - " . $e->getMessage());
            return ["orignal" => false, "watermarked" => false];
        }

    }



    /**

     * Delete an image from storage.

     *

     * @param string $filename

     * @return bool True if deleted, false otherwise.

     */

    public function deleteImage($filename): bool

    {

        try {

            $path = "images/{$filename}";



            if (Storage::disk('public')->exists($path)) {

                return Storage::disk('public')->delete($path);

            }



            return false;

        } catch (Exception $e) {

            Log::error(__CLASS__ . "::" . __FUNCTION__ . " - " . $e->getMessage());

            return false;

        }

    }



    /**

     * Replace an existing image with a new one.

     *

     * @param \Illuminate\Http\UploadedFile $file

     * @param string|null $oldFilename

     * @return string Uploaded file name or error message.

     */

    public function updateImage($file, ?string $oldFilename): string

    {

        try {

            if ($oldFilename) {

                $this->deleteImage($oldFilename);

            }



            return $this->uploadImage($file);

        } catch (Exception $e) {

            Log::error(__CLASS__ . "::" . __FUNCTION__ . " - " . $e->getMessage());

            return "Error: " . $e->getMessage();

        }

    }

}

