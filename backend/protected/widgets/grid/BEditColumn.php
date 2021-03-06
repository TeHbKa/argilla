<?php
/**
 * @author Sergey Glagolev <glagolev@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package backend.widgets
 */
class BEditColumn extends BDataColumn
{
  public $type = 'html';

  protected $popup = false;

  protected function renderDataCellContent($row, $data)
  {
    if( $this->popup )
    {
      parent::renderDataCellContent($row, $data);
    }
    else
    {
      echo CHtml::link($data->{$this->name}, Yii::app()->controller->createUrl('update', array('id' => $data->id)));
    }
  }
}