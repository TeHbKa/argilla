<?php
/**
 * @author Alexey Tatarivov <tatarinov@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package frontend.components.collection
 */
class FCompare extends FCollectionUI
{
  public $classChangeTab = 'change-tab-{keyCollection}';

  protected $groups;

  protected $elements;

  public function getGroups($refresh = false)
  {
    if( is_null($this->groups) || $refresh )
    {
      $this->groups = array();

      foreach($this as $element)
      {
        $group = $this->getElementGroup($element);
        $this->groups[$group->id] = $group;
      }
    }

    return $this->groups;
  }

  public function getElementsByGroup($id, $refresh = false)
  {
    if( is_null($this->elements) || !isset($this->elements[$id]) || $refresh )
    {
      $this->elements[$id] = array();

      foreach($this as $element)
        if( $this->getElementGroup($element)->id == $id )
          $this->elements[$id][] = $element;
    }

    return $this->elements[$id];
  }

  public function getProductListByGroup($id)
  {
    $productsCriteria = new CDbCriteria();
    $productsCriteria->addInCondition('t.id', CHtml::listData($this->getElementsByGroup($id), 'id', 'id'));
    $productList = new ProductList($productsCriteria, null, false);
    $productList->parametersCriteria = $this->getProductsCompareCriteria($id);

    foreach($productList->getDataProvider()->getData() as $product)
      foreach($this as $collectionProduct)
        if( $product->id == $collectionProduct->id)
          $product->mergeCollectionAttributes($collectionProduct);

    return $productList;
  }

  public function countAmount()
  {
    return $this->count();
  }

  public function countAmountByGroup($id, $refresh = false)
  {
    return count($this->getElementsByGroup($id, $refresh));
  }

  public function buttonChangeTab($text, $groupId, $htmlOptions = array())
  {
    $htmlOptions['class'] = empty($htmlOptions['class']) ? $this->classChangeTab :  $htmlOptions['class'].' '.$this->classChangeTab;
    $htmlOptions['data-id'] = $groupId;

    return CHtml::link($text, '#', $htmlOptions);
  }

  public function removeButton($element, $text = '', $htmlOptions = array(), $confirm = true)
  {
    $htmlOptions['data-group-id'] = $this->getElementGroup($element)->id;

    return parent::removeButton($element, $text, $htmlOptions, $confirm);
  }

  protected function getElementGroup($element)
  {
    return $element->section;
  }

  protected function getProductsCompareCriteria($groupId)
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('assignment.section_id IS NULL', 'OR');
    $criteria->addCondition('assignment.section_id = 0', 'OR');
    $criteria->compare('assignment.section_id', $groupId, false, 'OR');
    $criteria->compare('t.product', 1, false);
    $criteria->with = array('assignment');

    return $criteria;
  }

  protected function registerScripts()
  {
    parent::registerScripts();
    $this->registerButtonChangeTabScript();
  }

  protected function registerButtonChangeTabScript()
  {
    $script = "$('body').on('click', '.{$this->classChangeTab}', function(e){
      e.preventDefault();

      $.fn.collection('{$this->keyCollection}').send({
          'action' : 'changeTab',
          'data' : $(this).data(),
        });
    });";

    Yii::app()->clientScript->registerScript(__METHOD__.'#'.$this->keyCollection, $script, CClientScript::POS_END);
  }
}