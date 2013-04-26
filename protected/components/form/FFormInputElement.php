<?php
class FFormInputElement extends CFormInputElement
{
  public $baseType;

  public $defaultLayout = "<div class=\"text-container\">\n{label}\n<div class=\"pdb\"><span class=\"inp_container\">{input}</span>\n{hint}\n{error}</div>\n</div>\n";

  private $_label;

  public function __construct($config, $parent)
  {
    /**
     * Уничтожается публичное свойство, чтобы заработали магичкские метобы _get, _set из CFormElement
     */
    unset($this->layout);

    parent::__construct($config, $parent);
  }

  public function getLabel()
  {
    if($this->_label!==null)
      return $this->_label;
    else
      return $this->getParent()->getModel()->getAttributeLabel(preg_replace('/(\[\w+\])?(\w+)/', '$2', $this->name));
  }

  public function getLayout()
  {
    if( !empty($this->baseType) )
      $typeName = ucfirst($this->baseType);
    else
      $typeName = ucfirst($this->type);

    $methodName = 'get' . $typeName . 'Layout';

    if( method_exists($this, $methodName) )
      return $this->$methodName();

    if( isset($this->attributes['layout']) )
      return $this->attributes['layout'];

    $rootParent = $this->getRootParent();
    if( isset($rootParent->elementLayout) && $rootParent->elementLayout !== null )
      return $rootParent->elementLayout;

    return $this->defaultLayout;
  }

  protected function getRootParent()
  {
    if( !($this->parent instanceof CForm) )
      return $this->parent;

   $parent = $this->parent;

    while( $parent instanceof CForm && $parent->parent instanceof CForm )
      $parent = $parent->parent;

    return $parent;
  }

  protected function getFileLayout()
  {
    return "<div class=\"text-container\">
              {label}
              <div class=\"pdb\">
                <div class=\"fileinput-button btn btn-red\">
                  Выбрать файл
                  {input}
                </div>
                <div id=\"" . get_class($this->getParent()->getModel()) . '_' . $this->name . "_file_wrap_list\" class=\"MultiFile-list\"></div>
                {hint}{error}
              </div>
            </div>";
  }

  public function getCheckboxlistLayout()
  {
    $template = "<div class=\"clearfix m10\" style=\"padding-left: 163px\">";

    foreach( $this->items as $id => $name )
    {
      $template .= '<div class="left">';

      $template .= "<input type='checkbox' name='".get_class($this->getParent()->getModel())."[".$this->name."][]' value='".$id."' id='".get_class($this->getParent()->getModel())."_".$this->name."_".$id."' style='display: none;'>";
      $template .= '<span style="margin-top: 2px; margin-right: 5px;" class="checkbox el-name-'.get_class($this->getParent()->getModel()).$this->name.'"></span>';
      $template .= '<label for="'.get_class($this->getParent()->getModel())."_".$this->name."_".$id.'">'.$name.'</label>';

      $template .= '</div>';
    }

    $template .= "</div>";

    return $template;
  }
}