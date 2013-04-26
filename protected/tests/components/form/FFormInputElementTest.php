<?php
/**
 * @author Alexey Tatarivov <tatarinov@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package frontend.tests.components.form
 */
class FFormInputElementTest extends CTestCase
{
  public function setUp()
  {
    parent::setUp();
  }

  public function testGetRootParent()
  {
    $form = new FForm(array('name' => 'Test'));
    $inputElement = new FFormInputElement(array(), $form);
    $this->assertInstanceOf('CForm', $inputElement->rootParent);
    $this->assertEquals('Test', $inputElement->rootParent->formName);

    $form = new FForm(array('name' => 'Test'), null, new User());
    $inputElement = new FFormInputElement(array(), $form);
    $this->assertInstanceOf('CForm', $inputElement->rootParent);
    $this->assertEquals('Test', $inputElement->rootParent->formName);

    $form1 = new FForm(array('name' => 'Test1'), null, new User());
    $form2 = new FForm(array('name' => 'Test2'), null, $form1);
    $inputElement = new FFormInputElement(array(), $form2);
    $this->assertInstanceOf('CForm', $inputElement->rootParent);
    $this->assertEquals('Test1', $inputElement->rootParent->formName);

    $form1 = new FForm(array('name' => 'Test1'), null, new User());
    $form2 = new FForm(array('name' => 'Test2'), null, $form1);
    $form3 = new FForm(array('name' => 'Test3'), null, $form2);
    $inputElement = new FFormInputElement(array(), $form3);
    $this->assertInstanceOf('CForm', $inputElement->rootParent);
    $this->assertEquals('Test1', $inputElement->rootParent->formName);
  }

  public function testGetLayout()
  {
    $layout = "<div class=\"text-container\">\n{label}\n<div class=\"pdb\"><span class=\"inp_container\">{input}</span>\n{hint}\n{error}</div>\n</div>\n";

    $dataForm = array(
      'elements' => array(
        'login' => array('type' => 'text'))
      );

    $form = new FForm($dataForm);
    $this->assertEquals($layout, $form->elements['login']->layout);


    $dataForm = array(
      'elements' => array(
        'login' => array(
          'type' => 'text',
          'layout' => '<div>{input}<div>'
        ))
    );

    $form = new FForm($dataForm);
    $this->assertEquals('<div>{input}<div>', $form->elements['login']->layout);


    $dataForm = array(
      'elementLayout' => '<div>{label}{input}<div>',
      'elements' => array(
        'login' => array('type' => 'text'),
      )
    );

    $form = new FForm($dataForm);
    $this->assertEquals('<div>{label}{input}<div>', $form->elements['login']->layout);


    $dataForm = array(
      'elementLayout' => '<div>{label}{input}{hint}<div>',
      'elements' => array(
        'login' => array(
          'type' => 'text',
          'layout' => '<div class="new">{input}<div>',
        )
      )
    );

    $form = new FForm($dataForm);
    $this->assertEquals('<div class="new">{input}<div>', $form->elements['login']->layout);
  }
}