<?php

namespace App\Helpers;

final class HelperWidgetSettingsDefaults
{
    public const PERIOD_DEFAULT  = 'week';
    public const PERIOD = [
        'from' => null,
        'to'   => null,
    ];
    public const ARTICLE = [
        'title'    => 'Статья КоАП',  // заголовок параметра
        'catalog'  => 'articlesKoap', // из какого каталога брать список (фронт)
        'type'     => 'select',       // тип поля ввода
        'label'    => 'title',        // какой параметр из селекта выводить
        'payload'  => 'id',           // какой параметр из селекта отправлять
        'value'    => null            // то что было выбрано пользователем
    ];

    /**
     * Получение настроек виджета по-умолчанию по коду виджета
     *
     * @param string $code
     * @return string
     */
    public static function getByCode(string $code): array
    {
        return ['settings' => self::DEFAULTS[$code], 'is_activated' => false];
    }

    public const DEFAULTS = [
        'wd_count_dtp_ts_types_by_division'  => ['period' => 'week', 'position' => 'bottom-right'], // 1
        'wd_peni_mp_division'                => ['period' => 'week', 'position' => 'bottom-right', 'division' => null], // 2
        'wd_kol_mp_fiz'                      => ['period' => 'week', 'position' => 'bottom-right', 'article' => null], // 3
        'wd_kol_mp_ur'                       => ['period' => 'week', 'position' => 'bottom-right', 'article' => null], // 4
        'wd_kol_by_line_division'            => ['period' => 'week', 'position' => 'bottom-right', 'line' => null], // 5
        'wd_kol_by_article_division'         => ['period' => 'week', 'position' => 'bottom-right', 'division' => null, 'article' => null], // 6
        'wd_kol_by_line_article_division'    => ['period' => 'week', 'position' => 'bottom-right', 'line' => null, 'article' => null], // 7
        'wd_kol_by_status_division'          => ['period' => 'week', 'position' => 'bottom-right', 'division' => null], // 8
        'wd_kol_by_status_line_division'     => ['period' => 'week', 'position' => 'bottom-right', 'line' => null], // 9
        'wd_kol_mp_by_employee_division'     => ['period' => null, 'position' => 'bottom-right', 'user' => null, 'article' => null], // 10
        'wd_kol_by_ts_division'              => ['period' => null, 'position' => 'bottom-right', 'division' => null], // 11
        'wd_kol_by_peni_division'            => ['period' => null, 'position' => 'bottom-right', 'division' => null], // 12
        'wd_kol_by_peni_line_division'       => ['period' => null, 'position' => 'bottom-right', 'line' => null], // 13
        'wd_kol_by_resolution_line_division' => ['period' => null, 'position' => 'bottom-right', 'line' => null], // 14
        'wd_minor'                           => [ // 15
            'period'     => null,
            'position'   => 'bottom-right',
            'individual' => [
                'article' => self::ARTICLE,
            ]
        ],
    ];
}
