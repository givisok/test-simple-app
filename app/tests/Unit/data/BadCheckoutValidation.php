<?php

return [
    'bad_token'      => [
        'order'    =>
            [
                'user_name'  => 'Igor Fedotov',
                'user_email' => 'givis22@mail.ru',
                'address'    => 'Gubkina 25a kv 1, 25',
                'token'      => 'uhnxkhjtfwwnpxfmeurzyntdj',
            ],
        'products' =>
            [
                [
                    'id'         => 1,
                    'name'       => 'iPhone 7+',
                    'real_price' => 550,
                    'quantity'   => 1,
                ],
            ],
    ],
    'empty_product' => [
        'order'    =>  [
            'user_name'  => 'Igor Fedotov',
            'user_email' => 'givis22@mail.ru',
            'address'    => 'Gubkina 25a kv 1, 25',
            'token'      => 'uhnxkhjtfwwnpxfmeurzyntdjwad',
        ],
        'products' =>
            [
            ],
    ],

    'empty_order'   => [

        'products' => [
            [
                'id'         => 1,
                'name'       => 'iPhone 7+',
                'real_price' => 550,
                'quantity'   => 1,
            ],
        ],
    ],

    'bad_email'     => [
        'order'    =>  [
            'user_name'  => 'Igor Fedotov',
            'user_email' => 'givis22@mail.ru',
            'address'    => 'Gubkina 25a kv 1, 25',
            'token'      => 'uhnxkhjtfwwnpxfmeurzyntdjwad',
        ],
        'products' =>
            [
                [
                    'id'         => 1,
                    'name'       => 'iPhone 7+',
                    'real_price' => 550,
                    'quantity'   => 1,
                ],
            ],
    ],
    'bad_product_id'     => [
        'order'    =>  [
            'user_name'  => 'Igor Fedotov',
            'user_email' => 'givis22@mail.ru',
            'address'    => 'Gubkina 25a kv 1, 25',
            'token'      => 'uhnxkhjtfwwnpxfmeurzyntdjwad',
        ],
        'products' =>
            [
                [
                    'id'         => -1,
                    'name'       => 'iPhone 7+',
                    'real_price' => 550,
                    'quantity'   => 1,
                ],
            ],
    ],
];