<?php

return [
    'model'   => [
        'name'  => 'LegalForm',
        'title' => 'Модель организационно-правовых форм',
        'table' => [
            'name'      => 'ns_sp_legal_form',
            'className' => 'NsSpLegalForm',
            'comment'   => 'Справочник организационно-правовых форм',
            'fileDate'  => '20220628212651',
        ],
    ],
    'catalog' => [
        'path'    => 'legal-form',
        'summary' => [
            'list'   => 'Список организационно-правовых форм',
            'get'    => 'Получить организационно-правовую форму',
            'add'    => 'Создать организационно-правовую форму',
            'edit'   => 'Редактировать организационно-правовую форму',
            'delete' => 'Удалить организационно-правовую форму',
        ],
    ],
    'props'   => [
        [
            'migration' => [
                'name'     => 'title',
                'comment'  => 'Организационно-правовая форма',
                'type'     => 'AdapterInterface::PHINX_TYPE_STRING',
                'required' => true,
                'unique'   => true,
                'example'  => 'ООО',
            ],
            'model'     => [
                'const_name' => 'TITLE',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'ОАО',
                'rule'    => 'required|string|max:255|unique:ns_sp_legal_form,title,{id}',
            ],
        ],
    ],
];
