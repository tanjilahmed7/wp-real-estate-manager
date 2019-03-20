jQuery(document).on("click", "#posted_requirements", function(event) {
    "use strict";
    event.preventDefault();

    var area = $("#area").val();
    var posted_date = $("#posted_date").val();
    var subject =$("#subject").val();

    ajaxRequest = jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: {
            'action' : 'wp_rem_landlord_posted_requirements',
            'area' :area ,
            'posted_date' : posted_date,
            'subject':subject
        },

            beforeSend: function() {
                console.log({type: "POST",
                url: wp_rem_globals.ajax_url,
                data: {
                    'action' : 'wp_rem_landlord_posted_requirements',
                    'area' :area ,
                    'posted_date' : posted_date,
                    'subject':subject
                }});

            },
            success:function(data) {
                $(".user-packages").html(data);
                console.log(data);
              }
            });

});


 // jQuery('a#tenancy_approval').bind('click'
jQuery(document).on("click", "#tenancy_approval", function(event) {
    "use strict";
    event.preventDefault();
    var accepted=1;
    var id = $(this).attr('data-req');
    console.log(id);
    ajaxRequest = jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: {
            'action' : 'wp_rem_landlord_tenancy_requests',
            'status' :accepted,
            'id' :id
        },
            success:function(response) {
              document.getElementsByClassName("user-holder").innerHTML='';
              jQuery(".user-holder").html(response);

            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
    });


});

// jQuery('a#decline').bind('click'
jQuery(document).on("click", "#tenancy_decline", function(event) {
   "use strict";
   event.preventDefault();
   var id = $(this).attr('data-req');
      var decline =2;
   console.log(id);
   ajaxRequest = jQuery.ajax({
       type: "POST",
       url: wp_rem_globals.ajax_url,
       data: {
           'action' : 'wp_rem_landlord_tenancy_requests',
           'status' :decline,
           'id' :id
       },
           success:function(response) {
             document.getElementsByClassName("user-holder").innerHTML='';
             jQuery(".user-holder").html(response);
           },
           error: function(errorThrown){
               console.log(errorThrown);
           }
   });
});

// jQuery('a#decline').bind('click'
jQuery(document).on("click", "#assign_property_manager", function(event) {
   "use strict";
   event.preventDefault();
      var property_id = $("#property_id").val();
      var property_manager_id = $("#property_manager_id").val();
       ajaxRequest = jQuery.ajax({
           type: "POST",
           url: wp_rem_globals.ajax_url,
           data: {
               'action' : 'wp_rem_add_property_manager',
               'property_id' :property_id,
               'property_manager_id' :property_manager_id
           },
               success:function(response) {
                 document.getElementsByClassName("user-holder").innerHTML='';
                 jQuery(".user-holder").html(response);
                   $(".alert").show();
                   setTimeout(function() { $(".alert").hide(); }, 5000);
               },
               error: function(errorThrown){
                   console.log(errorThrown);
               }
       });
});

jQuery(document).on("click", "#maintenance_req_form", function(event) {
   "use strict";
   event.preventDefault();
      var property_id = $("#property_id").val();
      var tenant_id = $("#tenant_id").val();
      var subject = $("#subject").val();
      var message = $("#message").val();
      var membertype = $("#membertype").val();
      console.log(tenant_id);
       ajaxRequest = jQuery.ajax({
           type: "POST",
           url: wp_rem_globals.ajax_url,
           data: {
               'action' : 'wp_rem_landlord_maintenance_requests',
               'property_id' :property_id,
               'tenant_id' :tenant_id,
               'subject' : subject,
               'message':message,
               'membertype':membertype
           },
               success:function(response) {
                 document.getElementsByClassName("user-holder").innerHTML='';
                 jQuery(".user-holder").html(response);
                   $(".alert").show();
                   $('#request_maintenance').modal('hide');
                   // $('body').removeClass('modal-backdrop');
                   // $('.modal-backdrop').remove();
                   setTimeout(function() { $(".alert").hide(); }, 5000);
               },
               error: function(errorThrown){
                   console.log(errorThrown);
               }
       });
});
jQuery(document).on("click", ".schedule_form_class", function(event) {
   "use strict";
   event.preventDefault();

   var form_id= event.currentTarget.id;
   var array=form_id.split("-");
   form_id =array[array.length - 1];
    var schedule = $("#schedule-"+form_id).val();
    var id = $("#req_id-"+form_id).val();
    var status =  $("#req_status   -"+form_id).val();
       ajaxRequest = jQuery.ajax({
           type: "POST",
           url: wp_rem_globals.ajax_url,
           data: {
               'action' : 'wp_rem_member_view_maintenance_requests',
               'schedule' :schedule,
               'status' : status,
               'id' :id

           },
               success:function(response) {
                 document.getElementsByClassName("user-holder").innerHTML='';
                 jQuery(".user-holder").html(response);
                   $(".alert").show();
                   setTimeout(function() { $(".alert").hide(); }, 5000);
               },
               error: function(errorThrown){
                   console.log(errorThrown);
               }
       });
});
jQuery(document).ready( function () {

    $('#list_properties_assigned').DataTable({
       scrollX: 400
    });
    $('#tenant_maintence_list').DataTable({
       scrollX: 1000
    });

} );

jQuery(document).on("click", "#user_role", function(event) {
   "use strict";
   // event.preventDefault();
      var userrole= document.getElementById("userrole").value;
      console.log(x);
      ajaxRequest = jQuery.ajax({
         type: "POST",
         url: wp_rem_globals.ajax_url,
         data: {
             'action' : 'wp_rem_member_role_choose',
             'userrole' :userrole
         },
             success:function(response) {
               document.getElementsByClassName("user-holder").innerHTML='';
               jQuery(".user-holder").html(response);
                 $(".alert").show();
                 setTimeout(function() { $(".alert").hide(); }, 5000);
             },
             error: function(errorThrown){
                 console.log(errorThrown);
             }
     });

});


jQuery(document).on("click", "#bankinfo", function(event) {
   "use strict";
   event.preventDefault();
      var firstName = $("#firstName").val();
      var lastName = $("#lastName").val();
      var cardNumber = $("#cardNumber").val();
      var expireDate = $("#expireDate").val();
      var cvv = $("#cvv").val();
      console.log(firstName);
        ajaxRequest = jQuery.ajax({
           type: "POST",
           url: wp_rem_globals.ajax_url,
           data: {
               'action' : 'wp_rem_member_bank_information',
               'firstName' :firstName,
               'lastName' :lastName,
               'cardNumber' : cardNumber,
               'expireDate':expireDate,
               'cvv':cvv
           },
               success:function(response) {
                 document.getElementsByClassName("user-holder").innerHTML='';
                 jQuery(".user-holder").html(response);
                   $(".alert").show();
                   setTimeout(function() { $(".alert").hide(); }, 5000);
               },
               error: function(errorThrown){
                   console.log(errorThrown);
               }
       });
});
