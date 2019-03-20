/*
 * Adding Team Member
 */


jQuery(document).on("click", "#myreport", function(event) {
    "use strict";
    event.preventDefault();

    var Todate = $("#reportInputTo").val();
    var Fromdate = $("#reportInputFrom").val();

    ajaxRequest = jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: {
            'action' : 'wp_rem_report',
            'todate' : Todate,
            'fromdate' : Fromdate
        },
     
            beforeSend: function() { 
                //$(".user-packages").html("");

            },
            success:function(data) {
                $(".user-packages").html(data);
                console.log(data);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
    });

});


jQuery( document ).ajaxComplete(function() {
  var x= document.getElementsByClassName('user-packages');
  var y = x[0].lastChild;
  y.nodeValue='';
});
