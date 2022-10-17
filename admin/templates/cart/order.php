<h1 class="text-large uppercase border-bottom border-color-1"><span class="no-phone"><?php echo l10n('cart_order_no') ?>: </span><?php echo $order['id'] ?></h1>
<!--_________________________
	
	Invoice and shipping data
	_________________________
-->
	<table class="div-phone">
		
		<tbody class="div-phone">
		<tr class="div-phone">
			<td class="top no-margin div-phone">
				<table class="framed" style="<?php echo (count($orderArray['shipping']) === 0) ? "width: auto;" : "" ?>">
				<thead>
					<tr>
<?php if (count($orderArray['shipping']) === 0) : ?>
						<th colspan="2" class="border-bottom-2 border-mute fore-color-1"><?php echo l10n('cart_vat_address') . " / " . l10n('cart_shipping_address') ?></th>
<?php else: ?>
						<th colspan="2" class="border-bottom-2 border-mute fore-color-1"><?php echo l10n('cart_vat_address') ?></th>
<?php endif; ?>
					</tr>
				</thead>
				<tbody class="border-bottom border-mute-light">
				<?php foreach ($orderArray['invoice'] as $line): ?>
					<tr>
						<td class="border-left border-mute-light"><?php echo $line['label'] . ":" ?></td>
						<td class="border-right border-mute-light"><b><?php echo $line['value'] ?></b></td>
					</tr>
				<?php endforeach; ?>	
				</tbody>
				</table>
			</td>
			<?php if (count($orderArray['shipping']) > 0): ?>
			<td class="top no-margin div-phone">
				<div class="page-navbar"><?php echo l10n('cart_shipping_address') ?></div>
				<table>
				<tbody class="border-bottom border-mute-light">
				<?php foreach ($orderArray['shipping'] as $line): ?>
					<tr>
						<td class="border-left border-mute-light"><?php echo $line['label'] . ":" ?></td>
						<td class="border-right border-mute-light"><b><?php echo $line['value'] ?></b></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
				</table>
			</td>
			<?php endif; // End shipping table ?>
		</tr>
		</tbody>
	</table>
<!--_________________________
	
	Products data
	_________________________
-->
	<table class="no-phone framed">
		<thead>
			<tr class="page-navbar">
				<th class="border-bottom-2 border-mute fore-color-1"><span class="text-big"><?php echo l10n('cart_product_list') ?></span></th>
				<th class="border-bottom-2 border-mute fore-color-1"><?php echo l10n('cart_descr') ?></th>
				<th class="border-bottom-2 border-mute fore-color-1"><?php echo l10n('cart_price') ?></th>
				<th class="border-bottom-2 border-mute fore-color-1"><?php echo l10n('cart_qty') ?></th>
				<?php if ($order['vat_type'] != "none"): ?>
				<th class="border-bottom-2 border-mute fore-color-1 print-text-right"><?php echo l10n($order['vat_type'] == "excluded" ? 'cart_vat' : 'cart_vat_included') ?></th>
				<?php endif; ?>
				<th class="border-bottom-2 border-mute fore-color-1 print-text-right"><?php echo l10n('cart_subtot') ?></th>
			</tr>
		</thead>
		<tbody>
<?php $p = 0; foreach ($orderArray['products'] as $product): ?>
			<tr class="border-bottom border-mute-light <?php echo $p % 2 != 0 ? 'background-blue-light' : '' ?> ">
				<td class="border-left border-mute-light"><?php echo $product['name'] ?></td>
				<td><?php echo ($product['option'] != "" ? " - " . $product['option'] . ($product['suboption'] != "" ? " - " . $product['suboption'] : "") : "") ?></td>
				<td class="text-left"><?php echo Configuration::getCart()->toCurrency($product['price'] / $product['quantity'], ' ' . $order['currency']) ?></td>
				<td class="text-left"><?php echo $product['quantity'] ?></td>
				<?php if ($order['vat_type'] != "none"): ?>
				<td class="text-left print-text-right"><?php echo Configuration::getCart()->toCurrency($product['vat'], ' ' . $order['currency']) ?></td>
				<?php endif; ?>
				<td class="border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat_type'] == "excluded" ? $product['price'] : $product['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
<?php $p++; endforeach; ?>
<?php if ($order['shipping_name'] != "" || $order['shipping_price'] != 0): ?>
<!--_________________________
	
	Shipping data
	_________________________
