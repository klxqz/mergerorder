<?php

return array(
    'name' => 'Объединение заказов',
    'description' => 'позволяет объединить несколько заказов в один',
    'vendor' => '985310',
    'version' => '1.0.1',
    'img' => 'img/mergerorder.png',
    'shop_settings' => true,
    'frontend' => false,
    'handlers' => array(
        'backend_order' => 'backendOrder'
    ),
);
//EOF
