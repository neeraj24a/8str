<?php

namespace frontend\config;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;

/**
 * Description of Cart
 *
 * @author SONY
 */
class Cart {
    public $session = '';
    
    public function __construct() {
        $this->session = Yii::$app->getSession();
        $this->session->open();
        if (!isset($this->session['cart'])) {
            $this->session['cart'] = [];
        }
    }
	
    public function isGuest(){
        $cart = $this->session->get('cart');
        if(isset($cart['is_guest']){
		return $cart['is_guest'];
	} else {
		$cart['is_guest'] = 0;
        	$this->session->set('cart', $cart);
		return 0;
	}
    }

    public function setGuest($email){
        $cart = $this->session->get('cart');
        $cart['guest_email'] = $email;
	$cart['is_guest'] = 1;
        $this->session->set('cart', $cart);
    }

    public function getGuest(){
        $cart = $this->session->get('cart');
        return $cart['guest_email'];

    }

    public function getCart() {
//        $this->session = Yii::$app->session;
        return $cart = $this->session->get('cart');
    }

    public function addToCart($product, $type, $quantity = 1) {
//        $this->session = Yii::$app->session;
        $this->session->open();
        if (!isset($this->session['cart'])) {
            $this->session['cart'] = [];
        }
        $cart = $this->session->get('cart');
        if (isset($cart[$type][$product->slug])) {
			if($type == 'drop'){
				$cart[$type][$product->slug]->quantity = $cart[$type][$product->slug]->quantity + $quantity;
			} else {
				$cart[$type][$product->slug]->quantity = $cart[$type][$product->slug]->quantity + $quantity;
				$cart[$type][$product->slug]->var_qnty[$product->colors][$product->size] = $quantity;
			}
		} else {
			if($type == 'shop'){
				$cart[$type][$product->slug] = $product;
				$cart[$type][$product->slug]->quantity = $quantity;
				$cart[$type][$product->slug]->var_qnty = [];
				$cart[$type][$product->slug]->var_qnty[$product->colors] = [];
				$cart[$type][$product->slug]->var_qnty[$product->colors][$product->size] = $quantity;
			} else {
				$cart[$type][$product->slug] = $product;
				$cart[$type][$product->slug]->quantity = $quantity;
			}
        }
        $this->session->set('cart', $cart);
        return $cart[$type][$product->slug]->quantity;
    }
    
    public function updateVariantCart($product, $type, $quantity){
        $this->session->open();
        if($quantity == 0){
            $this->removeFromCart($product);
            return null;
        } else {
            if (!isset($this->session['cart'])) {
                $this->session['cart'][$type] = [];
            }
            $cart = $this->session->get('cart');
            if($type == 'drop'){
                $cart[$type][$product->slug]->desc = $product->desc;
				$cart[$type][$product->slug]->quantity = $quantity;
				$drop_qty = $cart['shop'][$product->slug]->quantity;
				return $drop_qty;
            } else {
		        $cart[$type][$product->slug]->var_qnty[$product->colors][$product->size] = $quantity;
			}
            $this->session->set('cart', $cart);
			$qty = $this->updateCart($product);
            return $qty;
        }
    }
	
	public function updateCart($product){
		$cart = $this->session->get('cart');
		if(isset($cart['shop'])){
			$cart['shop'][$product->slug]->quantity = 0;
			$prod = $cart['shop'][$product->slug];
			foreach($prod->var_qnty as $key => $val){
				foreach($val as $k => $v){
					$cart['shop'][$product->slug]->quantity = $cart['shop'][$product->slug]->quantity + $v;
				}
			}
		}
		$this->session->set('cart', $cart);
        return $cart['shop'][$product->slug]->quantity;
	}

    public function removeFromCart($product, $type) {
        $cart = $this->session->get('cart');
		if($type == 'shop'){
			$rmQty = $cart[$type][$product->slug]->var_qnty[$product->colors][$product->size];
		
			if ($rmQty == $cart[$type][$product->slug]->quantity){
				unset($cart[$type][$product->slug]);
			} else {
				unset($cart[$type][$product->slug]->var_qnty[$product->colors][$product->size]);
				if(sizeof($cart[$type][$product->slug]->var_qnty[$product->colors]) == 0){
					unset($cart[$type][$product->slug]->var_qnty[$product->colors]);
				}
				$cart[$type][$product->slug]->quantity = $cart[$type][$product->slug]->quantity - $rmQty;
			}
		} else {
			unset($cart[$type][$product->slug]);
		}
		$this->session->set('cart', $cart);
    }
    
    public function actionDecrease($product, $type, $quantity = 1) {
        $cart = $this->session->get('cart');
        if ($quantity == 0) {
            unset($cart[$type][$product->slug]);
        } else {
            $cart[$type][$product->slug]->quantity = $cart[$type][$product->slug]->quantity - $quantity;
        }
        $this->session->set('cart', $cart);
    }

    public function getTotal() {
//        $this->session = Yii::$app->session;
        $total = "00.00";
        $cart = $this->session->get('cart');
        if (isset($cart)) {
            if(isset($cart['shop'])){
                foreach ($cart['shop'] as $product) {
                    $total = $total + ($product->unit_price * $product->quantity);
                }
            }
            if(isset($cart['drop'])){
                foreach ($cart['drop'] as $product) {
                    $total = $total + ($product->price * $product->quantity);
                }
            }
        }
        return $total;
    }
	
	public function getSubTotal() {
		$total = $this->getTotalWithOffer();
		$ship_cost = $this->getShippingCost();
		return $total+$ship_cost;
	}

    public function getTotalWithOffer() {
        $total = "00.00";
        $offer = $this->getOffer();
        $cart = $this->session->get('cart');
        if (isset($cart)) {
            if(isset($cart['shop'])){
                foreach ($cart['shop'] as $product) {
                    $total = $total + ($product->unit_price * $product->quantity);
                }
            }
            if(isset($cart['drop'])){
                foreach ($cart['drop'] as $product) {
                    $total = $total + ($product->price * $product->quantity);
                }
            }
        }
        if($total != "00.00" && $offer != '0.00'){
            $total = $total - (($offer/100)*$total);
        }
        $total = number_format($total, 2, '.', '');
        return $total;
    }

    public function getTotalQuantity() {
//        $this->session = Yii::$app->session;
        $total = "0";
        $cart = $this->session->get('cart');
        if (isset($cart)) {
            if(isset($cart['shop'])){
                foreach ($cart['shop'] as $product) {
                    $total = $total + $product->quantity;
                }
            }
            if(isset($cart['drop'])){
                foreach ($cart['drop'] as $product) {
                    $total = $total + $product->quantity;
                }
            }
        }
        return $total;
    }
    
    public function getItemCount() {
        $total = "0";
        $cart = $this->session->get('cart');
        if (isset($cart)) {
            if(isset($cart['shop'])){
                foreach ($cart['shop'] as $product) {
                    $total = $total + 1;
                }
            }
            if(isset($cart['drop'])){
                foreach ($cart['drop'] as $product) {
                    $total = $total + 1;
                }
            }
        }
        return $total;
    }

    public function getItemInCart($product, $type){
        $cart = $this->session->get('cart');
        if(isset($cart[$type])){
            foreach($cart[$type] as $key => $val){
                if($product == $key){
                    return true;
                    break;
                }
            }
            return false;
        }
        return false;
    }

    public function getOffer(){
        $userOffer = $this->session->get('offer');
        $offer = '0.00';
        if(isset($userOffer)){
            $offers = getParam('offers');
            $offer = $offers[$userOffer];
        }
        return $offer;
    }

    public function getOfferAmount(){
        $total = $this->getTotal();
        $subTotal = $this->getTotalWithOffer();
        return number_format($total - $subTotal, 2);
    }

    public function setBillingAddress($add){
        $cart = $this->session->get('cart');
        $cart['billing'] = $add;
        $this->session->set('cart', $cart);
    }

    public function setShippingAddress($add){
        $cart = $this->session->get('cart');
        $cart['shipping'] = $add;
        $this->session->set('cart', $cart);
    }

    public function billingAddress(){
        $cart = $this->session->get('cart');
        if(isset($cart['billing'])){
            return $cart['billing'];
        } else {
            return null;
        }
    }

    public function shippingAddress(){
        $cart = $this->session->get('cart');
        if(isset($cart['shipping'])){
            return $cart['shipping'];
        } else {
            return null;
        }
    }
	
	public function setShippingCost($cost){
		$cart = $this->session->get('cart');
		$cart['shipping_cost'] = $cost;
		$this->session->set('cart', $cart);
	}
	
	public function getShippingCost(){
		$cart = $this->session->get('cart');
		return $cart['shipping_cost'];
	}
	
	public function resetCart(){
		$this->session['cart'] = [];
	}

}
