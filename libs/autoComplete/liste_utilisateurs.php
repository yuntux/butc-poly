﻿<script type="text/javascript" src="libs/autoComplete/jquery-1.2.1.pack.js"></script>
<script type="text/javascript">
	function lookup2(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions2').hide();
		} else {
			$.post("libs/autoComplete/rpc_utilisateurs2.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions2').show();
					$('#autoSuggestionsList2').html(data);
				}
			});
		}
	} // lookup
	
	function fill_2(thisValue,id) {
		$('#inputString2').val(thisValue);
		$('#id_commune_arrivee').val(id);
		setTimeout("$('#suggestions2').hide();", 200);
	}
</script>

				<input type="text" name="admin" autocomplete="off" size="30" value="" id="inputString2" onClick="select();" onkeyup="lookup2(this.value);" onblur="fill2();" />
				<input type="hidden" name="login_admin" size="30" value="<?php echo $trajet[17]; ?>" id="id_commune_arrivee" />
			<div class="suggestionsBox" id="suggestions2" style="display: none;">
				<img src="libs/autoComplete/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList2">
					&nbsp;
				</div>
</div>
