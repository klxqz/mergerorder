<?php

class shopMergerorderPlugin extends shopPlugin {

    public function backendOrder($order) {
        $states = array_keys((array)$this->getSettings('states'));
        if ($this->getSettings('status') && in_array($order['state_id'], $states)) {
            $view = wa()->getView();
            $view->assign('order', $order);
            $html = $view->fetch('plugins/mergerorder/templates/BackendOrder.html');

            return array(
                'action_link' => $html
            );
        }
    }

}
