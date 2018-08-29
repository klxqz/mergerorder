<?php

class shopMergerorderPluginSettingsAction extends waViewAction {

    public function execute() {
        $workflow = new shopWorkflow();
        $this->view->assign(array(
            'states' => $workflow->getAllStates(),
            'plugin' => wa()->getPlugin('mergerorder'),
        ));
    }

}
