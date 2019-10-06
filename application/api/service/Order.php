<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 2019/9/13
 * Time: 22:31
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    protected $oProducts;

//    真实的商品信息（包括库存量）
    protected $products;

    protected $uid;


    public function place($uid,$oProduct){

        $this->oProducts = $oProduct;
        $this->products = $this->getProductsByOrder($oProduct);
        $this->uid = $uid;
//        return $this->products;

//      id: 1
//      main_img_url: "http://z.cn/images/product-vg@1.png"
//      name: "芹菜 半斤"
//      price: "0.01"
//      stock: 998

//      id: 2
//      main_img_url: "http://z.cn/images/product-dryfruit@1.png"
//      name: "梨花带雨 3个"
//      price: "0.01"
//      stock: 984

//        $status = $this->getOrderStatus();
        $status = $this->getOrderStatus();
//            return $status;

//        orderPrice: 0.05
//        pStatusArray: [{id: 1, haveStock: true, count: 2, name: "芹菜 半斤", totalPrice: 0.02},…]
//        0: {id: 1, haveStock: true, count: 2, name: "芹菜 半斤", totalPrice: 0.02}
//        1: {id: 2, haveStock: true, count: 3, name: "梨花带雨 3个", totalPrice: 0.03}
//        pass: true
//        totalCount: 5

        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
//        开始创建订单,先组建订单快照的数组
        $orderSnap = $this->snapOrder($status);
//        return $orderSnap;

//        orderPrice: 0.05
//        pStatus: [{id: 1, haveStock: true, count: 2, name: "芹菜 半斤", totalPrice: 0.02},…]
//        0: {id: 1, haveStock: true, count: 2, name: "芹菜 半斤", totalPrice: 0.02}
//        1: {id: 2, haveStock: true, count: 3, name: "梨花带雨 3个", totalPrice: 0.03}
//        snapAddress: "{"name":"qiyue","mobile":"18888888888","province":"\u827e\u6cfd\u62c9\u65af","city":"\u66b4\u98ce\u57ce","country":"\u95ea\u91d1\u9547","detail":"\u72ee\u738b\u4e4b\u50b2\u65c5\u5e97","update_time":"1970-01-01 08:00:00"}"
//        snapImg: "http://z.cn/images/product-vg@1.png"
//        snapName: "芹菜 半斤等"
//        totalCount: 5

        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;

//        orderPrice: 3000.02
//        order_id: -1
//        pStatusArray: Array(2)
//        0: {id: 1, haveStock: true, count: 2, name: "芹菜 半斤", totalPrice: 0.02}
//        1: {id: 2, haveStock: false, count: 300000, name: "梨花带雨 3个", totalPrice: 3000}
//        pass: false
//        totalCount: 300002
    }

    private function createOrder($snap){

        Db::startTrans();
        try {

            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);

            $order->save();
//            1/0;

            $orderID = $order->id;
            $create_time = $order->create_time;

            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    public function makeOrderNo(){
        $yCode = array('A','B','C','D','E','F','G','H','I','J');
        $orderSn = $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m')))
            . date('d') . substr(time(),-5) . substr(microtime(), 2, 5)
            . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

//    生成订单快照
        private function snapOrder($status){
            $snap = [
              'orderPrice' =>0,
              'totalCount' =>0,
              'pStatus' =>[],
              'snapAddress' => null,
              'snapName' => '',
              'snapImg' =>''
            ];
//            20190913 订单快照的实现
            $snap['orderPrice'] = $status['orderPrice'];
            $snap['totalCount'] = $status['totalCount'];
            $snap['pStatus'] = $status['pStatusArray'];
            $snap['snapAddress'] = json_encode($this->getUserAddress());
            $snap['snapName'] = $this->products[0]['name'];
            $snap['snapImg'] = $this->products[0]['main_img_url'];

            if (count($this->products) > 1) {
                $snap['snapName'] .= '等';
            }
            return $snap;
        }

        private function getUserAddress(){
            $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
            if (!$userAddress) {
                throw new UserException([
                    'msg' => '用户收货地址不存在，下单失败',
                    'errorCode' => 60001
                ]);
            }
            return $userAddress->toArray();
        }

    /**
     * 返回订单状态，包括是否有库存，订单金额，各订单明细（二维数组）、
     * 总体的思路是用了两个大数组，一个是用户勾选的订单商品信息，一个是数据库查出来的，然后对两者进行比对
     * @return array
     * @throws OrderException
     *
     */
    private function getOrderStatus(){
//        return 'cc';
        $status = [
          'pass' =>true,
          'orderPrice' => 0,
          'totalCount' =>0,
          'pStatusArray' => []  //订单详细信息
        ];
//    循环取订单提交的信息，进行数据的写入
        foreach($this->oProducts as $oProduct){
//            通过对两个数组的比对，将每一个订单明细数据进行库存比对
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'],$oProduct['count'],$this->products
            );
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID,$oCount, $products){
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => 'id为'.$oPID.'商品不存在，创建订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if($product['stock'] - $oCount >= 0 ){
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;

    }
//用all方法 ，采用数组从数据库一次性查出来
    private function getProductsByOrder($oProducts){
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }

        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;

    }
}