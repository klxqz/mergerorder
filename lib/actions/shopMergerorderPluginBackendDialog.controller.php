<?php

class shopMergerorderPluginBackendDialogController extends waJsonController {

    protected $tmp_path = 'plugins/mergerorder/templates/mergerorder.html';

    public function execute() {
        $order_id = waRequest::request('order_id');
        $order_model = new shopOrderModel();
        $order = $order_model->getOrder($order_id);
        $order = shopHelper::workupOrders($order, true);
    
        $orders = $this->getOrders();
        foreach ($orders as $index => $_order) {
            if ($_order['id'] == $order_id) {
                unset($orders[$index]);
            }
        }
        $view = wa()->getView();
        $view->assign('order', $order);
        $view->assign('orders', $orders);
        $html = $view->fetch('plugins/mergerorder/templates/Dialog.html');
        $this->response = $html;
    }

    public function getOrders() {

        $model = new shopOrderModel();
        $orders = $model->getList("*,items.name,items.type,items.quantity,contact,params");
        shopHelper::workupOrders($orders);

        return $orders;
    }

}
