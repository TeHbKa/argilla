<?php
/**
 * @author Sergey Glagolev <glagolev@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package frontend.models.xml
 */
class YandexDataProvider
{
  /**
   * @var CDbCriteria
   */
  protected $criteria;

  protected $products = array();

  protected $categories = array();

  public function __construct(CDbCriteria $criteria)
  {
    $this->criteria = $criteria;
    $this->buildOffers();
  }

  /**
   * @return array
   */
  public function getShop()
  {
    return array(
      'name'    => 'argilla.ru',
      'company' => 'Интернет-магазин',
      'url'     => 'http://www.argilla.ru/'
    );
  }

  /**
   * @return array
   */
  public function getCurrencies()
  {
    return array('RUR' => 1);
  }

  /**
   * @return array
   */
  public function getOffers()
  {
    return $this->products;
  }

  /**
   * @return array
   */
  public function getCategories()
  {
    return $this->categories;
  }

  protected function buildOffers()
  {
    $list = new ProductList($this->criteria, null, false);
    $list->fetchContent = false;
    $iterator = new CDataProviderIterator($list->getDataProvider(), 200);

    foreach($iterator as $offer)
    {
      $this->buildCategory($offer);
      $this->buildOffer($offer);
    }
  }

  protected function buildOffer(Product $product)
  {
    $this->products[] = array(
      'id'          => $product->id,
      'price'       => $product->price,
      'currencyId'  => 'RUR',
      'url'         => $this->getUrl($product),
      'categoryId'  => $product->type->id,
      'vendor'      => $product->category->name,
      'model'       => XmlHelper::escape($product->name),
      'description' => XmlHelper::escape(strip_tags($product->content)),
      'picture'     => $this->getImage($product),
      'available'   => $this->getAvailable($product),
      'manufacturer_warranty' => 'true',
    );
  }

  /**
   * @param Product $product
   *
   * @return bool
   */
  protected function getUrl(Product $product)
  {
    return $product->url.'?mrkt=true';
  }

  /**
   * @param Product $product
   *
   * @return bool
   */
  protected function getAvailable(Product $product)
  {
    return !empty($product['dump']) ? true : false;
  }

  /**
   * @param Product $product
   *
   * @return string
   */
  protected function getImage(Product $product)
  {
    $image = Arr::reset($product->getImages('main'));

    return $image ? Yii::app()->homeUrl.$image->getPath().rawurlencode($image->name) : '';
  }

  /**
   * @param Product $product
   */
  protected function buildCategory(Product $product)
  {
    if( isset($product->type) )
    {
      $this->categories[$product->type->id] = array(
        'name' => XmlHelper::escape($product->type->name),
      );
    }
  }
}