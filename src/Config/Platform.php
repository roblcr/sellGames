<?php

namespace App\Config;

enum Platform: string
{
    case Playstation = 'Playstation';
    case Xbox  = 'Xbox';
    case Nintendo = 'Nintendo';
    case PC = 'PC';
}
