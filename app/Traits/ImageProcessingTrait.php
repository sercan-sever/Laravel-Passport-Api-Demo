<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Intervention\Image\ImageManager;


trait ImageProcessingTrait
{

    /**
     *
     * @return array<string, string>
     */
    private array $result = [
        'image' => "",
        'type' => "",
    ];

    /**
     * @param UploadedFile|null $file
     * @param string|null $path
     * @param int|null $width
     * @param int|null $height
     *
     * @return array
     */
    public function imageUpload(?UploadedFile $file = null, ?string $path = "files", ?int $width = 400, ?int $height = 400): array
    {
        try {
            $width = is_null($width) ? 400 : $width;
            $height = is_null($height) ? 400 : $height;
            $path = is_null($path) ? 'files' : $path;

            if (!empty($file)) {

                $fileInfo = $this->getFileInfo(file: $file);

                $img = ImageManager::imagick()->read($file);

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas($width, $height);

                if (!File::exists(public_path('images/' . $path))) {
                    File::makeDirectory(public_path('images/' . $path));
                }

                $folder = $img->save(path: public_path('images/' . $path . '/' . $fileInfo['file']));

                if (!empty($folder)) {
                    $this->result['image'] = $fileInfo['file'];
                    $this->result['type'] = $fileInfo['type'];
                }

                return $this->result;
            }

            return $this->result;
        } catch (\Exception $exception) {
            Log::error('ImageProcessingTrait ( imageUpload )', [$exception->getMessage()]);

            return $this->result;
        }
    }


    /**
     *
     * @param string|null $image
     * @param string|null $path
     *
     * @return bool
     */
    private function deleteImage(?string $image, ?string $path = 'files'): bool
    {

        try {
            if (file_exists('images/' . $path . '/' . $image)) {

                @unlink(public_path('images/' . $path . '/' . $image));

                return true;
            }

            return false;
        } catch (\Exception $exception) {
            Log::error('ImageProcessingTrait ( deleteImage )', [$exception->getMessage()]);

            return false;
        }
    }


    /**
     *
     * @param UploadedFile|null $file
     *
     * @return array<string, string>
     */
    private function getFileInfo(?UploadedFile $file): array
    {
        if (!is_null($file)) {
            $this->data_['name'] = $file?->getClientOriginalName();
            $this->data_['type'] = $file?->getClientOriginalExtension();
            $this->data_['file'] = str($this->data_['name'])->slug() . '-' . uniqid() . '.' . $this->data_['type'];

            return $this->data_;
        }

        return $this->data_;
    }
}
