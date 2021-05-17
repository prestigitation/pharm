<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $news = [
        [
            'title' => 'Открытие компании Pharm',
            'content'=> 'С радостью сообщаем вам, что компания Pharm начинает свою работу. Компания специализируется на продажах медицинских продуктов',
        ],
        [
            'title' => 'Открытие филиала в г.Рыбница',
            'content' => 'Здравствуйте! Рады вообщить вам, что компания открывает филиал компании Pharm в городе Рыбница, по адресу : ул.Пушкина д.Колотушкина'
        ],
        [
            'title' => 'Скидки!',
            'content' => 'С 13 по 15 мая на все товары объявлена скидка 10%! '
        ]
    ];
    foreach($news as $article) {
        \App\Models\News::create([
            'title'=> $article['title'],
            'content' => $article['content'],
        ]);
    }
    }
}
