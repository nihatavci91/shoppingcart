<?php

namespace App\Services;

use App\Business\CartManager;
use Config;
use Illuminate\Support\Facades\Session;
use Iyzipay\Request;

class PaymentService  {

    private $config;

    public function __construct()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZICO_API_KEY'));
        $options->setSecretKey(env('IYZICO_SECRET_KEY'));
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        $this->config = $options;
    }

    public function start($data)
    {
        $cart = (new RedisCartService())->getCart();
        $coupon = \session()->has('coupon') ? \session('coupon')['discount'] : 0;

        $expiration = str_split($data['cc-expiration'],2);
        $expiration_year = '20'. + $expiration[1];
        $expiration_month = $expiration[0];
        $ccname = $data['cc-name'];
        $ccnumber = $data['cc-number'];
        $price = 0;
        $cvv = $data['cc-cvv'];

        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setInstallment(1);
        $request->setBasketId("B67832");
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl("http://localhost/checkout/success?user_id=".auth()->id());
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($ccname);
        $paymentCard->setCardNumber($ccnumber);
        $paymentCard->setExpireMonth($expiration_month);
        $paymentCard->setExpireYear($expiration_year);
        $paymentCard->setCvc($cvv);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        foreach ($cart as $key => $item) {
            if ($item['quantity'] > 1) {
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $basketItem = new  \Iyzipay\Model\BasketItem();
                    $basketItem->setId($item['productId']);
                    $basketItem->setName($item['title']);
                    $basketItem->setCategory1("Collection");
                    $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                    $newPrice = $this->calculatePrice($item['price'],$coupon);
                    $basketItem->setPrice((float)$newPrice);
                    $price+= $newPrice;
                    $basketItems[] = $basketItem;
                }
            } else {
                $basketItem = new \Iyzipay\Model\BasketItem();
                $basketItem->setId($item['productId']);
                $basketItem->setName($item['title']);
                $basketItem->setCategory1("Collection");
                $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $newPrice = $this->calculatePrice($item['price'],$coupon);
                $basketItem->setPrice((float)$newPrice);
                $price+= $newPrice;
                $basketItems[] = $basketItem;
            }
        }

        $request->setBasketItems($basketItems);
        $request->setPrice($price);
        $request->setPaidPrice((float)$price);


        $threedsInitialize = \Iyzipay\Model\ThreedsInitialize::create($request,$this->config);

        return $threedsInitialize;
    }

    public function calculatePrice($price, $discountPercent)
    {
        $discount = $price * ($discountPercent / 100);
        return $price - $discount;

    }
}
