<?php

$files = array(
    'plugins/mergerorder/lib/actions/shopMergerorderPluginBackendDialog.controller.php',
    'plugins/mergerorder/lib/actions/shopMergerorderPluginBackendMerge.controller.php',
    'plugins/mergerorder/lib/actions/shopMergerorderPluginSettings.action.php',
    'plugins/mergerorder/templates/BackendOrder.html',
    'plugins/mergerorder/templates/Dialog.html',
    'plugins/mergerorder/lib/models/shopMergerorderPluginOrder.model.php',
    'plugins/mergerorder/lib/models/shopMergerorderPluginOrderItems.model.php',
    'plugins/mergerorder/lib/models/',
);

foreach ($files as $file) {
    try {
        waFiles::delete(wa()->getAppPath($file, 'shop'), true);
    } catch (Exception $e) {
        
    }
}

$plugin_id = array('shop', 'mergerorder');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'shipping', 'auto');
$app_settings_model->set($plugin_id, 'discount', 'auto');
