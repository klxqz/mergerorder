<?php

return array(
    'name' => 'Объединение заказов',
    'description' => 'Позволяет объединить несколько заказов в один',
    'vendor' => '985310',
    'version' => '2.0.0',
    'img' => 'img/mergerorder.png',
    'shop_settings' => true,
    'frontend' => false,
    'handlers' => array(
        'backend_order' => 'backendOrder'
    ),
);
//EOF
