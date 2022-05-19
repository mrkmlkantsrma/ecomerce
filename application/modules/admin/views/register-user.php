<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/contact.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
  </head>

  <div id="contact-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  ">
      <div class="modal-content">
        <div class="modal-header" id="modalheader">
          <h3 class="headtitle">Register Form</h3>
          <a class="close" data-dismiss="modal">X</a> 
        </div>
        <form id="contact_form" action="<?php echo base_url();?>UserController/RegisterUser" method ="post">
            <div class="col-lg-12">
              <label for="firstname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="frname" name="firstname">
               <!-- <div style="color:red"><?php //echo form_error('firstname')?></div> -->
            </div>
            <div class="col-lg-12">
              <label for="lastname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="srname" name="lastname">
              <!-- <div style="color:red"><?php //echo form_error('lastname')?></div> -->
            </div>
            <div class="col-lg-12">
              <label for="username" class="form-label">User Name</label>
              <input type="text" class="form-control" id="uname" name="username">
              <!-- <div style="color:red"><?php //echo form_error('username')?></div> -->
            </div>
            <div class="col-lg-12">
              <label for="email" class="form-label">E-mail</label>
              <input type="email" class="form-control" id="emailcheck" name="email">
              <!--  <div style="color:red"><?php // echo form_error('email')?></div>  -->
            </div>
            <div class="col-lg-12">
              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control" id="password" name="password">
              <!-- <div style="color:red"><?php //echo form_error('password')?></div> -->
            </div>
            <div class="col-lg-12">
              <label for="contact No" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="number" name="number">
              <!-- <div style="color:red"><?php //echo form_error('number')?></div> -->
            </div>
             <div class="col-lg-12">
              <label for="user Type" class="form-label" hidden>Type</label>
              <input type="text" class="form-control" id="user_type" name="user_type" value="Admin" disable hidden>
              <!-- <div style="color:red"><?php //echo form_error('user_type')?></div> -->
            </div>
            <div class="modal-footer">
            <div class="col-lg-4 pt-4 pt-lg-0">
              <div class="text-center">
              <div id="contact">
                 <button type="submit" id="submitvalidation" class="btn btn-primary">Submit</button>
              </div>
              </div>
            </div>
            </div>
        </form>
      </div>
    </div>
  </div>
<html>

<script>
  $(document).ready(function(){ 

    if ($("#contact_form").length > 0) {  
        $("#contact_form").validate({
                rules: {
                    firstname: {
                        required: true,
                        minlength: 3,
                        maxlength: 10,
                    },
                    lastname: {
                        required: true,
                        minlength: 3,
                        maxlength: 7,
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 10,
                         remote: {
                        url: "<?php  echo base_url('UserController/username_check');?>",
                          type:"POST",
                          data: {
                             email: function(data){ 
                              return $("#uname").val();
                             //$("#username").html('hello'); 
                          }
                        }
                      }    
                    },
                    email: {
                        required: true,
                        email: true,
                        minlength: 7,
                        maxlength: 25,
                        remote: {
                        url: "<?php  echo base_url('UserController/email_check');?>",
                          type:"POST",
                          data: {
                             email: function(data){ 
                              return $("#emailcheck").val();
                             //$("#email").html('hello'); 
                          }
                        }
                      }      
                    },
                    password: {
                        required: true,
                        minlength: 3,
                        maxlength: 10,
                    },
                    number: {
                        required: true,
                        number:true,
                    },
                    },
                    messages: {
                    firstname: {
                         required: "First Name is required",  
                        
                    },
                     username: {
                         remote: "Username is already in use!",  
                    
                    },
                    email: {
                        email: "It does not seem valid email",
                        // required: "Email is required",
                        maxlength: "Upto 25 characters are allowed",
                        remote: "This email is already in use!",
                    },
                    submitHandler: function(form) {
                    form.submit();
                   }
                    
                },
            })
        }

//     $("#email").blur(function() {

//      var email  = $('#email').val();

// //alert(email);
//       $.ajax({
//           url: "<?php //echo base_url();?>HomeController/email_check",
//           type: 'post',
//          data: {
//             'email':email,
//             'email_check':1,
//         },

//         success:function(data) {  
//           alert(data);
//           alert("hy");
//           // clear span before error message
//           $("#email_error").remove();

//           // adding span after email textbox with error message
//           $("#email").after("<span id='email_error' class='text-danger'>"+response+"</span>");
//         },

//         error:function(e) {
//           $("#result").html("Something went wrong");
//              alert("hyyyyyy");
//              $("#email").after("<span id='email_error' class='text-danger'>"+data+"</span>");
//         }

//       });
//     });

  $("#contact_form").submit(function(event){
      submitForm();
    });
  });
  function submitForm(){
     $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>UserController/RegisterUser",
        cache:false,
        data: $('form#contactForm').serialize(),
          success: function(response){
            $("#contact").html(response)
            $("#contact-modal").modal('hide');
          },
          error: function(){
            alert("Error");
          }
    });
  }
</script>
 