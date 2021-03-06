<?php
/**
 * @author Sergey Glagolev <glagolev@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package frontend.components.validators
 *
 * Example:
 *
 * array('payer_name', 'ExRequiredValidator', 'dependedAttribute' => 'payment_id', 'dependedValue' => DirPayment::BANK_PAYMENT)
 */
class ExRequiredValidator extends CRequiredValidator
{
  public $dependedAttribute;

  public $dependedValue;

  public function validateAttribute($object, $attribute)
  {
    if( $object->{$this->dependedAttribute} == $this->dependedValue )
    {
      parent::validateAttribute($object, $attribute);
    }
  }
}