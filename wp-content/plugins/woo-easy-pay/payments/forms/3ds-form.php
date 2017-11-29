<form name="secure_form" method="POST" action="<?php echo $_3dsUrl?>">
	<input type="hidden" name="PaReq" value="<?php echo $_paReq?>" />
	<input type="hidden" name="TermUrl" value="<?php echo $_termUrl?>" /> 
	<input type="hidden" name="MD" value="Merchant supplied data" />
</form>
<script>
window.onload = function(){
	document.secure_form.submit();
}
</script>