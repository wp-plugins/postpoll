jQuery(document).ready( function() {

   jQuery("#form3").submit( function(e) {
      e.preventDefault();
      var poll = [];
      var i = 0;
      var a;
      var totales;
      var polle;
      var pollid = jQuery("#pollid").val();
      var cookies = jQuery("#savecookie").val();
      var showtype = jQuery("#showtype").val();
      if (showtype==1) {
      poll = jQuery("#vote_poll option:selected").val();
      } else if (showtype==2) {
      poll = jQuery(".form3 input[type='radio']:checked").val();
      } else if (showtype==3) {
         jQuery("input:checkbox[name=poll]:checked").each(function () {
         poll[i]=(jQuery(this).val());
         i++;
      });
      }

      nonce = jQuery("#data-nonce").val();
      datos = btoa(poll);
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "my_user_vote", poll: datos, nonce: nonce, cookies: cookies, pollid: pollid},
         success: function(response) {
            if(response.type == "success") {
               jQuery("#postpoll").hide()
               jQuery("#postpollmess").show()
               totales=eval(response.vote_count)
               for (a = 0; a < poll.length; a++) { 
               polle=poll[a]
               jQuery("#post-"+poll[a] ).text(totales[polle])
               }
               jQuery("#postpollmess" ).append( "<p>Thanks for your Vote</p>" )
            }
            else {
               alert("Your vote could not be added");
            }
         }
      }) 

   })


})