<?php
$data = ARRAY_PASTED_FROM_STEP_6;
$model = Mage::getModel('salesrule/rule');
if (isset($data['rule_id'])) {
    $model->load($data['rule_id']);
}
if (isset($data['simple_action']) && $data['simple_action'] == 'by_percent'
    && isset($data['discount_amount'])
) {
    $data['discount_amount'] = min(100, $data['discount_amount']);
}
if (isset($data['rule']['conditions'])) {
    $data['conditions'] = $data['rule']['conditions'];
}
if (isset($data['rule']['actions'])) {
    $data['actions'] = $data['rule']['actions'];
}
unset($data['rule']);
$model->loadPost($data);
$useAutoGeneration = (int)!empty($data['use_auto_generation']);
$model->setUseAutoGeneration($useAutoGeneration);
$model->save();