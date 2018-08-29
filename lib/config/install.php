<?php

$plugin_id = array('shop', 'mergerorder');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'status', '1');
$app_settings_model->set($plugin_id, 'states', '{"new":"1","processing":"1"}');
$app_settings_model->set($plugin_id, 'email_notification', '1');
$app_settings_model->set($plugin_id, 'body', '<p>Здравствуйте, {$customer.name|escape}!' . "\r\n" .
        '</p><p>Ваш заказ {$order.id} был объединен с заказами {$merged_orders}</p>' . "\r\n" .
        '<p>Спасибо за покупку в магазине «{$wa->shop->settings("name")|escape}»!</p>' . "\r\n" .
        '<p>--<br>' . "\r\n" .
        '{$wa->shop->settings("name")|escape}<br>' . "\r\n" .
        '<a href="mailto:{$wa->shop->settings("email")}">{$wa->shop->settings("email")}</a><br>' . "\r\n" .
        '{$wa->shop->settings("phone")}<br></p>');
$app_settings_model->set($plugin_id, 'shipping', 'auto');
$app_settings_model->set($plugin_id, 'discount', 'auto');
