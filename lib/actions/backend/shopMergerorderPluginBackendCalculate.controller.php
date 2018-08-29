<?php

class shopMergerorderPluginBackendCalculateController extends waJsonController {

    public function execute() {
        try {
            $plugin = wa('shop')->getPlugin('mergerorder');
            $order_id = waRequest::post('order_id', null, waRequest::TYPE_INT);
            $orders = waRequest::post('orders');

            $order_model = new shopOrderModel();

            $order = $order_model->getOrder($order_id, false, false);

            $shipping = $order['shipping'];
            $discount = $order['discount'];
            if ($orders) {
                foreach ($orders as $_order_id) {
                    $_order = $order_model->getOrder($_order_id, false, false);
                    $items = $_order['items'];
                    foreach ($items as &$item) {
                        unset($item['id']);
                        unset($item['order_id']);
                        $item['price'] = shop_currency($item['price'], $_order['currency'], $order['currency'], false);
                    }
                    $order['items'] = array_merge($order['items'], $items);
                    if ($plugin->getSettings('shipping') == 'sum') {
                        $shipping += shop_currency($_order['shipping'], $_order['currency'], $order['currency'], false);
                    } elseif ($plugin->getSettings('shipping') == 'max') {
                        $_shipping = shop_currency($_order['shipping'], $_order['currency'], $order['currency'], false);
                        if ($_shipping > $shipping) {
                            $shipping = $_shipping;
                        }
                    }
                    if ($plugin->getSettings('discount') == 'sum') {
                        $discount += shop_currency($_order['discount'], $_order['currency'], $order['currency'], false);
                    }
                }
            }

            if ($plugin->getSettings('shipping') == 'auto') {
                $shipping_id = $order['params']['shipping_id'];
                $shipping_rate_id = ifset($order['params']['shipping_rate_id']);
                $order = new shopOrder($order);
                $shipping_methods = $order->getShippingMethods(true);
                $shipping = ifset($shipping_methods["$shipping_id.$shipping_rate_id"]['rate']);
            }
            if ($plugin->getSettings('discount') == 'auto') {
                $discount = shopDiscounts::calculate($order);
            }

            $this->response = array(
                'shipping' => (float) $shipping,
                'discount' => (float) $discount,
            );
        } catch (Exception $e) {
            $this->errors = $e->getMessage();
        }
    }

}
