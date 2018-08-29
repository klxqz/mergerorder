<?php

class shopMergerorderPluginBackendDialogAction extends waViewAction {

    public function execute() {
        $plugin = wa('shop')->getPlugin('mergerorder');
        $email_notification = $plugin->getSettings('email_notification');
        $order_id = waRequest::get('order_id', null, waRequest::TYPE_INT);
        $order_model = new shopOrderModel();
        $order = $order_model->getOrder($order_id);
        $order = shopHelper::workupOrders($order, true);

        $orders_collection = new shopOrdersCollection();
        $orders_collection->addWhere("`o`.`id` != '" . (int) $order_id . "'");
        if ($states = $plugin->getSettings('states')) {
            $orders_collection->addWhere("`o`.`state_id` IN ('" . implode("','", array_keys($states)) . "')");
        }
        $orders = $orders_collection->getOrders('*,items.name,items.type,items.quantity,contact,params', 0, 9999);
        shopHelper::workupOrders($orders);


        $this->view->assign(array(
            'email_notification' => $email_notification,
            'order' => $order,
            'orders' => $orders,
        ));
    }

}