-->
			<tr class="page-navbar">
				<th class="border-bottom-2 border-mute fore-color-1"><span class="text-big"><?php echo l10n('cart_shipping') ?></span></th>
				<th class="border-bottom-2 border-mute fore-color-1" colspan="3"></th>
				<?php if ($order['vat_type'] != "none"): ?>
				<th class="border-bottom-2 border-mute fore-color-1 print-text-right"><?php echo l10n($order['vat_type'] == "excluded" ? 'cart_vat' : 'cart_vat_included') ?></th>
				<?php endif; ?>
				<th class="border-bottom-2 border-mute fore-color-1 print-text-right"><?php echo l10n('cart_price') ?></th>
			</tr>
			<tr>
				<td class="border-left border-bottom border-mute-light" colspan="4"><?php echo $order['shipping_name'] ?></td>
				<?php if ($order['vat_type'] != "none"): ?>
				<td class="border-bottom border-mute-light text-left print-text-right"><?php echo Configuration::getCart()->toCurrency($order['shipping_vat'], ' ' . $order['currency']) ?></td>
				<?php endif; ?>
				<td class="border-right border-bottom border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat_type'] == "excluded" ? $order['shipping_price'] : $order['shipping_price_plus_vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
<?php endif; ?>
<?php if ($order['payment_name'] != "" || $order['payment_price'] != 0): ?>
<!--_________________________
	
	Payment data
	_________________________
-->
			<tr class="page-navbar">
				<th class="border-bottom-2 border-mute fore-color-1"><span class="text-big"><?php echo l10n('cart_payment') ?></span></th>
				<th class="border-bottom-2 border-mute fore-color-1" colspan="3"></th>
				<?php if ($order['vat_type'] != "none"): ?>
				<th class="border-bottom-2 border-mute fore-color-1 print-text-right"><?php echo l10n($order['vat_type'] == "excluded" ? 'cart_vat' : 'cart_vat_included') ?></th>
				<?php endif; ?>
				<th class="border-bottom-2 border-mute fore-color-1 print-text-right"><?php echo l10n('cart_price') ?></th>
			</tr>
			<tr>
				<td class="border-left border-bottom border-mute-light " colspan="4"><?php echo $order['payment_name'] ?></td>
				<?php if ($order['vat_type'] != "none"): ?>
				<td class="border-bottom border-mute-light text-left print-text-right"><?php echo Configuration::getCart()->toCurrency($order['payment_vat'], ' ' . $order['currency']) ?></td>
				<?php endif; ?>
				<td class="border-right border-bottom border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat_type'] == "excluded" ? $order['payment_price'] : $order['payment_price_plus_vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
<?php endif; ?>
<!-- Coupon Code -->
<?php if (isset($order['coupon']) && $order['coupon'] != ""): ?>
			<tr>
				<td colspan="4"></td>
				<td class="fore-color-1 text-left"><?php echo l10n('cart_coupon', "Coupon Code") ?></td>
				<td class="text-left print-text-right"><b><?php echo $order['coupon'] ?></b></td>
			</tr>
<?php endif; ?>
<!-- Total Amounts -->
			<tr>
				<td colspan="4"></td>
				<th colspan="<?php echo ($order['vat_type'] != 'none') ? '2' : '1' ?>" class="border-bottom-2 border-mute fore-color-1 page-navbar"><?php echo l10n('cart_total', 'Total') ?></th>
			</tr>
<?php switch($order['vat_type']) {
case "included": ?>
			<tr>
				<td colspan="4"></td>
				<td class="border-bottom border-left border-mute-light fore-color-1 text-left"><?php echo l10n('cart_total_vat') ?></td>
				<td class="border-bottom border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td class="border-bottom border-left border-mute-light fore-color-1 text-left"><?php echo l10n('cart_vat_included') ?></td>
				<td class="border-bottom border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
<?php
break;
case "excluded": ?>
			<tr>
				<td colspan="4"></td>
				<td class="border-bottom border-left border-mute-light fore-color-1 text-left"><?php echo l10n('cart_total') ?></td>
				<td class="border-bottom border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price'], ' ' . $order['currency']) ?></b></td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td class="border-bottom border-left border-mute-light fore-color-1 text-left"><?php echo l10n('cart_vat') ?></td>
				<td class="border-bottom border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td class="border-bottom border-left border-mute-light fore-color-1 text-left"><?php echo l10n('cart_total_vat') ?></td>
				<td class="border-bottom border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
<?php
break;
case "none":?>
			<tr>
				<td colspan="2"></td>
				<td class="border-bottom border-left border-mute-light fore-color-1 head"><?php echo l10n('cart_total') ?></td>
				<td class="border-bottom border-right border-mute-light text-left print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
			</tr>
<? break; ?>
<?php } ?>
		</tbody>
	</table>
	<!--_________________________
	
		Phone summary
		_________________________
	-->
	<table class="noprint no-tablet no-desktop">
		<tr>
			<th colspan="3" class="border-bottom-2 border-mute-light fore-color-1 text-center"><?php echo l10n('cart_product_list') ?></th>
		</tr>
