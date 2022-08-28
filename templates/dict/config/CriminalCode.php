<?php

return [
    'model'   => [
        'name'  => 'CriminalCode',
        'title' => 'Модель статьи УК РФ',
        'table' => [
            'name'      => 'ns_sp_articles_criminal_codex',
            'className' => 'NsSpArticlesCriminalCodex',
            'comment'   => 'Справочник статей Уголовного кодекса Российской Федерации',
            'fileDate'  => '20220628210000',
        ],
    ],
    'catalog' => [
        'path'    => 'criminal-code',
        'summary' => [
            'list'   => 'Список статей УК РФ',
            'get'    => 'Получить статью УК РФ',
            'add'    => 'Создать статью УК РФ',
            'edit'   => 'Редактировать статью УК РФ',
            'delete' => 'Удалить статью УК РФ',
        ],
    ],
    'props'   => [
        [
            'migration' => [
                'name'     => 'title',
                'comment'  => 'Статья',
                'type'     => 'AdapterInterface::PHINX_TYPE_STRING',
                'required' => true,
                'unique'   => false,
                'example'  => 'Статья 99. Виды принудительных мер медицинского характера',
            ],
            'model'     => [
                'const_name' => 'TITLE',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'Статья 101. Принудительное лечение в медицинской организации, оказывающей психиатрическую помощь в стационарных условиях',
                'rule'    => 'required|string|max:255',
            ],
        ],
        [
            'migration' => [
                'name'     => 'short_title',
                'comment'  => 'Краткое наименование',
                'type'     => 'AdapterInterface::PHINX_TYPE_STRING',
                'required' => true,
                'unique'   => false,
                'example'  => 'п."а" ч.1 ст.99 УК РФ',
            ],
            'model'     => [
                'const_name' => 'SHORT_TITLE',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => 'ч.1 ст.101 УК РФ',
                'rule'    => 'required|string|max:255',
            ],
        ],
        [
            'migration' => [
                'name'     => 'description',
                'comment'  => 'Часть и пункт статьи',
                'type'     => 'AdapterInterface::PHINX_TYPE_TEXT',
                'required' => true,
                'unique'   => false,
                'example'  => '1. Суд может назначить следующие виды принудительных мер медицинского характера: а) принудительное наблюдение и лечение у врача-психиатра в амбулаторных условиях;',
            ],
            'model'     => [
                'const_name' => 'DESCRIPTION',
            ],
            'catalog'   => [
                'type'    => 'string',
                'example' => '1. Принудительное лечение в медицинской организации, оказывающей психиатрическую помощь в стационарных условиях, может быть назначено при наличии оснований, предусмотренных статьей 97 настоящего Кодекса, если характер психического расстройства лица требует таких условий лечения, ухода, содержания и наблюдения, которые могут быть осуществлены только в медицинской организации, оказывающей психиатрическую помощь в стационарных условиях.',
                'rule'    => 'required|string|max:10240',
            ],
        ],
    ],
];
