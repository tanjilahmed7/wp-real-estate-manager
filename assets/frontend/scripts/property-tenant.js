jQuery(document).on("click", "#tenant-req-confirm", function(event) {
    "use strict";
    event.preventDefault();

// if () {
    var tenant_request_id = $("#tenant_request_id").val();
    var property_owner_id = $("#property_owner_id").val();
    var property_id = $("#property_id").val();
    var status = $("#status").val();
    console.log(tenant_request_id);
    console.log(property_owner_id);
    console.log(property_id);
    console.log(status);
    var data= {
        'action' : 'tenant_request',
        'tenant_request_id' : tenant_request_id,


    }

    ajaxRequest = jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: {
            'action' : 'tenant_request',
            'tenant_request_id' : tenant_request_id,
            'property_owner_id' : property_owner_id,
            'status' :  status,
            'property_id' : property_id

        },

            beforeSend: function() {
                console.log(data);

            },
            success:function(data) {
                $(".tenant").html(data);
                console.log(data);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
    });
// }

});
