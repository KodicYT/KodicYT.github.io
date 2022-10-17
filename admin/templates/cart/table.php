<div class="search border-mute fore-mute">
	<span class="fa fa-search"></span>
	<form action="cart-orders.php?status=<?php echo $status ?>" mthod="GET">
		<input class="color-mute" type="text" placeholder="SEARCH" name="search" value="<?php echo $search ?>">
	</form>
</div>
<table class="orders-table framed">
	<thead>
		<tr>
			<th class="border-bottom-2 border-mute <?php echo $colorClass ?>"><?php echo l10n("", "Order") ?></th>
			<th class="no-small-phone border-bottom-2 border-mute <?php echo $colorClass ?>"><?php echo l10n("", "User") ?></th>
			<th class="no-tablet no-phone border-bottom-2 border-mute <?php echo $colorClass ?>"><?php echo l10n("", "Order Date") ?></th>
			<th class="no-phone border-bottom-2 border-mute <?php echo $colorClass ?>"><?php echo l10n("", "Amount") ?></th>
			<th class="no-tablet no-phone border-bottom-2 border-mute <?php echo $colorClass ?>"><?php echo l10n("", "Shipping") ?></th>
			<th class="border-bottom-2 border-mute <?php echo $colorClass ?>"><?php echo l10n("", "Actions") ?></th>
		</tr>
	</thead>
	<tbody>
<?php if (count($orders['orders']) <= 0): ?>
	<tr>
		<td colspan="6" class="text-center"><?php echo l10n('search_empty', 'Empty results') ?></td>
	</tr>
<?php else:?>
	<?php $t = 0; foreach ($orders['orders'] as $order): $t++; ?>
		<tr class="text-light border-bottom border-mute-light <?php echo $t % 2 ? '' : 'background-blue-light' ?>">
			<td class="border-left border-mute-light">
				<div class="order-number"><a class="text-underline fore-color-inherit" href="cart-order.php?id=<?php echo $order['id'] ?>"><?php echo $order['id'] ?></a></div>
			</td>
			<td class="no-small-phone">
				<?php
				$fields = array();

				// Convert the array into an associative array
				for ($i = 0; $i < count($order['invoice']); $i++) { 
					$field = $order['invoice'][$i];
					if (isset($field['field_id'])) {
						$fields[$field['field_id']] = $field;
					}
				}
				if (isset($fields['Name'])) {
					echo $fields['Name']['value'] . " ";
				}
				if (isset($fields['LastName'])) {
					echo $fields['LastName']['value'] . " ";
				}
				?>
			</td>
			<td class="no-tablet no-phone"><?php echo date("Y/m/d", strtotime($order['ts'])) ?></td>
			<td class="no-phone"><?php echo Configuration::getCart()->toCurrency($order['vat_type'] != "excluded" ? $order['price_plus_vat'] : $order['price'], ' ' . $order['currency']) ?></td>
			<td class="no-tablet no-phone"><?php echo $order['shipping_name'] ?></td>
			<td class="text-center border-right border-mute-light">
				<a class="margin-left fore-color-4 fa icon-large fa-search" href="cart-order.php?id=<?php echo $order['id'] ?>"></a>
				<?php if ($status=='inbox'): ?>
				<a class="margin-left fore-color-6 fa icon-large fa-sign-in" href="cart-orders.php?waiting=<?php echo $order['id']?>&status=<?php echo $status ?>" title="<?php echo l10n('cart_move_to_wait', 'Move to waiting') ?>"></a>
				<?php endif; ?>
				<?php if ($status=='waiting'): ?>
				<a class="margin-left fore-color-6 fa icon-large fa-sign-in fa-rotate-180" href="cart-orders.php?inbox=<?php echo $order['id']?>&status=<?php echo $status ?>" title="<?php echo l10n('cart_move_to_inbox', 'Move to inbox') ?>"></a>
				<?php endif; ?>
				<?php if ($status=='inbox'): ?>
				<a class="margin-left fore-color-6 fa icon-large fa-truck" href="cart-orders.php?evade=<?php echo $order['id']?>&status=<?php echo $status ?>" title="<?php echo l10n('cart_evade', 'Evade') ?>"></a>
				<?php endif; ?>
				<?php if ($status=='evaded'): ?>
				<a class="margin-left fore-color-6 fa icon-large fa-sign-in fa-rotate-180" href="cart-orders.php?unevade=<?php echo $order['id']?>&status=<?php echo $status ?>" title="<?php echo l10n('cart_move_to_inbox', 'Move to inbox') ?>"></a>
				<?php endif; ?>
				<a class="margin-left fore-color-2 fa icon-large fa-close" href="cart-orders.php?delete=<?php echo $order['id']?>&status=<?php echo $status ?>" onclick="return confirm('<?php echo str_replace("'", "\\'", l10n('cart_delete_order_q', 'Are you sure?')) ?>')" title="<?php echo l10n('cart_delete_order', 'Delete') ?>"></a>
			</td>
		</tr>
	<?php endforeach; ?>
<?php endif; ?>
	</tbody>
</table>
<?php if ($orders['paginationCount'] > $pagination_length): ?>
<?php $limit = ceil($orders['paginationCount'] / $pagination_length); ?>
		<div class="text-center pagination">
<?php if (@$_GET['page'] != 0): ?>
			<a class="fore-color-inherit" href="cart-orders.php?page=0&amp;status=<?php echo $status ?>&amp;search=<?php echo @$_GET['search'] ?>">&lt;&lt;</a>
<?php endif; ?>
<?php if (@$_GET['page'] - 2 >= 0): ?>
			<a class="fore-color-inherit" href="cart-orders.php?page=<?php echo @$_GET['page'] - 2 ?>&amp;status=<?php echo $status ?>&amp;search=<?php echo @$_GET['search'] ?>">&lt;</a>
<?php endif; ?>
<?php for ($i = max(@$_GET['page'] - 3, 0); $i < min($limit, max(@$_GET['page'] - 3, 0) + 6); $i++): ?>
			<a class="fore-color-inherit" href="cart-orders.php?page=<?php echo $i ?>&amp;status=<?php echo $status ?>&amp;search=<?php echo @$_GET['search'] ?>"><?php echo $i + 1?></a>
<?php endfor; ?>
<?php if (@$_GET['page'] + 2 < $limit): ?>
			<a class="fore-color-inherit" href="cart-orders.php?page=<?php echo @$_GET['page'] + 1 ?>&amp;status=<?php echo $status ?>&amp;search=<?php echo @$_GET['search'] ?>">&gt;</a>
<?php endif; ?>
<?php if (@$_GET['page'] != $limit - 1): ?>
			<a class="fore-color-inherit" href="cart-orders.php?page=<?php echo $limit - 1?>&amp;status=<?php echo $status ?>&amp;search=<?php echo @$_GET['search'] ?>">&gt;&gt;</a>
<?php endif; ?>
		</div>
<?php endif; ?>
