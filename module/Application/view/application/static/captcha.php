<?php

$form = $this->form;
$form->setAttribute('action', $this->url('www/captcha.php', array('controller' => 'testcaptcha', 'action' => 'form')));
$form->prepare();

echo $this->form()->openTag($form);

echo $this->formRow($form->get('captcha'));

echo $this->formSubmit($form->get('submit'));
echo $this->form()->closeTag();
?>