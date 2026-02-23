<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    // Константы с данными фотографий
    public const PHOTOS = [
        [
            'src' => 'images/1.jpg',
            'title' => 'Роберт Де Ниро',
            'hover_text' => 'Легенда американского кино, 70-е годы'
        ],
        [
            'src' => 'images/2.jpg',
            'title' => 'Мэрил Стрип',
            'hover_text' => 'Оскароносная актриса, известна по драмам'
        ],
        [
            'src' => 'images/3.jpg',
            'title' => 'Леонардо ДиКаприо',
            'hover_text' => 'Лауреат премий, известен фильмами Леонардо'
        ],
        [
            'src' => 'images/4.jpg',
            'title' => 'Том Хэнкс',
            'hover_text' => 'Том Хэнкс: любимец публики и актёр мирового уровня'
        ],
        [
            'src' => 'images/5.jpg',
            'title' => 'Натали Портман',
            'hover_text' => 'Натали Портман: актриса и активистка'
        ],
        [
            'src' => 'images/6.jpg',
            'title' => 'Аль Пачино',
            'hover_text' => 'Аль Пачино — мастер перевоплощений'
        ],
        [
            'src' => 'images/7.jpg',
            'title' => 'Хоакин Феникс',
            'hover_text' => 'Хоакин Феникс: драматические роли'
        ],
        [
            'src' => 'images/8.jpg',
            'title' => 'Скарлетт Йохансон',
            'hover_text' => 'Скарлетт Йохансон: звезда Marvel'
        ],
        [
            'src' => 'images/9.jpg',
            'title' => 'Морган Фримен',
            'hover_text' => 'Морган Фримен: неподражаемый голос и харизма'
        ],
        [
            'src' => 'images/10.jpg',
            'title' => 'Брэд Питт',
            'hover_text' => 'Брэд Питт: культовый актёр Голливуда'
        ],
        [
            'src' => 'images/11.jpg',
            'title' => 'Франсуа Клюзе',
            'hover_text' => 'Франсуа Клюзе: французский киноактер'
        ],
        [
            'src' => 'images/12.jpg',
            'title' => 'Омар Си',
            'hover_text' => 'Омар Си: французский актёр-комик'
        ],
        [
            'src' => 'images/13.jpg',
            'title' => 'Одри Флёро',
            'hover_text' => 'Одри Флёро: французская актриса'
        ],
        [
            'src' => 'images/14.jpg',
            'title' => 'Меган Фокс',
            'hover_text' => 'Меган Фокс: известная по боевикам'
        ],
        [
            'src' => 'images/15.jpg',
            'title' => 'Марго Робби',
            'hover_text' => 'Марго Робби: актриса и продюсер'
        ]
    ];

    public static function getAllPhotos(): array
    {
        return self::PHOTOS;
    }

    public static function getPhotoByIndex(int $index): ?array
    {
        return self::PHOTOS[$index] ?? null;
    }

    public static function getCount(): int
    {
        return count(self::PHOTOS);
    }
}
