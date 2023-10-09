<?php

namespace App\Config;

enum State: string
{
    case Neuf   = 'neuf';
    case Bon_etat  = 'bon_etat';
    case Usage = 'usagé';
    case Defaillant = 'défaillant';
}
