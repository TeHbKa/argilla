<?php
/**
 * @author Sergey Glagolev <glagolev@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package backend.modules.product
 *
 * @method static BProductSection model(string $class = __CLASS__)
 *
 * @property string $id
 * @property integer $position
 * @property string $url
 * @property string $name
 * @property string $notice
 * @property integer $visible
 *
 * @property BProductAssignment[] $productAssignments
 */
class BProductSection extends BProductStructure
{

  public function rules()
  {
    return array(
      array('url, name', 'required'),
      array('url', 'unique'),
      array('position, visible', 'numerical', 'integerOnly' => true),
      array('url', 'length', 'max' => 255),
      array('name, notice', 'safe'),
    );
  }

  public function attributeLabels()
  {
    return CMap::mergeArray(parent::attributeLabels(), array(
    ));
  }
}