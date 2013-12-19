<?php

class shopMergerorderPluginBackendDialogController extends waJsonController {

    protected $tmp_path = 'plugins/mergerorder/templates/mergerorder.html';

    public function execute() {
        $orders = $this->getOrders(0, 100);       
        $view = wa()->getView();
        $view->assign('orders', $orders);
        $html = $view->fetch('plugins/mergerorder/templates/Dialog.html');
        $this->response = $html;
    }

    public function getOrders($offset, $limit) {

        $model = new shopOrderModel();
        $orders = $model->getList("*,items.name,items.type,items.quantity,contact,params", array(
            'offset' => $offset,
            'limit' => $limit,
                //'where' => $this->getFilterParams()
                )
        );
        shopHelper::workupOrders($orders);

        return $orders;
    }

}
