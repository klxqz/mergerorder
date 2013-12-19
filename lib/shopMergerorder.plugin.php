<?php

class shopMergerorderPlugin extends shopPlugin {

    public function backendOrder($order) {
        $view = wa()->getView();
        $view->assign('order', $order);
        $html = $view->fetch('plugins/mergerorder/templates/BackendOrder.html');

        return array(
            'action_link' => $html
        );
    }

}
