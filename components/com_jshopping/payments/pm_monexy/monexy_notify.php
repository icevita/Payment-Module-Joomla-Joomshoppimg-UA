<? 	
error_reporting (0);
$pm_method = &JTable::getInstance('paymentMethod', 'jshop');
  
  
	function fixOrderTotal($order){
        $total = $order->order_total;
        if ($order->currency_code_iso=='HUF'){
            $total = round($total);
        }else{
            $total = number_format($total, 2, '.', '');
        }
    return $total;
    }

if (isset($_REQUEST['MerchantHash']))
{
  define('_JEXEC', 1);
	define('DS', DIRECTORY_SEPARATOR);
	$option='com_jshopping';
	$my_path = dirname(__FILE__);
	$my_path = explode(DS.'components',$my_path);	
	$my_path = $my_path[0];			
	if (file_exists($my_path . '/defines.php'))
		include_once $my_path . '/defines.php';

	if (!defined('_JDEFINES'))
	{
		define('JPATH_BASE', $my_path);
	  require_once JPATH_BASE.'/includes/defines.php';
  }
	
  define('JPATH_COMPONENT',				JPATH_BASE . '/components/' . $option);
	define('JPATH_COMPONENT_SITE',			JPATH_SITE . '/components/' . $option);
	define('JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR . '/components/' . $option);
	
	require_once JPATH_BASE.'/includes/framework.php';
	$app = JFactory::getApplication('site');
	$app->initialise();
	
	JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
	jimport('joomla.application.component.model'); 
	JModel::addIncludePath(JPATH_COMPONENT.DS.'models');
	
	require_once (JPATH_COMPONENT_SITE."/lib/factory.php");
	require_once (JPATH_COMPONENT_SITE.'/lib/functions.php');
	include_once(JPATH_COMPONENT_SITE."/controllers/checkout.php");

  $error = '';

    $order = &JTable::getInstance('order', 'jshop');
    $order->load($_REQUEST["OrderId"]);

    if ($order->order_id)
    {
      $pm_method = &JTable::getInstance('paymentMethod', 'jshop');
      $pm_method->load($order->payment_method_id);
      $pmconfigs = $pm_method->getConfigs();

      if ($order->order_status == $pmconfigs['monexy_transaction_pending_status'])
      {
        	$currency = $order->currency_code_iso;
        	if ($currency == 'RUR')
        	  $currency = 'RUB';
        	

// сбор хеша по пост данным для проверки $_REQUEST["MerchantHash"]
            $dataM = array(
                'MerchantId' => $_REQUEST["MerchantId"], // номер мерчанта в системе Манекси
                'PaymentId' => $_REQUEST["PaymentId"], // номер платежа в системе Манекси
                'OrderId' => $_REQUEST["OrderId"], // номер заказа, который был передан Торговцем
                'Amount' => $_REQUEST["Amount"], // сумма заказа
                'Currency' => $_REQUEST["Currency"], // валюта заказа
                'Success' => $_REQUEST["Success"], // успешность проведения платежа
                'Type' => $_REQUEST["Type"], // идентификатор способа платежа
                'TypeName' => $_REQUEST["TypeName"]//описание выбранного способа оплаты
            );
            ksort($dataM); //сортировка данных массива по ключу
            $req_str3 = ''; // первоначальное значение строки данных для подписи
            foreach ($dataM AS $pkey => $pval)
                $req_str3.=($pkey . '=' . $pval);
            if ($pmconfigs['monexy_check_hash']) {
                $req_str3 .= $pmconfigs['monexy_secret_key'];
            }


            $ServerHashM = md5($req_str3);

// сборка хеша по пост данным для проверки полей от подмены
            $datas = array();
            $datas["MerchantId"] = $_REQUEST["MerchantId"]; // номер мерчанта в системе Манекси
            $datas["OrderId"] = $_REQUEST["OrderId"]; // номер заказа, который был передан Торговцем
            $datas["Amount"] = $_REQUEST["Amount"] * 100; // сумма заказа
            $datas["Currency"] = $_REQUEST["Currency"]; // валюта заказа
            $datas["Success"] = $_REQUEST["Success"]; // успешность проведения платежа
            ksort($datas); //сортировка данных массива по ключу
            $req_str1 = ''; // первоначальное значение строки данных для подписи
            foreach ($datas AS $pkey => $pval)
                $req_str1.=($pkey . '=' . $pval);
            if ($pmconfigs['monexy_check_hash']) {
                $req_str1 .= $pmconfigs['monexy_secret_key'];
            }


            $ServerHash2 = md5($req_str1);



//соборка провеочного хеша для проверки полей от подмены и упешного статуса (Success = 1)
            $datasC = array();
            $datasC["MerchantId"] = $pmconfigs['monexy_merchant_id']; // номер мерчанта в системе Манекси
            $datasC["OrderId"] = $order->order_id; // номер заказа, который был передан Торговцем
            $datasC["Amount"] = fixOrderTotal($order)* 100; // сумма заказа
            $datasC["Currency"] = $currency; // валюта заказа
            $datasC["Success"] = "1"; // успешность проведения платежа
            ksort($datasC); //сортировка данных массива по ключу
            $req_str2 = ''; // первоначальное значение строки данных для подписи
            foreach ($datasC AS $pkey => $pval)
                $req_str2.=($pkey . '=' . $pval);
            if ($pmconfigs['monexy_check_hash']) {
                $req_str2 .= $pmconfigs['monexy_secret_key'];
            }

            $CheckHash = md5($req_str2);

            if (strpos($CheckHash, $ServerHash2) !== false) {
                if (strpos($_REQUEST["MerchantHash"], $ServerHashM) !== false) {

				
					$status = $pmconfigs['monexy_transaction_failed_status'];
					if ($_REQUEST["Success"] == '1')
					  $status = $pmconfigs['monexy_transaction_end_status'];
					
					if ($status && !$order->order_created)
					{
					  $order->order_created = 1;
					  $order->order_status = $status;
					  $order->store();
					  $pay_class = new JshoppingControllerCheckout();
					  $pay_class->_sendOrderEmail($order->order_id);
					  $order->changeProductQTYinStock("-");
					  $pay_class->_changeStatusOrder($order->order_id, $status, 0);
					  $rtrn = true;
					}
					
					if ($status && $order->order_status != $status)
					{
					  $this->_changeStatusOrder($order_id, $status, 1);
					  $rtrn=true;
					}

                }
                else
                    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>Security check failed</err_msg></response>";
            }
            else
                echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>Fields check failed</err_msg></response>";
				

    	}
    	else
    	  $error = 'Payment is not expected';
  	}
  	else
  	  $error = 'Unknown order_id';

	if ($error == '')
	  $ret = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>yes</status><err_msg></err_msg></response>";
	else
	  $ret = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>$error</err_msg></response>";
	
  die($ret);	
}
?>
