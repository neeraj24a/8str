<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use backend\models\Products;
use backend\models\Drops;
use backend\models\Address;
use backend\models\Guests;
use backend\models\Orders;
use backend\models\OrderDetails;
use backend\models\PrintfulProductDetails;
use backend\models\ProductSyncData;

use frontend\config\Cart;
use frontend\config\MonologLogFactory;
use frontend\models\AddressForm;
use frontend\models\Users;
use frontend\config\Paypal;

use Printful\Exceptions\PrintfulApiException;
use Printful\Exceptions\PrintfulException;
use Printful\PrintfulApiClient;

use PayPal\Api\Order;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\ShippingAddress;

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
        if($subscription == ''){
           $subscription = 'no'; 
        }
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
        if($add['is_guest'] === 'yes'){
            $cart->setGuest($add['guest_email']);
        }
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
        $billing['is_default'] = 1;
        $billing['address_type'] = 'billing';
        $cart->setBillingAddress($billing);
		$products = $cart->getCart();
        if(isset($products['shop']) && sizeof($products['shop']) > 0){
            $shipping['first_name'] = $add['ship_first_name'];
            $shipping['last_name'] = $add['ship_last_name'];
            $shipping['address_line_1'] = $add['ship_address_line_1'];
            $shipping['address_line_2'] = $add['ship_address_line_2'];
            $shipping['city'] = $add['ship_city'];
            $shipping['state'] = $add['ship_state'];
            $shipping['country'] = 'USA';
            $shipping['zip'] = $add['ship_zip'];
            $shipping['contact'] = $add['ship_contact'];
            $shipping['is_default'] = 1;
            $shipping['address_type'] = 'shipping';
            $cart->setShippingAddress($shipping);
			$pf = new PrintfulApiClient('ciac7wnf-7cvl-wa20:io6q-8d0qfxlnvf42');
			$request = [];
			$request['recipient']  = ['address1' => $add['ship_address_line_1'],'city' => $add['ship_city'],'country_code' => 'US', 'state_code' => $add['ship_state'], 'zip' => $add['ship_zip']];
			$cart = new Cart();
			if ($cart->getCart() == NULL) {
				return $this->redirect(['/cart']);
			}
			$items = [];
			if(isset($products['shop'])){
				foreach($products['shop'] as $shop){
					$item = [];
					foreach($shop->var_qnty as $key => $val){
						foreach($val as $k => $v){
							$p = PrintfulProductDetails::find()->where(['and', "printful_product = '".$shop->printful_product."'","color = '".$key."'", "size = '".$k."'"])->one();
							$item['quantity'] = $shop->quantity;
							$item['variant_id'] = $p->printful_product_id;
							array_push($items, $item);
						}
					}
				}
			}
			
			$request['items'] = $items;

			try {
				// Calculate shipping rates for an order
				$response = $pf->post('shipping/rates', $request);
				foreach($response as $res){
					if($res['id'] == 'STANDARD'){
						$ship_cost = $res['rate'];
						$cart->setShippingCost($ship_cost);
						break;
					}
				}
				$this->redirect(['/cart/payment']);
			} catch (PrintfulApiException $e) { //API response status code was not successful
				echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
			} catch (PrintfulException $e) { //API call failed
				echo 'Printful Exception: ' . $e->getMessage();
				var_export($pf->getLastResponseRaw());
			}
        } else {
			$cart->setShippingCost(0);
			$this->redirect(['/cart/payment']);
		}
		
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
		$sub_total = $cart->getSubTotal();
        $billing = $cart->billingAddress();
        $shipping = $cart->shippingAddress();
		$shipping_cost = $cart->getShippingCost();
        $guest = '';
        if (Yii::$app->user->isGuest){
            $guest = $cart->getGuest();
        }
		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				getParam('sandbox_clientId'),     // ClientID
				getParam('sandbox_clientSecret')      // ClientSecret
			)
		);
		$apiContext->setConfig(array(
			'mode' =>'live',
			'service.EndPoint' => getParam('sandbox_url'),
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => __DIR__ . '/../../PayPal.log',
			'log.LogLevel' => 'FINE',
		));
		if($shipping_cost != 0 || $shipping_cost != '0'){
			$shipping_address = new ShippingAddress();

			$shipping_address->setCity($shipping['city']);
			$shipping_address->setCountryCode('US');
			$shipping_address->setPostalCode($shipping['zip']);
			$shipping_address->setLine1($shipping['address_line_1'].' '.$shipping['address_line_2']);
			$shipping_address->setState($shipping['state']);
			$shipping_address->setRecipientName($shipping['first_name'].' '.$shipping['last_name']);
        }
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		
		$items = [];
        if(isset($products['shop'])){
            foreach($products['shop'] as $shop){
				$item = new Item();
				$item->setName($shop->name)
					->setCurrency('USD')
					->setQuantity($shop->quantity)
					->setPrice(number_format($shop->unit_price,2));
                array_push($items, $item);
            }
        }

        if(isset($products['drop'])){
            foreach($products['drop'] as $drop){
				$item = new Item();
				$item->setName($drop->title)
					->setCurrency('USD')
					->setQuantity($drop->quantity)
					->setPrice(number_format($drop->price,2));
                array_push($items, $item);
            }
        }
		$item = new Item();
		$item->setName('Discount')
			->setCurrency('USD')
			->setQuantity(1)
			->setPrice('-'.$offerAmount);
		
		array_push($items, $item);
		
		$itemList = new ItemList();
		$itemList->setItems($items);
		if($shipping_cost != 0 || $shipping_cost != '0'){
			$itemList->setShippingAddress($shipping_address);
		}
		/*$item = [];
        $item['name'] = 'Discount';
        $item['price'] = '-'.$offerAmount;
        $item['currency'] = 'USD';
        $item['quantity'] = '1';
        array_push($items, $item);

        $items = json_encode($items);*/
		$details = new Details();
		$details->setShipping($shipping_cost)
			->setTax(0)
			->setSubtotal($totalWithOffer);
		
		$amount = new Amount();
		$amount->setCurrency("USD")
				->setTotal(number_format($sub_total,2))
				->setDetails($details);
		
		$transaction = new Transaction();
		$transaction->setAmount($amount)
					->setItemList($itemList)
					->setDescription("Payment description")
					->setInvoiceNumber(uniqid());
		
		$baseUrl = domainUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl("$baseUrl/cart/transact?success=true")
					->setCancelUrl("$baseUrl/cart/transact?success=false");
		
		$payment = new Payment();
		$payment->setIntent("order")
				->setPayer($payer)
				->setRedirectUrls($redirectUrls)
				->setTransactions(array($transaction));
		$request = clone $payment;
		try {
			$payment->create($apiContext);
		}  catch (\PayPal\Exception\PayPalConnectionException $ex){
			echo 'Exception: ' . $ex->getMessage() . PHP_EOL;
			$err_data = json_decode($ex->getData(), true);
			echo '<pre>';
			print_r($err_data);
			//echo $err_data;
			echo '</pre>';
			echo $ex->getMessage();
			echo $ex->getCode();
			echo $ex->getData();
			exit(1);
		}
		$approvalUrl = $payment->getApprovalLink();
		return $this->render('payment', ['addresses' => $addresses, 'offer' => $offer, 'totalWithOffer' => $totalWithOffer, 'model' => $model, 'add_model' => $add_model, 'cart' => $cart->getCart(), 'total' => $total, 'billing' => $billing, 'shipping' => $shipping, 'shipping_cost' => $shipping_cost, 'sub_total' => $sub_total, 'approvalUrl' => $approvalUrl, 'guest' => $guest]);
    }

    public function actionTransact($success) {
		if($success == 'false'){
			return $this->render('error');
		} else if ($success == 'true'){
			$cart = new Cart();
			if ($cart->getCart() == NULL) {
				return $this->redirect(['/cart']);
			}
			
			$data = Yii::$app->request->post();
			$products = $cart->getCart();
			$total = $cart->getTotal();
			$totalWithOffer = $cart->getTotalWithOffer();
			$offer = $cart->getOffer();
			$payment_details  = [];
			$is_guest = 0;
			$billing = null;
			$ship_add = null;
			$shipping = null;
			$order_id = null;
			$status = 'failed';
			$method = 'paypal';
			$is_paid = 0;
			
			$offerAmount = $cart->getOfferAmount();
			$sub_total = $cart->getSubTotal();
			$shipping_cost = $cart->getShippingCost();
			
			$apiContext = new \PayPal\Rest\ApiContext(
				new \PayPal\Auth\OAuthTokenCredential(
					getParam('sandbox_clientId'),     // ClientID
					getParam('sandbox_clientSecret')      // ClientSecret
				)
			);
			
			$apiContext->setConfig(array(
				'mode' =>'live',
				'service.EndPoint' => getParam('sandbox_url'),
				'http.ConnectionTimeOut' => 30,
				'log.LogEnabled' => true,
				'log.FileName' => __DIR__ . '/../../PayPal-Execution.log',
				'log.LogLevel' => 'FINE',
			));
			
			$paymentId = $_GET['paymentId'];
			$payment_details['payment_id'] = $paymentId;
			$payment = Payment::get($paymentId, $apiContext);
			
			$execution = new PaymentExecution();
			$execution->setPayerId($_GET['PayerID']);
			
			$payment_details['payer_id'] = $_GET['PayerID'];
			$payment_details['token'] = $_GET['token'];
			
			$transaction = new Transaction();
			$amount = new Amount();
			$details = new Details();
			$details->setShipping($shipping_cost)
				->setTax(0)
				->setSubtotal($totalWithOffer);
			$amount->setCurrency('USD');
			$amount->setTotal($sub_total);
			$amount->setDetails($details);
			$transaction->setAmount($amount);
			// Add the above transaction object inside our Execution object.
			$execution->addTransaction($transaction);
			try {
				$result = $payment->execute($execution, $apiContext);
				$authorizationId = $result->transactions[0]->related_resources[0]->order->id;
				$status = 'success';
				$is_paid = 1;
				try {
				    $authorization = Authorization::get($authorizationId, $apiContext);
					$amt = new Amount();
					$amt->setCurrency("USD")
						->setTotal($sub_total);
				    $capture = new Capture();
				    $capture->setAmount($amt);

				    $getCapture = $authorization->capture($capture, $apiContext);
				} catch (\PayPal\Exception\PayPalConnectionException $ex) {
					pre($ex, true);
				    //return $this->render('error');
				    exit(1);
				}
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				return $this->render('error');
				exit(1);
			}
			$transactions = $payment->getTransactions();
			$transaction = $transactions[0];
			$relatedResources = $transaction->getRelatedResources();
			$relatedResource = $relatedResources[0];
			$order = $relatedResource->getOrder();
			
			try {
				$result = Order::get($order->getId(), $apiContext);
				$order_id = $result->getId();
			} catch (\PayPal\Exception\PayPalConnectionException $ex) {
				return $this->render('error');
				exit(1);
			}
			
			if ($cart->isGuest() === 1){
				$is_guest = 1;
				$email = $cart->getGuest();
				$guest = Guests::find()->where(['email' => $email])->one();
				if($guest === null){
					$addGuest = new Guests;
					$addGuest->email = $email;
					$addGuest->save(false);
					$user = $addGuest->id;
				} else {
					$user = $guest->id;
				}
			} else {
				$user = Yii::$app->user->id;
			}
			$bill_add = $cart->billingAddress();
			$ship_add = $cart->shippingAddress();
			if(Yii::$app->user->id){
				$billing = Address::findOne(['user' => $user,'address_type' => 'billing','first_name' => $bill_add['first_name'],'last_name' => $bill_add['last_name'],'address_line_1' => $bill_add['address_line_1'],'address_line_2' => $bill_add['address_line_2'],'city' => $bill_add['city'],'state' => $bill_add['state'],'zip' => $bill_add['zip'],'contact' => $bill_add['contact']]);
			}
			$bill_id = '';
			if($billing === null){
				$model = new Address;
				$model->user = $user;
				$model->created_by = $user;
				$model->modified_by = $user;
				$model->first_name = $bill_add['first_name'];
				$model->last_name = $bill_add['last_name'];
				$model->address_line_1 = $bill_add['address_line_1'];
				$model->address_line_2 = $bill_add['address_line_2'];
				$model->city = $bill_add['city'];
				$model->state = $bill_add['state'];
				$model->country = 'USA';
				$model->zip = $bill_add['zip'];
				$model->contact = $bill_add['contact'];
				$model->is_default = 1;
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
				if(Yii::$app->user->id){
					$shipping = Address::findOne(['user' => $user,'address_type' => 'shipping','first_name' => $ship_add['first_name'],'last_name' => $ship_add['last_name'],'address_line_1' => $ship_add['address_line_1'],'address_line_2' => $ship_add['address_line_2'],'city' => $ship_add['city'],'state' => $ship_add['state'],'zip' => $ship_add['zip'],'contact' => $ship_add['contact']]);
				}
				if($shipping === null){
					$sh_model = new Address;
					$sh_model->user = $user;
					$sh_model->created_by = $user;
					$sh_model->modified_by = $user;
					$sh_model->first_name = $ship_add['first_name'];
					$sh_model->last_name = $ship_add['last_name'];
					$sh_model->address_line_1 = $ship_add['address_line_1'];
					$sh_model->address_line_2 = $ship_add['address_line_2'];
					$sh_model->city = $ship_add['city'];
					$sh_model->state = $ship_add['state'];
					$sh_model->country = 'USA';
					$sh_model->zip = $ship_add['zip'];
					$sh_model->contact = $ship_add['contact'];
					$sh_model->is_default = 1;
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
			$order->is_guest = $is_guest;
			$order->created_by = $user;
			$order->modified_by = $user;
			$order->customer = $user;
			$order->order_number = getOrderNum();
			$order->paypal_order_id = $order_id;
			$order->order_amount = $totalWithOffer;
			$order->payment_method = $method;
			$order->transaction_id = $paymentId;
			$order->order_date = date("Y-m-d H:i:s");
			$order->is_paid = $is_paid;
			$order->is_shipped = 0;
			$order->freight = 0;
			$order->shipping_address = $ship_id;
			$order->billing_address = $bill_id;
			$order->payment_status = $status;
			$order->payment_details = json_encode($payment_details);
			$order->printful_synced = 0;
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
					$detail->quantity_details = serialize($info->var_qnty);
					$detail->created_by = $user;
					$detail->modified_by = $user;
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
					$detail->djlogo = $info->logo;
					$detail->save(false);
				}
			}
		
			$pf = new PrintfulApiClient('ciac7wnf-7cvl-wa20:io6q-8d0qfxlnvf42');
			$request = [];
			$request['recipient']  = ['address1' => $ship_add['address_line_1'] .' '. $ship_add['address_line_2'],'city' => $ship_add['city'],'country_code' => 'US', 'state_code' => $ship_add['state'], 'zip' => $ship_add['zip']];
			$products = $cart->getCart();
			$items = [];
			if(isset($products['shop'])){
				foreach($products['shop'] as $shop){
					$item = [];
					// $url = Url::base(true);
					// $img = str_replace('/assets', $url.'/assets', $shop->main_image);
					$url = 'https://www.8thwonderpromos.com';
					$img = str_replace('../assets', $url.'/assets', $shop->main_image);
					foreach($shop->var_qnty as $key => $val){
						foreach($val as $k => $v){
							$p = PrintfulProductDetails::find()->where(['and', "printful_product = '".$shop->printful_product."'","color = '".$key."'", "size = '".$k."'"])->one();
							$pp = ProductSyncData::find()->where(['and', "product = '".$shop->id."'","variant = '".$p->id."'"])->one();
							$item['quantity'] = $v;
							$item['external_variant_id'] = $pp->external_id;
							array_push($items, $item);
						}
					}
				}
			}
		
			$request['items'] = $items;
			try {
				// Calculate shipping rates for an order
				$response = $pf->post('orders?confirm=1', $request);
				$odr = Orders::findOne($order->id);
				$odr->printful_synced = 1;
				$odr->printful_order = $response['id'];
				$odr->save(false);
			} catch (PrintfulApiException $e) { //API response status code was not successful
				echo 'Printful API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
			} catch (PrintfulException $e) { //API call failed
				echo 'Printful Exception: ' . $e->getMessage();
				var_export($pf->getLastResponseRaw());
			}
			return $this->redirect(['/cart/success?order='.$order->order_number]);
		}
    }

    public function actionSuccess($order) {
        $order = Orders::findOne(['order_number' => $order]);
        $detail = OrderDetails::findAll(['order' => $order->id]);
        $shipping_address = Address::findOne(['address_type' => 'shipping', 'id' => $order->shipping_address]);
        $billing_address = Address::findOne(['address_type' => 'billing', 'id' => $order->billing_address]);

        $body = $this->renderPartial('_success', ['order' => $order, 'detail' => $detail, 'shipping' => $shipping_address, 'billing' => $billing_address]);
        $guest = '';
        $user = '';
        $u = new Users;
        $adminEmail = Yii::$app->params['adminEmail'];
        if($order->is_guest){
            $guest = Guests::findOne($order->customer);
            $u->sendEmail($adminEmail, $adminEmail, $body, '8thwonderpromos', $guest->email, $body, $user->first_name . ' ' . $user->last_name);
        } else {
            $user = Users::findOne(Yii::$app->user->id);    
            $u->sendEmail($adminEmail, $adminEmail, $body, '8thwonderpromos', $user->email, $body, $user->first_name . ' ' . $user->last_name);
        }
        
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
                    $size = $data['size'];
					$color = $data['color'];
                    $info->size = $size;
					$info->colors = $color;
                    $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                    $cart = new Cart();
					$qty = $cart->addToCart($info, $type, $quantity);
                    $total = $cart->getTotal();
                    $total_qty = $cart->getTotalQuantity();
                    $p['slug'] = $info->slug;
                    $p['msg'] = 'Added';
                    $p['name'] = $info->name;
                    $p['price'] = $info->unit_price;
                    $p['main_image'] = $img;
                    $p['qty'] = $qty;
                    $p['size'] = $size;
					$p['color'] = $color;
                    $p['total'] = $total;
                    $p['quantity'] = $total_qty;
                    $p['items'] = $cart->getItemCount();
                    echo json_encode($p);
                }
            }
        } else {
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
                        $info->thumbnail = 'https://img.youtube.com/vi/'.getUtubeId($info->youtube).'/hqdefault.jpg';    
                    } else {
                        $info->thumbnail = Yii::$app->homeUrl.'images/audio-drop.png';   
                    }
                    $cart = new Cart();
                    if(!$cart->getItemInCart($info->slug, $type)){
                        $qty = $cart->addToCart($info, $type, $quantity);
                        $return_url = Yii::$app->request->referrer;
                    } else {
                        $return_url = Yii::$app->request->referrer;
                    }
                }
            } else {
                $info = Products::findOne(['slug' => $product]);
				if ($info !== null) {
                    $size = $data['size'];
					$color = $data['color'];
                    $info->size = $size;
					$info->colors = $color;
                    $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                    $cart = new Cart();
					$qty = $cart->addToCart($info, $type, $quantity);
                }
				$return_url = Yii::$app->request->referrer;
            }
			
			if($return_url != NULL) {
				return $this->redirect($return_url);
			} else {
				return $this->goBack();
			}
		}
    }
	
	public function actionDroptocart(){
		$data = Yii::$app->request->post();
		$product = $data['product'];
		$quantity = $data['quantity'];
		$type = $data['type'];
		$desc = $data['description'];
		$info = Drops::findOne(['slug' => $product]);
		if ($info !== null) {
			$info->desc = $desc;
			if($info->type == 'video' && $info->youtube != ''){
				$p['main_image'] = 'https://img.youtube.com/vi/'.getUtubeId($info->youtube).'/hqdefault.jpg';    
				$destination_path = 'images/djlogo/';
				$result = 0;				 
				if($_FILES['logo']['error'] == 0){
					$arr = explode('.', $_FILES['logo']['name']);
					$extension = end($arr);
					$filePath = 'assets/uploads/djlogo/' . create_guid() . '.' . $extension;
					if(move_uploaded_file($_FILES['logo']['tmp_name'],$filePath)){
						$info->logo = $filePath;
					}
				}
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
				return $this->redirect(['/djdrops/details?drop='.$product.'&cart=added']);
			} else {
				return $this->redirect(['/djdrops/details?drop='.$product.'&cart=present']);
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
                if($type == 'drop'){
                    $desc = $prod['desc'];
                    $info = Drops::findOne(['slug' => $product]);
                    if ($info !== null) {
                        $cart = new Cart();
                        $info->desc = $desc;
                        $qty = $cart->updateVariantCart($info, $type, $quantity);
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
						$size = $prod['size'];
						$color = $prod['color'];
						$info->size = $size;
						$info->colors = $color;
                        $img = str_replace('../', Yii::$app->homeUrl, $info->main_image);
                        $cart = new Cart();
                        $qty = $cart->updateVariantCart($info, $type, $quantity);
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
					$size = $data['size'];
					$color = $data['color'];
					$info->size = $size;
					$info->colors = $color;
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
            $response['total'] = $total;
            $response['quantity'] = $total_qty;
            $response['items'] = $cart->getItemCount();
            echo json_encode($response);
        }
    }

}
