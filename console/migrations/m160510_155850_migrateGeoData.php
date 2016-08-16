<?php

use common\components\migration\Migration;

class m160510_155850_migrateGeoData extends Migration
{
    public function up()
    {
        $regions = [
            1  => 'Центр',
            2  => 'Юг',
            3  => 'Северо-Запад',
            4  => 'Дальний Восток',
            5  => 'Сибирь',
            6  => 'Урал',
            7  => 'Приволжье',
            8  => 'Северный Кавказ',
            10 => 'Крым'
        ];

        foreach ($regions as $id => $name) {
            $this->insert('geo_region', [
                'id'          => $id,
                'name'        => $name,
                'date_create' => date('Y-m-d H:i:s')
            ]);
        }

        $areas = [
            ['name' => 'Абхазия', 'form' => 'Респ', 'federal_id' => '2'],
            ['name' => 'Адыгея', 'form' => 'Респ', 'federal_id' => '2'],
            ['name' => 'Азербайджан', 'form' => 'Респ', 'federal_id' => '2'],
            ['name' => 'Алтай', 'form' => 'Респ', 'federal_id' => '5'],
            ['name' => 'Алтайский', 'form' => 'край', 'federal_id' => '5'],
            ['name' => 'Амурская', 'form' => 'обл', 'federal_id' => '4'],
            ['name' => 'Архангельская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Астраханская', 'form' => 'обл', 'federal_id' => '2'],
            ['name' => 'Байконур', 'form' => 'г.', 'federal_id' => '6'],
            ['name' => 'Башкортостан', 'form' => 'Респ', 'federal_id' => '7'],
            ['name' => 'Белгородская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Брянская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Бурятия', 'form' => 'Респ', 'federal_id' => '5'],
            ['name' => 'Владимирская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Волгоградская', 'form' => 'обл', 'federal_id' => '2'],
            ['name' => 'Вологодская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Воронежская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Дагестан', 'form' => 'Респ', 'federal_id' => '8'],
            ['name' => 'Еврейская', 'form' => 'Аобл', 'federal_id' => '4'],
            ['name' => 'Забайкальский', 'form' => 'край', 'federal_id' => '5'],
            ['name' => 'Ивановская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Ингушетия', 'form' => 'Респ', 'federal_id' => '8'],
            ['name' => 'Иркутская', 'form' => 'обл', 'federal_id' => '5'],
            ['name' => 'Кабардино-Балкарская', 'form' => 'Респ', 'federal_id' => '8'],
            ['name' => 'Калининградская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Калмыкия', 'form' => 'Респ', 'federal_id' => '2'],
            ['name' => 'Калужская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Камчатский', 'form' => 'край', 'federal_id' => '4'],
            ['name' => 'Карачаево-Черкесская', 'form' => 'Респ', 'federal_id' => '8'],
            ['name' => 'Карелия', 'form' => 'Респ', 'federal_id' => '3'],
            ['name' => 'Кемеровская', 'form' => 'обл', 'federal_id' => '5'],
            ['name' => 'Кировская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Коми', 'form' => 'Респ', 'federal_id' => '3'],
            ['name' => 'Костромская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Краснодарский', 'form' => 'край', 'federal_id' => '2'],
            ['name' => 'Красноярский', 'form' => 'край', 'federal_id' => '5'],
            ['name' => 'Крым', 'form' => 'Респ', 'federal_id' => '10'],
            ['name' => 'Курганская', 'form' => 'обл', 'federal_id' => '6'],
            ['name' => 'Курская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Ленинградская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Липецкая', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Магаданская', 'form' => 'обл', 'federal_id' => '4'],
            ['name' => 'Марий Эл', 'form' => 'Респ', 'federal_id' => '7'],
            ['name' => 'Мордовия', 'form' => 'Респ', 'federal_id' => '7'],
            ['name' => 'Москва', 'form' => 'г.', 'federal_id' => '1'],
            ['name' => 'Московская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Мурманская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Ненецкий', 'form' => 'АО', 'federal_id' => '3'],
            ['name' => 'Нижегородская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Новгородская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Новосибирская', 'form' => 'обл', 'federal_id' => '5'],
            ['name' => 'Омская', 'form' => 'обл', 'federal_id' => '5'],
            ['name' => 'Оренбургская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Орловская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Пензенская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Пермский', 'form' => 'край', 'federal_id' => '7'],
            ['name' => 'Приморский', 'form' => 'край', 'federal_id' => '4'],
            ['name' => 'Псковская', 'form' => 'обл', 'federal_id' => '3'],
            ['name' => 'Ростовская', 'form' => 'обл', 'federal_id' => '2'],
            ['name' => 'Рязанская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Самарская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Санкт-Петербург', 'form' => 'г.', 'federal_id' => '3'],
            ['name' => 'Саратовская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Саха (Якутия)', 'form' => 'Респ', 'federal_id' => '4'],
            ['name' => 'Сахалинская', 'form' => 'обл', 'federal_id' => '4'],
            ['name' => 'Свердловская', 'form' => 'обл', 'federal_id' => '6'],
            ['name' => 'Севастополь', 'form' => 'г.', 'federal_id' => '10'],
            ['name' => 'Северная Осетия - Алания', 'form' => 'Респ', 'federal_id' => '8'],
            ['name' => 'Смоленская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Ставропольский', 'form' => 'край', 'federal_id' => '8'],
            ['name' => 'Тамбовская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Татарстан', 'form' => 'Респ', 'federal_id' => '7'],
            ['name' => 'Тверская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Томская', 'form' => 'обл', 'federal_id' => '5'],
            ['name' => 'Тульская', 'form' => 'обл', 'federal_id' => '1'],
            ['name' => 'Тыва', 'form' => 'Респ', 'federal_id' => '5'],
            ['name' => 'Тюменская', 'form' => 'обл', 'federal_id' => '6'],
            ['name' => 'Удмуртская', 'form' => 'Респ', 'federal_id' => '7'],
            ['name' => 'Ульяновская', 'form' => 'обл', 'federal_id' => '7'],
            ['name' => 'Хабаровский', 'form' => 'край', 'federal_id' => '4'],
            ['name' => 'Хакасия', 'form' => 'Респ', 'federal_id' => '5'],
            ['name' => 'Ханты-Мансийский', 'form' => 'АО', 'federal_id' => '6'],
            ['name' => 'Челябинская', 'form' => 'обл', 'federal_id' => '6'],
            ['name' => 'Чеченская', 'form' => 'Респ', 'federal_id' => '8'],
            ['name' => 'Чувашская', 'form' => 'Респ', 'federal_id' => '7'],
            ['name' => 'Чукотский', 'form' => 'АО', 'federal_id' => '4'],
            ['name' => 'Ямало-Ненецкий', 'form' => 'АО', 'federal_id' => '6'],
            ['name' => 'Ярославская', 'form' => 'обл', 'federal_id' => '1']
        ];

        foreach ($areas as $area) {
            $areaType = $area['form'];
            $type = 1;
            if ($areaType == 'край') {
                $type = 3;
            } elseif ($areaType == 'обл') {
                $type = 2;
            } elseif ($areaType == 'г.' || $areaType == 'г') {
                $type = 4;
            } elseif ($areaType == 'Аобл') {
                $type = 7;
            } elseif ($areaType == 'АО') {
                $type = 5;
            } elseif ($areaType == 'АР') {
                $type = 6;
            }

            $this->insert('geo_area', [
                'name'        => $area['name'],
                'type'        => $type,
                'region_id'   => $area['federal_id'],
                'date_create' => date('Y-m-d H:i:s')
            ]);
        }

        $cities = [];
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->truncateTable('geo_region');
        $this->truncateTable('geo_area');
        $this->truncateTable('geo_city');
        $this->execute('SET foreign_key_checks = 1');
    }
}
