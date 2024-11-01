<?php

namespace admin\enum;


enum PostStatus: int
{   
    case EXAMINATION = 0;
    case BRAND_NEW = 10;
    case PUBLISHED = 20;
    case REJECTED = 30;

    public function label(): string
    {
        return match($this) {
            self::EXAMINATION => 'На проверке',
            self::BRAND_NEW => 'Новый',
            self::PUBLISHED => 'Опубликован',
            self::REJECTED => 'Отклонен',
        };
    }

    // public static function getAllStatuses(): array
    // {
    //     return array_map(fn($status) => $status->value, self::cases());
    // }
    public static function getAllStatuses(): array
    {
        return array_map(fn($status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ], self::cases());
    }

}