<?php

namespace App\Containers\Blog\Seeds;

use App\Ship\Seeds\AbstractSeed;

class Materials_26012024201942_seed extends AbstractSeed
{
    public function create()
    {
        $table = "materials";

        $fieldsArray = [
            [
                "slug" => "slug_1",
                "title" => "Заголовок 1",
                "text" => " Задача организации, в особенности же рамки и место обучения кадров позволяет выполнять важные задания по разработке дальнейших направлений развития. Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности способствует подготовки и реализации форм развития. С другой стороны консультация с широким активом в значительной степени обуславливает создание соответствующий условий активизации.

                Идейные соображения высшего порядка, а также новая модель организационной деятельности позволяет оценить значение соответствующий условий активизации. Не следует, однако забывать, что новая модель организационной деятельности в значительной степени обуславливает создание позиций, занимаемых участниками в отношении поставленных задач. ",
                "status" => 1,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "slug" => "slug_2",
                "title" => "Заголовок 2",
                "text" => " Задача организации, в особенности же рамки и место обучения кадров позволяет выполнять важные задания по разработке дальнейших направлений развития. Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности способствует подготовки и реализации форм развития. С другой стороны консультация с широким активом в значительной степени обуславливает создание соответствующий условий активизации.

                Идейные соображения высшего порядка, а также новая модель организационной деятельности позволяет оценить значение соответствующий условий активизации. Не следует, однако забывать, что новая модель организационной деятельности в значительной степени обуславливает создание позиций, занимаемых участниками в отношении поставленных задач. ",
                "status" => 1,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($fieldsArray as $fields) {
            $this->execute($table, $fields);
        }
    }
}