<?php

class shopMergerorderPluginBackendMergeController extends waJsonController {

    public function execute() {
        $order_model = new shopOrderModel();
        $log_model = new shopOrderLogModel();
        $order_id = waRequest::post('order_id', null, waRequest::TYPE_INT);
        $order_id_str = shopHelper::encodeOrderId($order_id);
        $order = $order_model->getOrder($order_id);

        $orders = waRequest::post('orders');
        $orders_str = array();
        foreach (array_keys($orders) as $_order_id) {
            $orders_str[] = shopHelper::encodeOrderId($_order_id);
        }

        foreach (array_keys($orders) as $_order_id) {
            $_order = $order_model->getOrder($_order_id);
            $items = $_order['items'];
            foreach ($items as &$item) {
                unset($item['id']);
                unset($item['order_id']);
                $item['price'] = shop_currency($item['price'], $_order['currency'], $order['currency'], false);
            }
            $order['items'] = array_merge($order['items'], $items);
            $order['discount'] += shop_currency($_order['discount'], $_order['currency'], $order['currency'], false);

            $data = array(
                'action_id' => 'comment',
                'order_id' => $_order_id,
                'before_state_id' => $order['state_id'],
                'after_state_id' => 'delete',
                'text' => "Удаление после объединения. Заказ $order_id_str объединен с " . implode(', ', $orders_str)
            );
            $log_model->add($data);
            $order_model->delete($_order_id);
        }

        $order['total'] = $this->calcTotal($order);
        $order_model->update($order, $order_id);


        $log = $log_model->getLog($order_id);

        $data = array(
            'action_id' => 'comment',
            'order_id' => $order_id,
            'before_state_id' => $order['state_id'],
            'after_state_id' => $order['state_id'],
            'text' => "Объединение заказов. Заказ $order_id_str объединен с " . implode(', ', $orders_str)
        );
        $log_model->add($data);

        $this->response = '<h1>Заказы успешно объединены</h1>';
    }

    public function calcTotal($data) {
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * (int) $item['quantity'];
        }
        if ($total == 0) {
            return $total;
        }
        return $total - $data['discount'] + $data['shipping'];
    }

}
