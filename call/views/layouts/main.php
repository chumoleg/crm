<?php

$this->beginContent('@common/views/layouts/main.php');

\call\assets\AppAsset::register($this);

echo $content;

$this->endContent();