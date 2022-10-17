<select onchange="location.href=$(this).val()" class="border-mute border background-transparent">
	<option value="?plot_type=noncumulative"<?php echo $plotType == 'noncumulative' ? " selected" : "" ?>>1 - <?php echo l10n('cart_plot_noncumulative', 'Non cumulative amounts') ?></option>
	<option value="?plot_type=cumulative"<?php echo $plotType == 'cumulative' ? " selected" : "" ?>>2 - <?php echo l10n('cart_plot_cumulative', 'Cumulative amounts') ?></option>
	<option value="?plot_type=products"<?php echo $plotType == 'products' ? " selected" : "" ?>>3 - <?php echo l10n('cart_plot_productscount', 'Products count') ?></option>
</select>
