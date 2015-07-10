jQuery(document).ready( function() {

      jQuery('.form3').submit( function (e) {
         var pollid = jQuery(this).find("#pollid").val();
         var showtype = jQuery(this).find("#showtype").val();
         var a;
         var i = 0;
         var polle;
         var poll = [];
         var pollserial = jQuery(this).serialize();
         if (showtype==1) {
         poll[0] = jQuery(this).find("#vote_poll option:selected").val();
         } else if (showtype==2) {
         poll[0] = jQuery(this).find("input:checked").val();
         } else if (showtype==3) {
         jQuery(this).find("input:checked").each(function () {
         poll[i]=(jQuery(this).val());
         i++;
         }); }
        jQuery.ajax({
            type: 'post',
            dataType : "json",
            context: this,
            url: myAjax.ajaxurl,
            data: {action: "my_user_vote", poll: pollserial},
         success: function(response) {
            if(response.type == "success") {
               jQuery("#postpoll-"+pollid).hide()
               jQuery("#postpollmess-"+pollid).show()
               totales=eval(response.vote_count)
               for (a = 0; a < poll.length; a++) { 
               polle=poll[a]
               jQuery('#postpollmess-'+pollid).find("#post-"+poll[a] ).text(totales[polle])
               } 
               jQuery("#postpollmess-"+pollid+" #thankstext").show()
            }
            else {
               jQuery("#postpollmess-"+pollid+" #errortext").show()
            }
         }
        });
        e.preventDefault();
    });

})