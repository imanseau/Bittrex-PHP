<?php
/**
 * Bittrex-PHP
 * A PHP API wrapper for Bittrex's API
 * 
 * Created by Ian Manseau
 * Donations Greatly Appreciated
 * Bitcoin:     3Hz1tsvPgfbkFowC91zmwi1ajnJaWzRu61
 * Litecoin:    MBVV27GzkayjoavX629go1pxMa2cVeUbpr
 * Ether:       0x47B40D2eDbEb33B19182709fE20DdcCCB0c18622
 * 
 * Bittrex-PHP is an API wrapper to access data from Bittrex.com
 * within a PHP application.
 * Copyright (C) 2017  Ian Corbitt Manseau
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
 
class Bittrex {
    public $uri = 'https://bittrex.com/api/v1.1/';
    
    /**
     * Public Api Requests
     */
     
    function getmarkets() {
        /**
         * Used to get the open and available trading markets at Bittrex along 
         * with other meta data.
         */
        $this->path = 'public/getmarkets';
        $this->url = $this->uri . $this->path;
        return $this->get();
    }
    
    function getcurrencies() {
        /**
         * Used to get all supported currencies at Bittrex along with other meta 
         * data.
         */
        $this->path = 'public/getcurrencies';
        $this->url = $this->uri . $this->path;
        return $this->get();
    }
    
    function getticker($market) {
        /**
         * Used to get the current tick values for a market.
         * $market      required a string literal for the market (ex: BTC-LTC)
         */
        $this->query = array(
            'market'    =>  $market
            );
        $this->path = 'public/getticker';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        return $this->get();
    }
    
    function getmarketsummaries() {
        /**
         * Used to get the last 24 hour summary of all active exchanges
         */
        $this->path = 'public/getmarketsummaries';
        $this->url = $this->uri . $this->path;
        return $this->get();
    }
    
    function getmarketsummary($market) {
        /**
         * Used to get the last 24 hour summary of all active exchanges
         * $market      required a string literal for the market (ex: BTC-LTC)
         */
        $this->query = array(
            'market'    =>  $market
            );
        $this->path = 'public/getmarketsummary';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        return $this->get();
    }
    
    function getorderbook($market, $type) {
        /**
         * Used to get retrieve the orderbook for a given market
         * $market      required a string literal for the market (ex: BTC-LTC)
         * $type	    required buy, sell or both to identify the type of 
         *                  orderbook to return.
         */
        $this->query = array(
            'market'    =>  $market,
            'type'      =>  $type
            );
        $this->path = 'public/getorderbook';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        return $this->get();
    }
    
    function getmarkethistory($market) {
        /**
         * Used to retrieve the latest trades that have occured for a specific market.
         * $market      required a string literal for the market (ex: BTC-LTC)
         */
        $this->query = array(
            'market'    =>  $market
            );
        $this->path = 'public/getmarkethistory';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        return $this->get();
    }
    
    /**
     * Market API Requests
     */
    
    function buylimit($apikey,$apisecret,$market,$quantity,$rate) {
        /**
         * Used to place a buy order in a specific market. Use buylimit to place 
         * limit orders. Make sure you have the proper permissions set on your 
         * API keys for this call to work
         * $market      required a string literal for the market (ex: BTC-LTC)
         * $quantity	required the amount to purchase 
         * $rate	    required the rate at which to place the order.
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'market'    =>  $market,
            'quantity'  =>  $quantity,
            'rate'      =>  $rate,
            'nonce'     =>  time()
            );
        $this->path = 'market/buylimit';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function selllimit($apikey,$apisecret,$market,$quantity,$rate) {
        /**
         * Used to place an sell order in a specific market. Use selllimit to 
         * place limit orders. Make sure you have the proper permissions set on 
         * your API keys for this call to work
         * $market      required a string literal for the market (ex: BTC-LTC)
         * $quantity	required the amount to purchase 
         * $rate	    required the rate at which to place the order.
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'market'    =>  $market,
            'quantity'  =>  $quantity,
            'rate'      =>  $rate,
            'nonce'     =>  time()
            );
        $this->path = 'market/selllimit';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function cancel($apikey,$apisecret,$uuid) {
        /**
         * Used to cancel a buy or sell order.
         * $uuid        required uuid of buy or sell order
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'uuid'      =>  $uuid,
            'nonce'     =>  time()
            );
        $this->path = 'market/cancel';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getopenorders($apikey,$apisecret,$market = NULL) {
        /**
         * Get all orders that you currently have opened.
         * market	optional	a string literal for the market (ie. BTC-LTC)
         */
        if (!empty($market)) {
            $this->query = array(
                'apikey'    =>  $apikey,
                'market'    =>  $market,
                'nonce'     =>  time()
                );
        } else {
            $this->query = array(
                'apikey'    =>  $apikey,
                'nonce'     =>  time()
                );
        }
        $this->path = 'market/getopenorders';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    /**
     * Account API Requests
     */
    
    function getbalances($apikey,$apisecret) {
        /**
         * Used to retrieve all balances from your account
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'nonce'     =>  time()
            );
        $this->path = 'account/getbalances';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getbalance($apikey,$apisecret,$currency) {
        /**
         * Used to retrieve the balance from your account for a specific currency.
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'currency'  =>  $currency,
            'nonce'     =>  time()
            );
        $this->path = 'account/getbalance';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getdepositaddress($apikey,$apisecret,$currency) {
        /**
         * Used to retrieve or generate an address for a specific currency. If 
         * one does not exist, the call will fail and return ADDRESS_GENERATING 
         * until one is available.
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'currency'  =>  $currency,
            'nonce'     =>  time()
            );
        $this->path = 'account/getdepositaddress';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function withdraw($apikey,$apisecret,$currency,$quantity,$address,$paymentid = NULL) {
        /**
         * Used to withdraw funds from your account. note: please account for txfee.
         * currency	    required	a string literal for the currency (ie. BTC)
         * quantity	    required	the quantity of coins to withdraw
         * address	    required	the address where to send the funds.
         * paymentid	optional	used for CryptoNotes/BitShareX/Nxt optional field (memo/paymentid)
         */
        if (!empty($paymentid)) {
            $this->query = array(
                'apikey'    =>  $apikey,
                'currency'  =>  $currency,
                'quantity'  =>  $quantity,
                'address'   =>  $address,
                'paymentid' =>  $paymentid,
                'nonce'     =>  time()
                );    
        } else {
            $this->query = array(
            'apikey'    =>  $apikey,
            'currency'  =>  $currency,
            'quantity'  =>  $quantity,
            'address'   =>  $address,
            'nonce'     =>  time()
            );
        }
        $this->path = 'account/withdraw';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getorder($apikey,$apisecret,$uuid) {
        /**
         * Used to retrieve a single order by uuid.
         * uuid     required	the uuid of the buy or sell order
         */
        $this->query = array(
            'apikey'    =>  $apikey,
            'uuid'      =>  $uuid,
            'nonce'     =>  time()
            );
        $this->path = 'account/getorder';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getorderhistory($apikey,$apisecret,$market = NULL) {
        /**
         * Used to retrieve your order history.
         * market	optional	a string literal for the market (ie. BTC-LTC). 
         *                      If ommited, will return for all markets
         */
         if (!empty($market)) {
            $this->query = array(
                'apikey'    =>  $apikey,
                'market'    =>  $market,
                'nonce'     =>  time()
                );
         } else {
             $this->query = array(
                'apikey'    =>  $apikey,
                'nonce'     =>  time()
            );
         }
        
        $this->path = 'account/getorderhistory';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getwithdrawalhistory($apikey,$apisecret,$currency = NULL) {
        /**
         * Used to retrieve your withdrawal history.
         * currency	    optional	a string literal for the currecy (ie. BTC). 
         *                          If omitted, will return for all currencies
         */
         if (!empty($market)) {
            $this->query = array(
                'apikey'    =>  $apikey,
                'currency'  =>  $currency,
                'nonce'     =>  time()
                );
         } else {
             $this->query = array(
                'apikey'    =>  $apikey,
                'nonce'     =>  time()
            );
         }
        
        $this->path = 'account/getwithdrawalhistory';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function getdeposithistory($apikey,$apisecret,$currency = NULL) {
        /**
         * Used to retrieve your deposit history.
         * currency	    optional	a string literal for the currecy (ie. BTC). 
         *                          If omitted, will return for all currencies
         */
         if (!empty($market)) {
            $this->query = array(
                'apikey'    =>  $apikey,
                'currency'  =>  $currency,
                'nonce'     =>  time()
                );
         } else {
             $this->query = array(
                'apikey'    =>  $apikey,
                'nonce'     =>  time()
            );
         }
        
        $this->path = 'account/getdeposithistory';
        $this->url = $this->uri . $this->path . '?' . http_build_query($this->query);
        $this->sign = hash_hmac ('sha512', $this->url, $apisecret);
        return $this->get();
    }
    
    function get() {
        /**
         * Function to make the curl call to the API returns JSON data into an 
         * array
         */
        $cSession = curl_init();
        curl_setopt($cSession,CURLOPT_URL,$this->url);
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false);
        if (!empty($this->sign)) {
            curl_setopt($cSession,CURLOPT_HTTPHEADER, array('apisign: '. $this->sign));
        }
        $result=curl_exec($cSession);
        curl_close($cSession);
        $results = json_decode($result, true);
       
        return $results;
    }
}
?>
