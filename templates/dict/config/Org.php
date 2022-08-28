<?php

return [
    'model'   => [
        'name'  => 'Org',
        'title' => 'Модель юридического лица',
        'table' => [
            'name'      => 'ns_org',
            'className' => 'NsOrg',
            'comment'   => 'Справочник юридических лиц',
            'fileDate'  => '20220628220000',
            'additionalFields' => "
            ['prop' => 'mps', 'label' => 'Материалы проверки'],",
            'additionalConfig' => "
        'hidden'     => ['mps'],
        'editHidden' => ['mps'],
        'formTables' => [
            [
                'prop'   => 'mps',
                'fields' => [
                    ['prop' => 'id', 'label' => 'Материалы проверки'],
                    ['prop' => 'algorithm.title', 'label' => 'Состав дела'],
                    ['prop' => 'created_at', 'label' => 'Дата', 'type' => 'date'],
                ],
                'actions' => [
                    ['event' => '_viewMP', 'icon' => 'view', 'type' => 'primary'],
                ],
            ],
        ],",
        ],
        'additionalMethods' => '
    public function getMPs(): BelongsToMany
    {
        return $this->belongsToMany(MP::class, \'ns_mp_org_bind\', \'mp_id\', \'org_id\');
    }',
    ],
    'catalog' => [
        'path'    => 'org',
        'summary' => [
            'list'   => 'Список юр. лиц',
            'get'    => 'Получить юр. лицо',
            'add'    => 'Создать юр. лицо',
            'edit'   => 'Редактировать юр. лицо',
            'delete' => 'Удалить юр. лицо',
        ],
        'additionalMethods' => '

    /**
     * @param OrgModel $item
     * @return string[]
     */
    protected function formatItem(Model $item)
    {
        $data              = $item->toArray();
        $data[\'mps\']       = $item->getMPs()->with(MP::RELATION_ALGORITHM)->get();

        return $data;
    }',
    ],
    'props'   => [
        [
            'migration' => [
                'name'     => 'title',
                'comment'  => 'Наименование',
                'type'     => 'AdapterInterface::PHINX_TYPE_STRING',
                'required' => true,
                'unique'   => false,
                'example'  => 'ООО "Компания 1"',
            ],
            'model'     => [
                'const_name' => 'TITLE',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'ИП Иванов',
                'rule'    => 'required|string|max:255',
            ],
        ],
        [
            'migration' => [
                'name'     => 'legal_form',
                'comment'  => 'Организационно-правовая форма',
                'type'     => 'AdapterInterface::PHINX_TYPE_INTEGER',
                'required' => false,
                'unique'   => false,
                'example'  => 'ООО',
            ],
            'model'     => [
                'const_name' => 'LEGAL_FORM',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'ИП',
                'rule'    => 'nullable|numeric|exists:ns_sp_legal_form',
            ],
        ],
        [
            'migration' => [
                'name'     => 'registration_address',
                'comment'  => 'Место регистрации',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => false,
                'unique'   => false,
                'example'  => 'г. Москва, ул. Ленина 1, оф. 10',
            ],
            'model'     => [
                'const_name' => 'REGISTRATION_ADDRESS',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'г. Москва, ул. Достоевского 2, оф. 20',
                'rule'    => 'nullable|string|max:255',
            ],
        ],
        [
            'migration' => [
                'name'     => 'legal_address',
                'comment'  => 'Юридический адрес',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => false,
                'unique'   => false,
                'example'  => 'г. Москва, ул. Пушкина 3, оф. 30',
            ],
            'model'     => [
                'const_name' => 'LEGAL_ADDRESS',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'г. Москва, ул. Чехова 4, оф. 40',
                'rule'    => 'nullable|string|max:255',
            ],
        ],
        [
            'migration' => [
                'name'     => 'inn',
                'comment'  => 'ИНН',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => true,
                'unique'   => true,
                'example'  => '7707089101',
            ],
            'model'     => [
                'const_name' => 'INN',
            ],
            'catalog'   => [
                'type'    => 'number',
                'example' => '770700010043',
                'rule'    => 'required|numeric|unique:ns_org,inn,{id}',//len: 10 or 12
            ],
        ],
        [
            'migration' => [
                'name'     => 'kpp',
                'comment'  => 'КПП',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => false,
                'unique'   => false,
                'example'  => '770731005',
            ],
            'model'     => [
                'const_name' => 'KPP',
            ],
            'catalog'   => [
                'type'    => 'number',
                'example' => '770700001',
                'rule'    => 'nullable|numeric',//size:9
            ],
        ],
        [
            'migration' => [
                'name'     => 'ogrn',
                'comment'  => 'ОГРН',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => false,
                'unique'   => false,
                'example'  => '1117746358608',
            ],
            'model'     => [
                'const_name' => 'OGRN',
            ],
            'catalog'   => [
                'type'    => 'number',
                'example' => '111774635873198',
                'rule'    => 'nullable|numeric',//min:13|max:15
            ],
        ],
        [
            'migration' => [
                'name'     => 'rs',
                'comment'  => 'Расчетный счет',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => false,
                'unique'   => false,
                'example'  => '40800643000000017300',
            ],
            'model'     => [
                'const_name' => 'RS',
            ],
            'catalog'   => [
                'type'    => 'number',
                'example' => '40800643000000084732',
                'rule'    => 'nullable|numeric',//size:20
            ],
        ],
        [
            'migration' => [
                'name'     => 'phone',
                'comment'  => 'Телефон',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => false,
                'unique'   => false,
                'example'  => '+7 916 123 45 67',
            ],
            'model'     => [
                'const_name' => 'PHONE',
            ],
            'catalog'   => [
                'type'    => 'number',
                'example' => '+7 916 765 43 21',
                'rule'    => 'nullable|string|max:255',
            ],
        ],
        [
            'migration' => [
                'name'       => 'date_reg',
                'comment'    => 'Дата регистрации',
                'type'       => 'AdapterInterface::PHINX_TYPE_DATE',
                'front_type' => 'date',
                'required'   => false,
                'unique'     => false,
                'example'    => '2020-02-03',
            ],
            'model'     => [
                'const_name' => 'DATE_REG',
                'cast'       => 'date',
            ],
            'catalog'   => [
                'type'    => 'date',
                'example' => '2019-02-03',
                'rule'    => 'nullable|date',
            ],
        ],
        [
            'migration' => [
                'name'       => 'date_close',
                'comment'    => 'Дата ликвидации',
                'type'       => 'AdapterInterface::PHINX_TYPE_DATE',
                'front_type' => 'date',
                'required'   => false,
                'unique'     => false,
                'example'    => '2021-09-16',
            ],
            'model'     => [
                'const_name' => 'DATE_CLOSE',
                'cast'       => 'date',
            ],
            'catalog'   => [
                'type'    => 'date',
                'example' => '2020-10-26',
                'rule'    => 'nullable|date',
            ],
        ],
    ],
];
