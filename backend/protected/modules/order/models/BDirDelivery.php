<?php
/**
 * @author Alexey Tatarinov <tatarinov@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package backend.modules.order.models
 *
 * @method static BDirDelivery model(string $className = __CLASS__)
 *
 * @property int    $id
 * @property string $name
 * @property int    $position
 * @property string $notice
 * @property bool   $visible
 */
class BDirDelivery extends BActiveRecord
{
  const SELF_DELIVERY = 1;

  const DELIVERY = 2;
}