<?php
/**
 * @author Alexey Tatarivov <tatarinov@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package frontend.tests.components
 */
class THttpRequest extends CHttpRequest
{
  protected $_requestUri;

  public function setRequestUri($string)
  {
    $this->_requestUri = $string;
  }

  public function getRequestUri()
  {
    if( $this->_requestUri === null )
    {
      $this->_requestUri = parent::getRequestUri();
    }

    return $this->_requestUri;
  }

  public function redirect($url, $terminate = true, $statusCode = 302)
  {
    if( strpos($url, '/') === 0 && strpos($url, '//') !== 0 )
    {
      $url = $this->getHostInfo().$url;
    }

    throw new TRedirectException(200, 'Location: '.$url, $statusCode);
  }
}