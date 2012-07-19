<p class="payment_module">
	<a href="javascript:$('#paybox_form').submit();" title="{l s='Pay by credit card' mod='paybox'}">
		<img src="{$module_template_dir}paybox.jpg" alt="{l s='Pay by credit card' mod='paybox'}" />
		{l s='Pay by credit card' mod='paybox'}
	</a>
</p>

<form action="/cgi-bin/modulev2.cgi" method="post" id="paybox_form" class="hidden">
	<input type="hidden"  name="PBX_MODE" value="1"> 

	<!-- Paramètres specifiques à la boutique -->
	<input type="hidden"  name="PBX_SITE" value="{$pbx_site}"> 
	<input type="hidden"  name="PBX_RANG" value="{$pbx_rang}"> 
	<input type="hidden"  name="PBX_IDENTIFIANT" value="{$pbx_identifiant}"> 

	<!-- Paramètres specifiques à la commande monnaie/devise/nocommande/emetteur -->
	<input type="hidden"  name="PBX_TOTAL" value="{$order_total}"> 
	<input type="hidden"  name="PBX_DEVISE" value="{$pbx_currency}"> 
	<input type="hidden"  name="PBX_CMD" value="{$id_payment}"> 
	<input type="hidden"  name="PBX_PORTEUR" value="{$customer->email}"> 
	<input type="hidden"  name="PBX_RETOUR" value="{$return_format}"> 
	<!-- Paramètres nécessaire pour l'utilisation de l'url http -->
{if !$url_http}
	<input type="hidden"  name="PBX_RUF1" value="POST"> 
{/if}
	<!-- Paramètres specifiques au site client -->
	<input type="hidden"  name="PBX_EFFECTUE" value="{$url_ok}"> 
	<input type="hidden"  name="PBX_REFUSE" value="{$url_ko}"> 
	<input type="hidden"  name="PBX_ANNULE" value="{$url_cancel}"> 
</form>