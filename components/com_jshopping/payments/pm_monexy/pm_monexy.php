<?php
defined('_JEXEC') or die('Restricted access');

class pm_monexy extends PaymentRoot
{
	function showAdminFormParams($params){
	  $array_params = array('monexy_merchant_id', 'monexy_secret_key', 'monexy_check_hash','monexy_validity_time',  'transaction_end_status', 'transaction_pending_status', 'transaction_failed_status');
	  foreach ($array_params as $key)
	  	{
		if (!isset($params[$key]))
			{		
				$params[$key] = '';
				if($key = 'monexy_validity_time') $params[$key]='140';
			}
		}
	  $orders = &JModel::getInstance('orders', 'JshoppingModel'); 
    include(dirname(__FILE__)."/adminparamsform.php");	  
	}

    function showPaymentForm($params, $pmconfigs){
        include(dirname(__FILE__)."/paymentform.php");
    }

	function checkTransaction($pmconfigs, $order, $act){
    return array(1, '');     
	}
  function nofityFinish($pmconfigs, $order, $act)
  {
    include(dirname(__FILE__)."/monexy_notify.php");
  }
	function showEndForm($pmconfigs, $order)
	{
		$amount = $this->fixOrderTotal($order);
		$currency = $order->currency_code_iso;
		if ($currency == 'RUR')
		  $currency = 'RUB';
		$desc = sprintf(_JSHOP_PAYMENT_NUMBER, $order->order_number);
		
		$result_url = JURI::root() . "index.php?option=com_jshopping&amp;controller=checkout&amp;task=step7&amp;act=notify&amp;js_paymentclass=pm_monexy&amp;no_lang=1&amp;order_id=".$order->order_id;
		$success_url = JURI::root(). "index.php?option=com_jshopping&amp;controller=checkout&amp;task=step7&amp;act=return&amp;js_paymentclass=pm_monexy";
		$fail_url = JURI::root() . "index.php?option=com_jshopping&amp;controller=checkout&amp;task=step7&amp;act=cancel&amp;js_paymentclass=pm_monexy";

		$params = array();
        $params["myMonexyMerchantID"] = $pmconfigs['monexy_merchant_id'];
        $params["myMonexyMerchantExpTime"] = $pmconfigs['monexy_validity_time'];
        $params["myMonexyMerchantShopName"] = $pmconfigs['monexy_shop_name'];
        $params["myMonexyMerchantSum"] = $amount;
        $params["myMonexyMerchantCurrency"] = $currency;
        $params["myMonexyMerchantOrderId"] = $order->order_id;
        $params["myMonexyMerchantOrderDesc"] = $desc;
        $params["myMonexyMerchantResultUrl"] = $result_url;
        $params["myMonexyMerchantSuccessUrl"] = $success_url;
        $params["myMonexyMerchantFailUrl"] = $fail_url;


        ksort($params);
        $req_str = '';
        foreach ($params AS $pkey => $pval)
            $req_str.=($pkey . '=' . $pval);


        // Add a secret key to the request string if needed.
        if ($pmconfigs['monexy_check_hash'] == '1') {
            $req_str .= $pmconfigs['monexy_secret_key'];
        }
        $myMonexyMerchantHash = md5($req_str);

		
        $html .= '<form id="paymentform" method="POST" action="https://www.monexy.ua/merchant/merchant.php">';
        $html .= '<input type="hidden" name="myMonexyMerchantCurrency" value="' . $currency . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantExpTime" value="' . $pmconfigs['monexy_validity_time']. '">';
        $html .= '<input type="hidden" name="myMonexyMerchantFailUrl" value="' . $fail_url . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantID" value="' . $pmconfigs['monexy_merchant_id']. '">';
        $html .= '<input type="hidden" name="myMonexyMerchantOrderDesc" value="' . $desc . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantOrderId" value="' . $order->order_id . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantResultUrl" value="' . $result_url . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantShopName" value="' . $pmconfigs['monexy_shop_name'] . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantSuccessUrl" value="' . $success_url . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantSum" value="' . $amount . '">';
        $html .= '<input type="hidden" name="myMonexyMerchantHash" value="' . $myMonexyMerchantHash . '">';
        $html .= '<input type="hidden" name="myMonexyPaymentSimple" value="0">';
       // $html .= '<input type="submit" value="Оплатить">';
        $html .= '</form>';
		echo($html);
		
	    print _JSHOP_REDIRECT_TO_PAYMENT_PAGE;
        echo('<script type="text/javascript">document.getElementById("paymentform").submit();</script>');

		die();
	}
	function getUrlParams($pmconfigs){
	  $params = array();
	  $params['order_id'] = JRequest::getInt("order_id");
	  $params['hash'] = "";
	  $params['checkHash'] = 0;
	  $params['checkReturnParams'] = $pmconfigs['checkdatareturn'];
	  return $params;
	}
	
	function fixOrderTotal($order){
        $total = $order->order_total;
        if ($order->currency_code_iso=='HUF'){
            $total = round($total);
        }else{
            $total = number_format($total, 2, '.', '');
        }
    return $total;
    }
}
?>