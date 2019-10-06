<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/8
 * Time: 10:16
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\ProductException;

class Product
{
    public function getRecent($count=15){
        (new Count())->gocheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
//        $collection = collection($products);
//        $products = $collection->hidden(['summary']);
        $products = $products->hidden(['summary']);
//        return 'success';
        return $products;
    }

    public function getAllInCategory($id){
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }

    public function deleteOne($id){

    }
}