<?php $p = 0; foreach ($orderArray['products'] as $product): ?>
		<tr class="<?php echo $p % 2 != 0 ? 'background-blue-light' : '' ?>">
			<td class="border-bottom border-left border-mute-light"><?php echo $product['name'] . ($product['option'] != "" ? " - " . $product['option'] . ($product['suboption'] != "" ? " - " . $product['suboption'] : "") : "") ?></td>
			<td class="border-bottom border-mute-light text-left"><?php echo $product['quantity'] ?></td>
			<td class="border-bottom border-right border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat_type'] == "excluded" ? $product['price'] : $product['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
<?php $p++; endforeach; ?>
		<tr>
			<td colspan="3" class="border-bottom-2 border-mute-light fore-color-1 text-center"><?php echo l10n('cart_shipping') ?></td>
		</tr>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2"><?php echo $order['shipping_name'] ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat_type'] == "excluded" ? $order['shipping_price'] : $order['shipping_price_plus_vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
		<tr>
			<td colspan="3" class="border-bottom-2 border-mute-light fore-color-1 text-center"><?php echo l10n('cart_payment') ?></td>
		</tr>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2"><?php echo $order['payment_name'] ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat_type'] == "excluded" ? $order['payment_price'] : $order['payment_price_plus_vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
<!-- Total Amounts -->
		<tr>
			<td colspan="3" class="fore-color-1 border-bottom-2 border-mute-light"><?php echo l10n('cart_total', 'Total') ?></td>
		</tr>
<?php if (isset($order['coupon']) && $order['coupon'] != ""): ?>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2" class="text-left"><?php echo l10n('cart_coupon', "Coupon Code") ?></td>
			<td class="border-right border-bottom border-mute-light text-left print-text-right"><b><?php echo $order['coupon'] ?></b></td>
		</tr>
<?php endif; ?>
<?php switch($order['vat_type']) {
case "included": ?>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2" class="text-left"><?php echo l10n('cart_total_vat') ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2" class="text-left"><?php echo l10n('cart_vat_included') ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
<?php
break;
case "excluded": ?>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2" class="text-left"><?php echo l10n('cart_total') ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price'], ' ' . $order['currency']) ?></b></td>
		</tr>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2" class="text-left"><?php echo l10n('cart_vat') ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
		<tr>
			<td class="border-left border-bottom border-mute-light" colspan="2" class="text-left"><?php echo l10n('cart_total_vat') ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
<?php
break;
case "none":?>
		<tr>
			<td class="border-left border-bottom border-mute-light colspan="2"><?php echo l10n('cart_total') ?></td>
			<td class="border-right border-bottom border-mute-light text-right print-text-right"><b><?php echo Configuration::getCart()->toCurrency($order['price_plus_vat'], ' ' . $order['currency']) ?></b></td>
		</tr>
<? break; ?>
<?php } ?>
	</table>
	<div class="clearfix margin-top-2"></div>
	<a class="noprint button background-color-1 fore-white" href="cart-orders.php?status=<?php echo $order['status'] ?>"><?php echo l10n('cart_goback', "Back") ?></a>
	<div class="noprint text-center float-right ">
		<a class="button background-color-1 fore-white no-phone no-tablet" href="#" onclick="window.print(); return false;"><?php echo l10n('cart_print', "Print") ?></a>
		<?php if ($order['status'] == 'inbox'): ?>
		<a class="button background-color-1 fore-white" href="cart-order.php?id=<?php echo $order['id'] ?>&amp;evade=true"><?php echo l10n('cart_evade', "Evade") ?></a>
		<?php endif; ?>
		<a class="button background-color-1 fore-white" href="cart-order.php?id=<?php echo $order['id'] ?>&amp;exportcsv=true"><?php echo l10n('cart_export', "Export") ?></a>
	</div>
	<div class="clearfix"></div>
