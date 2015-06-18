jQuery( function ( $ ) {
	$( '#page_id' ).change( function() {
		var post_id = $('#page_id').val();
		var name = $('#page_id option:selected').text();
		$('#form2').prepend('<tr id="selected-id-'+post_id+'"><td><div><label for="selectedid-'+post_id+'">Post Selected</label><input type="hidden" id="selectedid-'+post_id+'" name="entradas[]" value="'+post_id+'"/> <strong>'+name+'</strong> <a href="#" onclick="delete_campo('+post_id+')" class="selecteddel" id="selectedid-'+post_id+'">Del</a></div></td></tr>');
	});
	$( '#anonimousvoter' ).click(function() {
        if (this.checked) {
            $("#formemail").show();
        } else {
            $("#formemail").hide();
        }
	});
		$( '#sendemail' ).click(function() {
        if (this.checked) {
            $("#textemail").show();
        } else {
            $("#textemail").hide();
        }
	});
		$( '.example-button' ).click(function() {
		e.preventDefault();
	});
});

function delete_campo(post_id) {
		post = '#selected-id-'+post_id;
		alert(post);
		jQuery(post).remove();
}

