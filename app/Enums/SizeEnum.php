<?php

namespace App\Enums;

enum SizeEnum: int
{
    case Size1  = 1024; // 1mb
    case Size2  = 2048; // 2mb
    case Size5  = 5120; // 5mb
    case Size10 = 10240; // 10mb
    case Size15 = 15360; // 15mb
    case Size20 = 20480; // 20mb
    case Size25 = 25000; // 25mb
    case Size30 = 30000; // 30mb
}
