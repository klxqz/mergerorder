<?php

class shopMergerorderPluginBackendMergeController extends waJsonController {

    public function execute() {
        $order_model = new shopOrderModel();

        $order_id = waRequest::post('order_id');
        $order = $order_model->getOrder($order_id);


        $orders = waRequest::post('orders');

        foreach (array_keys($orders) as $_order_id) {
            $_order = $order_model->getOrder($_order_id);
            $items = $_order['items'];
            foreach ($items as &$item) {
                unset($item['id']);
                unset($item['order_id']);
            }
            $order['items'] = array_merge($order['items'], $items);
            $order_model->delete($_order_id);
        }



        $order['total'] = $this->calcTotal($order);
        $order_model->update($order, $order_id);

        $log_model = new shopOrderLogModel();
        $log = $log_model->getLog($order_id);

        $data = array(
            'action_id' => 'comment',
            'order_id' => $order_id,
            'before_state_id' => $order['state_id'],
            'after_state_id' => $order['state_id'],
            'text' => 'Объединение заказов '
        );
        $log_model->add($data);

        $this->response = '<h1>Заказы успешно объединены</h1>';
    }

    public function calcTotal($data) {
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $this->cast($item['price']) * (int) $item['quantity'];
        }
        if ($total == 0) {
            return $total;
        }
        return $total - $this->cast($data['discount']) + $this->cast($data['shipping']);
    }

    private function cast($value) {
        if (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', $value);
        }
        return str_replace(',', '.', (double) $value);
    }

}
