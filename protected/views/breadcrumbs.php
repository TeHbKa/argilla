<?php
/**
 * @var FController $this
 */
$this->widget('FBreadcrumbs', array(
  'links' => $this->breadcrumbs,
  'separator' => '<span class="breadcrumbs-separator"></span>',
  'htmlOptions' => array('class' => 'breadcrumbs'),
));