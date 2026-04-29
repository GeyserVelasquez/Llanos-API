<?php

namespace App\Enums;

enum AnimalCategory: string
{
    case BULL = 'bull';
    case STEER = 'steer';
    case MALE_YEARLING = 'male_yearling';
    case MALE_CALF = 'bull_calf';

    case COW = 'cow';
    case HEIFER = 'heifer';
    case FEMALE_YEARLING = 'female_yearling';
    case FEMALE_CALF = 'heifer_calf';

    public function isMale(): bool
    {
        return match($this) {
            self::BULL, self::STEER,self::MALE_YEARLING, self::MALE_CALF => true,
            default => false,
        };
    }
    public function isFemale(): bool
    {
        return match($this) {
            self::COW, self::HEIFER, self::FEMALE_YEARLING, self::FEMALE_CALF => true,
            default => false,
        };
    }

    public function canGiveBirth(): bool
    {
        return match($this) {
            self::COW, self::HEIFER => true,
            default => false,
        };
    }
    public function canMount(): bool
    {
        return match($this) {
            self::BULL, self::STEER => true,
            default => false,
        };
    }
}
