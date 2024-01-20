<?php

namespace App\Enums;


enum ImageTypeEnum: string
{
    case ImageMime       = 'png,jpg,jpeg,gif,webp';
    case ImageMimeAccept = '.png,.jpg,.jpeg,.gif,.webp';
}
