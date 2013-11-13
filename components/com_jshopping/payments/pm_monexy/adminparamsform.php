<?php defined('_JEXEC') or die(); ?>
<?php include(dirname(__FILE__)."/language.ru.php"); 
?>
<div class="col100">
<fieldset class="adminform">
<table class="admintable" width = "100%" >
  <tr>
		<td width="300"><strong><?=ADMIN_CFG_MONEXY_MERCHANT_ID?>:</strong></td>
		<td>
			<input type="text" name = "pm_params[monexy_merchant_id]" class="inputbox" value="<?=$params['monexy_merchant_id']?>" />
		</td>
		<td><?=ADMIN_CFG_MONEXY_MERCHANT_ID_DESCRIPTION?></td>
  </tr>
	<tr>
		<td><strong><?=ADMIN_CFG_MONEXY_SHOP_NAME?>:</strong></td>
		<td>
			<input type="text" name = "pm_params[monexy_shop_name]" class="inputbox" value="<?=$params['monexy_shop_name']?>" />
		</td>
	  <td><?=ADMIN_CFG_MONEXY_SHOP_NAME_DESCRIPTION?></td>
	</tr>
	<tr>
		<td><strong><?=ADMIN_CFG_MONEXY_CHECK_HASH?>:</strong></td>
		<td>
		
		 <?php              
		 print JHTML::_('select.booleanlist', 'pm_params[monexy_check_hash]', 'class = "inputbox" size = "1"', $params['monexy_check_hash']);
		 echo " ".JHTML::tooltip(ADMIN_CFG_MONEXY_CHECK_HASH_DESCRIPTION);
		 ?>
	  <td><?=ADMIN_CFG_MONEXY_CHECK_HASH_DESCRIPTION?></td>
	</tr>
	<tr>
		<td><strong><?=ADMIN_CFG_MONEXY_SECRET_KEY?>:</strong></td>
		<td>
			<input type="text" name = "pm_params[monexy_secret_key]" class="inputbox" value="<?=$params['monexy_secret_key']?>" />
		</td>
	  <td><?=ADMIN_CFG_MONEXY_SECRET_KEY_DESCRIPTION?></td>
	</tr>
	<tr>
		<td><strong><?=ADMIN_CFG_MONEXY_VALIDITY_TIME?>:</strong></td>
		<td>
			<input type="text" name = "pm_params[monexy_validity_time]" class="inputbox" value="<?=$params['monexy_validity_time']?>" />
		</td>
	  <td><?=ADMIN_CFG_MONEXY_VALIDITY_TIME_DESCRIPTION?></td>
	</tr>
  <tr>
    <td class="key"><strong><?php echo _JSHOP_TRANSACTION_END;?>:</strong></td>
    <td>
      <?php print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[monexy_transaction_end_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['monexy_transaction_end_status'] );?>
    </td>
  </tr>
  <tr>
    <td class="key"><strong><?php echo _JSHOP_TRANSACTION_PENDING;?>:</strong></td>
    <td>
      <?php echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[monexy_transaction_pending_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['monexy_transaction_pending_status']);?>
    </td>
  </tr>
  <tr>
    <td class="key"><strong><?php echo _JSHOP_TRANSACTION_FAILED;?>:</strong></td>
    <td>
      <?php echo JHTML::_('select.genericlist',$orders->getAllOrderStatus(), 'pm_params[monexy_transaction_failed_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['monexy_transaction_failed_status']);?>
   </td>
 </tr>
 
  <tr>
   <td class="key">
     <?php echo _JSHOP_SOFORTUEBERWEISUNG_RETURN_URL;?>
   </td>
   <td>
     <?php 
     print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_monexy";
     ?>
   </td>
 </tr>
 <tr>
   <td class="key">
     <?php echo _JSHOP_SOFORTUEBERWEISUNG_NOTIFI_URL;?>
   </td>
   <td>
     <?php 
     print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_monexy&no_lang=1";
     ?>
   </td>
 </tr>         
 <tr>
   <td class="key">
     <?php echo _JSHOP_SOFORTUEBERWEISUNG_CANCEL_URL;?>
   </td>
   <td>
     <?php 
     print JURI::root(). "index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_monexy";
     ?>
   </td>
 </tr>
 
</table>
</fieldset>
</div>
<div class="clr"></div>