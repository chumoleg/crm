<?php
$this->beginContent('@common/views/layouts/base.php');
echo $this->render('_header', ['menuItems' => $menuItems]);
echo $this->render('_content', ['content' => $content]);
$this->endContent();