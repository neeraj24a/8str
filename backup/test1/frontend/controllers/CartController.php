<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Drops;
use backend\models\Address;
use backend\models\Orders;
use backend\models\OrderDetails;
use frontend\config\Cart;
use frontend\models\AddressForm;
use frontend\models\Users;
use frontend\config\Paypal;

class CartController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $cart = new Cart();
        $session = Yii::$app->getSession();
        $subscription = $session->get('offer');
        $offer = $cart->getOffer();
        $total = $cart->getTotal();
        $totalWithOffer = $cart->getTotalWithOffer();
        return $this->render('index', ['cart' => $cart->getCart(), 'offer' => $offer, 'subscription' => $subscription, 'total' => $total, 'totalWithOffer' => $totalWithOffer, 'quantity' => $cart->getTotalQuantity()]);
    }

    public function actionCheckout() {
        $addresses = Address::findAll(['user' => Yii::$app->user->id]);
        $add_model = new AddressForm;
        $model = new \frontend\models\LoginForm;
        $cart = new Cart();
        $offer = $cart->getOffer();
        $total = $cart->getTotal();
        $totalWithOffer = $cart->getTotalWithOffer();
        if ($cart->getCart() == NULL) {
            return $this->redirect(['/cart']);
        }
        return $this->render('checkout', ['addresses' => $addresses, 'offer' => $offer, 'total' => $total, 'totalWithOffer' => $totalWithOffer, 'model' => $model, 'add_model' => $add_model, 'cart' => $cart->getCart(), 'total' => $cart->getTotal()]);
    }

    public function actionProcess() {
        $data = Yii::$app->request->post();
        $add = $data['AddressForm'];
        $cart = new Cart();
        $billing = [];
        $billing['first_name'] = $add['first_name'];
        $billing['last_name'] = $add['last_name'];
        $billing['address_line_1'] = $add['address_line_1'];
        $billing['address_line_2'] = $add['address_line_2'];
        $billing['city'] = $add['city'];
        $billing['state'] = $add['state'];
        $billing['country'] = 'USA';
        $billing['zip'] = $add['zip'];
        $billing['contact'] = $add['contact'];
        $billing['is_default'] = $add['is_default'];
        $billing['address_type'] = 'billing';
        $cart->setBillingAddress($billing);
        if(isset($add['ship_first_name'])){
            $shipping['first_name'] = $add['ship_first_name'];
            $shipping['last_name'] = $add['ship_last_name'];
            $shipping['address_line_1'] = $add['ship_address_line_1'];
            $shipping['address_line_2'] = $add['ship_address_line_2'];
            $shipping['city'] = $add['ship_city'];
            $shipping['state'] = $add['ship_state'];
            $shipping['country'] = 'USA';
            $shipping['zip'] = $add['ship_zip'];
            $shipping['contact'] = $add['ship_contact'];
            $shipping['is_default'] = $add['is_default'];
            $shipping['address_type'] = 'shipping';
            $cart->setShippingAddress($shipping);
        }

        /*$body = $this->renderPartial('_success', ['order' => $order, 'detail' => $detail, 'shipping' => $shipping_address, 'billing' => $billing_address]);

        $user = Users::findOne(Yii::$app->user->id);

        $u = new Users;
        $adminEmail = Yii::$app->params['adminEmail'];
        $u->sendEmail($adminEmail, $adminEmail, $body, 'Pixelstore', $user->email, $body, $user->first_name . ' ' . $user->last_name);
        */
        //send email


        $this->redirect(['/cart/payment']);
    }

    public function actionPayment() {
        $addresses = Address::findAll(['user' => Yii::$app->user->id]);
        $add_model = new AddressForm;
        $model = new \frontend\models\LoginForm;
        $cart = new Cart();
        if ($cart->getCart() == NULL) {
            return $this->redirect(['/cart']);
        }
        $products = $cart->getCart();
        $offer = $cart->getOffer();
        $total = $cart->getTotal();
        $totalWithOffer = $cart->getTotalWithOffer();
        $offerAmount = $cart->getOfferAmount();
        $billing = $cart->billingAddress();
        $shipping = $cart->shippingAddress();
        $items = [];
        if(isset($products['shop'])){
            foreach($products['shop'] as $shop){
                $item = [];
                $item['name'] = $shop->name;
                $item['price'] = $shop->unit_price;
                $item['currency'] = 'USD';
                $item['quantity'] = $shop->quantity;
                array_push($items, $item);
            }
        }

        if(isset($products['drop'])){
            foreach($products['drop'] as $drop){
                $item = [];
                $item['name'] = $drop->title;
                $item['price'] = $drop->price;
                $item['currency'] = 'USD';
                $item['quantity'] = $drop->quantity;
                array_push($items, $item);
            }
        }

        $item = [];
        $item['name'] = 'Discount';
        $item['price'] = '-'.$offerAmount;
        $item['currency'] = 'USD';
        $item['quantity'] = '1';
        array_push($items, $item);

        $items = json_encode($items);
        $transaction = "[{
                          amount: {
                            total: '".$totalWithOffer."',
                            currency: 'USD',
                            details: {
                              subtotal: '".$totalWithOffer."',
                              tax: '0.00',
                              shipping: '0.00',
                              handling_fee: '0.00',
                              shipping_discount: '0.00',
                              insurance: '0.00'
                            }
                          },
                          description: 'The payment transaction description.',
                          custom: '90048630024435',
                          //invoice_number: '12345', Insert a unique invoice number
                          payment_options: {
                            allowed_payment_method: 'INSTANT_FUNDING_SOURCE'
                          },
                          soft_descriptor: 'ECHI5786786',
                          item_list: {
                            items: ".$items."
                          }
                        }]";
        return $this->render('payment', ['addresses' => $addresses, 'offer' => $offer, 'total' => $total, 'totalWithOffer' => $totalWithOffer, 'model' => $model, 'add_model' => $add_model, 'cart' => $cart->getCart(), 'total' => $total, 'billing' => $billing, 'shipping' => $shipping, 'transaction' => $transaction]);
    }

    public function actionTransact() {
        $data = Yii::$app->request->post();
        $cart = new Cart();
        $products = $cart->getCart();
        $total = $cart->getTotal();
        $totalWithOffer = $cart->getTotalWithOffer();
        $offer = $cart->getOffer();

        $user = Yii::$app->user->id;

        $bill_add = $cart->billingAddress();
        $ship_add = $cart->shippingAddress();
        $billing = Address::findOne(['user' => $user,'address_type' => 'billing','first_name' => $bill_add['first_name'],'last_name' => $bill_add['last_name'],'address_line_1' => $bill_add['address_line_1'],'address_line_2' => $bill_add['address_line_2'],'city' => $bill_add['city'],'state' => $bill_add['state'],'zip' => $bill_add['zip'],'contact' => $bill_add['contact']]);
        $bill_id = '';
        if($billing === null){
            $model = new Address;
            $model->first_name = $bill_add['first_name'];
            $model->last_name = $bill_add['last_name'];
            $model->address_line_1 = $bill_add['address_line_1'];
            $model->address_line_2 = $bill_add['address_line_2'];
            $model->city = $bill_add['city'];
            $model->state = $bill_add['state'];
            $model->country = 'USA';
            $model->zip = $bill_add['zip'];
            $model->contact = $bill_add['contact'];
            $model->is_default = $bill_add['is_default'];
            $model->address_type = 'billing';
            $model->save(false);
            $bill_id = $model->id;
        } else {
            $bill_id = $billing->id;
            if($billing->is_default != $bill_add['is_default'] && $bill_add['is_default'] == 1){
                $billing->is_default = 1;
                $billing->save(false);
            }
        }
        $ship_id = '';
        if($ship_add != null){
            $shipping = Address::findOne(['user' => $user,'address_type' => 'shipping','first_name' => $ship_add['ship_first_name'],'last_name' => $ship_add['ship_last_name'],'address_line_1' => $ship_add['ship_address_line_1'],'address_line_2' => $ship_add['ship_address_line_2'],'city' => $ship_add['ship_city'],'state' => $ship_add['ship_state'],'zip' => $ship_add['ship_zip'],'contact' => $ship_add['ship_contact']]);
            if($shipping === null){
                $sh_model = new Address;
                $sh_model->first_name = $ship_add['first_name'];
                $sh_model->last_name = $ship_add['last_name'];
                $sh_model->address_line_1 = $ship_add['address_line_1'];
                $sh_model->address_line_2 = $ship_add['address_line_2'];
                $sh_model->city = $ship_add['city'];
                $sh_model->state = $ship_add['state'];
                $sh_model->country = 'USA';
                $sh_model->zip = $ship_add['zip'];
                $sh_model->contact = $ship_add['contact'];
                $sh_model->is_default = $ship_add['is_default'];
                $sh_model->address_type = 'shipping';
                $sh_model->save(false);
                $ship_id = $sh_model->id;
            } else {
                $ship_id = $shipping->id;
                if($shipping->is_default != $ship_add['is_default'] && $ship_add['is_default'] == 1){
                    $shipping->is_default = 1;
                    $shipping->save(false);
                }
            }
        }


        $order = new Orders;
        $order->customer = Yii::$app->user->id;
        $order->order_number = getOrderNum();
        $order->order_amount = $totalWithOffer;
        $order->payment_method = 'paypal';
        $order->transaction_id = getOrderNum();
        $order->order_date = date("Y-m-d H:i:s");
        $order->is_paid = 1;
        $order->is_shipped = 0;
        $order->freight = 0;
        $order->shipping_address = $ship_id;
        $order->billing_address = $bill_id;
        $order->payment_status = 'success';
        $order->payment_details = json_encode($data);
        $order->note = '';
        $order->save(false);

        if(isset($products['shop'])){
            foreach ($products['shop'] as $info) {
                $detail = new OrderDetails;
                $detail->order = $order->id;
                $detail->product = $info->id;
                $detail->product_price = $info->unit_price;
                $detail->purchased_price = number_format($info->unit_price - ($offer/100 * $info->unit_price), 2);
                $detail->quantity = $info->quantity;
                $detail->save(false);
            }
        }

        if(isset($products['drop'])){
            foreach ($products['drop'] as $info) {
                $detail = new OrderDetails;
                $detail->order = $order->id;
                $detail->product = $info->id;
                $detail->product_price = $info->price;
                $detail->purchased_price = number_format($info->price - ($offer/100 * $info->price), 2);
                $detail->quantity = $info->quantity;
                $detail->description = $info->desc;
                $detail->save(false);
            }
        }
        $res = [];
        $res['order'] = $order->order_number;
        echo json_encode($res, true);
    }

    public function actionSuccess($order) {
        $order = Orders::findOne(['order_number' => $order]);
        $detail = OrderDetails::findAll(['order' => $order->id]);
        $shipping_address = Address::findOne(['address_type' => 'shipping', 'id' => $order->shipping_address]);
        $billing_address = Address::findOne(['address_type' => 'billing', 'id' => $order->billing_address]);
        $session = Yii::$app->session;
        $session->set('cart', NULL);
        return $this->render('success', ['order' => $order, 'detail' => $detail, 'shipping' => $shipping_address, 'billing' => $billing_address]);
    }

    public function actionTest($order) {
        $order = Orders::findOne(['order_number' => $order]);
        $detail = OrderDetails::findAll(['order' => $order->id]);
        $shipping_address = Address::findOne(['address_type' => 'shipping', 'id' => $order->shipping_address]);
        $billing_address = Address::findOne(['address_type' => 'billing', 'id' => $order->billing_address]);
        return $this->renderPartial('_success', ['order' => $order, 'detail' => $detail, 'shipping' => $shipping_address, 'billing' => $billing_address]);
    }

    public function actionAdd() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $product = $data['product'];
            $quantity = $data['quantity'];
            $type = $data['type'];
            if($type == 'drop'){
                $desc = $data['description'];
                $info = Drops::findOne(['slug' => $product]);
                if ($info !== null) {
                    $info->desc = $desc;
                    if($info->type == 'video' && $info->youtube != ''){
                        $p['main_image'] = 'https://img.youtube.com/vi/'.getUtubeId($info->youtube).'/hqdefault.jpg';    
                    } else {
                        $p['main_image'] = Yii::$app->homeUrl.'images/audio-drop.png';   
                    }
                    $info->thumbnail = $p['main_image'];
                    $cart = new Cart();
                    if(!$cart->getItemInCart($info->slug, $type)){
                        $qty = $cart->addToCart($info, $type, $quantity);
                        $total = $cart->getTotal();
                        $total_qty = $cart->getTotalQuantity();
                        $p['slug'] = $info->slug;
                        $p['name'] = $info->title;
                        $p['price'] = $info->price;
                        if($info->type == 'video' && $info->youtube != ''){
                            $p['main_image'] = 'https://img.youtube.com/vi/'.getUtubeId($info->youtube).'/hqdefault.jpg';    
                        } else {
                            $p['main_image'] = Yii::$app->homeUrl.'images/audio-drop.png';   
                        }
                        $p['msg'] = 'Added';
                        $p['qty'] = $qty;
                        $p['total'] = $total;
                        $p['quantity'] = $total_qty;
                        $p['items'] = $cart->getItemCount();
                        echo json_encode($p);
                    } else {
                        $p['msg'] = 'Already Added';
                        echo json_encode($p);
                    }
                }
            } else {
                $info = Products::findOne(['slug' => $product]);
                if ($info !== null) {
                    $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                    $cart = new Cart();
                    $qty = $cart->addToCart($info, $type, $quantity);
                    $total = $cart->getTotal();
                    $total_qty = $cart->getTotalQuantity();
                    $p['slug'] = $info->slug;
                    $p['name'] = $info->name;
                    $p['price'] = $info->unit_price;
                    $p['main_image'] = $img;
                    $p['qty'] = $qty;
                    $p['total'] = $total;
                    $p['quantity'] = $total_qty;
                    $p['items'] = $cart->getItemCount();
                    echo json_encode($p);
                }
            }
        }
    }

    public function actionUpdatecart() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $products = $data['products'];
            $array = [];
            foreach ($products as $prod) {
                $product = $prod['product'];
                $quantity = $prod['quantity'];
                $type = $prod['type'];
                $desc = $prod['desc'];
                if($type == 'drop'){
                    $info = Drops::findOne(['slug' => $product]);
                    if ($info !== null) {
                        $cart = new Cart();
                        $info->desc = $desc;
                        $qty = $cart->updateCart($info, $type, $quantity);
                        if ($qty != null) {
                            $total = $cart->getTotal();
                            $total_qty = $cart->getTotalQuantity();
                            $p['slug'] = $info->slug;
                            $p['name'] = $info->title;
                            $p['price'] = $info->price;
                            if($info->type == 'video' && $info->youtube != ''){
                                $p['main_image'] = 'https://img.youtube.com/vi/'.getUtubeId($info->youtube).'/hqdefault.jpg';    
                            } else {
                                $p['main_image'] = Yii::$app->homeUrl.'images/audio-drop.png';   
                            }
                            $p['qty'] = $qty;
                            $p['total'] = $total;
                            $p['quantity'] = $total_qty;
                            $p['items'] = $cart->getItemCount();
                            array_push($array, $p);
                        }
                    }
                } else {
                    $info = Products::findOne(['slug' => $product]);
                    if ($info !== null) {
                        $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                        $cart = new Cart();
                        $qty = $cart->updateCart($info, $type, $quantity);
                        if ($qty != null) {
                            $total = $cart->getTotal();
                            $total_qty = $cart->getTotalQuantity();
                            $p['slug'] = $info->slug;
                            $p['name'] = $info->name;
                            $p['price'] = $info->unit_price;
                            $p['main_image'] = $img;
                            $p['qty'] = $qty;
                            $p['total'] = $total;
                            $p['quantity'] = $total_qty;
                            $p['items'] = $cart->getItemCount();
                            array_push($array, $p);
                        }
                    }
                }
            }
            echo json_encode($array);
        }
    }

    public function actionRemove() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $product = $data['product'];
            $type = $data['type'];
            if($type == 'drop'){
                $info = Drops::findOne(['slug' => $product]);
                if ($info !== null) {
                    $cart = new Cart();
                    $qty = $cart->removeFromCart($info, 'drop');
                    $total = $cart->getTotal();
                    $total_qty = $cart->getTotalQuantity();
                    $p['msg'] = 'Removed';
                    $p['slug'] = $info->slug;
                    $p['total'] = $total;
                    $p['quantity'] = $total_qty;
                    $p['items'] = $cart->getItemCount();
                    echo json_encode($p);
                }    
            } else {
                $info = Products::findOne(['slug' => $product]);
                if ($info !== null) {
                    $cart = new Cart();
                    $qty = $cart->removeFromCart($info, 'shop');
                    $total = $cart->getTotal();
                    $total_qty = $cart->getTotalQuantity();
                    $p['slug'] = $info->slug;
                    $p['total'] = $total;
                    $p['quantity'] = $total_qty;
                    $p['items'] = $cart->getItemCount();
                    echo json_encode($p);
                }
            }
        }
    }

    public function actionLoad() {
        if (Yii::$app->request->isAjax) {
            $cart = new Cart();
            $details = $cart->getCart();
            $total = $cart->getTotal();
            $total_qty = $cart->getTotalQuantity();
            $response = [];
            $response['products'] = [];
            foreach ($details as $info) {
                $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                $p['slug'] = $info->slug;
                $p['name'] = $info->name;
                $p['price'] = $info->unit_price;
                $p['main_image'] = $img;
                $p['qty'] = $info->quantity;
                array_push($response['products'], $p);
            }
            $response['total'] = $total;
            $response['quantity'] = $total_qty;
            $response['items'] = $cart->getItemCount();
            echo json_encode($response);
        }
    }

}
