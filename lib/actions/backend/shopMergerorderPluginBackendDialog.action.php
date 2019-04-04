<?php

class shopMergerorderPluginBackendDialogAction extends waViewAction
{

    private $per_page = 30;

    public function execute()
    {
        $plugin = wa('shop')->getPlugin('mergerorder');
        $email_notification = $plugin->getSettings('email_notification');
        $order_id = waRequest::get('order_id', null, waRequest::TYPE_INT);
        if (!$order_id) {
            throw  new Exception('Не определен номер заказа');
        }

        $offset = waRequest::get('offset', 0, waRequest::TYPE_INT);
        $order_model = new shopOrderModel();
        $order = $order_model->getOrder($order_id);
        $order = shopHelper::workupOrders($order, true);

        $orders_collection = new shopOrdersCollection();
        $orders_collection->addWhere("`o`.`id` != '" . (int)$order_id . "'");
        if ($states = $plugin->getSettings('states')) {
            $orders_collection->addWhere("`o`.`state_id` IN ('" . implode("','", array_keys($states)) . "')");
        }
        $count = $orders_collection->count();
        $orders = $orders_collection->getOrders('*,items.name,items.type,items.quantity,contact,params', $offset, $this->per_page);
        shopHelper::workupOrders($orders);


        $this->view->assign(array(
            'email_notification' => $email_notification,
            'order' => $order,
            'orders' => $orders,
            'count' => $count,
            'per_page' => $this->per_page,
        ));
    }

}
