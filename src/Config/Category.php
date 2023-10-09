<?php

namespace App\Config;

enum Category: string
{
    case FPS = 'FPS';
    case TPS  = 'TPS';
    case RTS = 'RTS';
    case RPG = 'RPG';
    case MMORPG = 'MMORPG';
    case MOBA = 'MOBA';
    case Sandbox = 'Bacs a sable';
    case Combat = 'Combat';
    case Simulation = 'Simulation';
    case Platform = 'Plateforme';
    case BattleRoyal = 'Battle Royal';
    case Action = 'Action';
    case Aventure = 'Aventure';
    case Puzzle = 'Puzzle';
    case Reflexion = 'Reflexion';
    case Survival = 'Survival';
    case Horror = 'Horror';
    case RogueLike = 'Rogue Like';
    case PartyGame = 'Party Game';
}
