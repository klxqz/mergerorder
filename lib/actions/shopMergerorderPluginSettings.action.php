<?php

class shopMergerorderPluginSettingsAction extends waViewAction {

    protected $workflow;

    public function execute() {
        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(array('shop', 'mergerorder'));
        $settings['states'] = json_decode($settings['states'], true);
        $workflow = $this->getWorkflow();
        $states = $workflow->getAllStates();
        $this->view->assign('states', $states);
        $this->view->assign('settings', $settings);
    }

    public function getWorkflow() {
        if (!$this->workflow) {
            $this->workflow = new shopWorkflow();
        }
        return $this->workflow;
    }

}
