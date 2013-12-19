<?php

return array(
    'name' => 'Объединение заказов',
    'description' => 'позволяет объединить несколько заказов в один',
    'vendor' => '985310',
    'version' => '1.0.0',
    'img' => 'img/sale.png',
    'shop_settings' => false,
    'frontend' => false,
    'handlers' => array(
        'backend_order' => 'backendOrder'
    ),
);
//EOF
