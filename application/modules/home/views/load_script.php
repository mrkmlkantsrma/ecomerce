<?php
    if( isset($js) ){
        foreach( $js as $fileID => $filePath) echo "<script id='$fileID' src='$filePath'></script>";
    }
?>
<script>
    $(document).ready(function(){ 
        
        if ($("#register_form").length > 0) {  
            $("#register_form").validate({
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
                        url: "<?php  echo base_url('home/HomeController/username_check');?>",
                          type:"POST",
                          data: {
                             email: function(data){ 
                              return $("#uname").val();
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
                        url: "<?php  echo base_url('home/HomeController/email_check');?>",
                          type:"POST",
                          data: {
                             email: function(data){ 
                              return $("#emailcheck").val();
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
                         required: "<span style='color:red'><div >Firstname Required.. Please Enter your Username</div></span>",
                        
                    },
                    lastname: {
                         required: "<span style='color:red'><div >Lastname Required.. Please Enter your Lastname</div></span>",
                        
                    },
                    username: {
                         required: "<span style='color:red'><div >Username Required.. Please Enter your Username</div></span>",
                         remote: "<span style='color:red'><div >Username is already in use!.. Please Choose Another</div></span>",
                    
                    },
                    email: {
                        required: "<span style='color:red'><div >Email Required.. Please Enter your Email</div></span>",
                        email: "<span style='color:red'><div >It does not seem valid email..</div></span>",
                        maxlength: "<span style='color:red'><div >Upto 25 characters are allowed</div></span>",
                        remote: "<span style='color:red'><div >Email is already in use!.. Please Choose Another</div></span>",
                    },
                    password: {
                         required: "<span style='color:red'><div >Password Required.. Please Enter your Password</div></span>",
                        
                    },
                    number: {
                         required: "<span style='color:red'><div >Number Required.. Please Enter your Number</div></span>",
                        
                    },
                    submitHandler: function(form) {
                    form.submit();
                  }
                },
            })
        }
        
        $("#register_form").submit(function(event){
          submitForm();
        });
        });
    function submitForm(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>home/HomeController/RegisterUser",
            cache:false,
            data: $('form#registerForm').serialize(),
                success: function(response){
                },
            error: function(){
            }
        });
    }

    $(document).ready(function(){ 

        if ($("#login_form").length > 0) {  
            $("#login_form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        minlength: 3,
                        maxlength: 20,
                        remote: {
                        url: "<?php  echo base_url('home/HomeController/login_Email_check');?>",
                          type:"POST",
                          data: {
                                email: function(data){ 
                                return $("#loginEmailcheck").val();
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 3,
                        maxlength: 10,
                    },
                    },
                    messages: {
                    email: {
                        remote: "<span style='color:red'><div >Email is invalid !.. Please check Again</div></span>",
                        required: "<span style='color:red'><div >Email Required.. Please Enter your Email</div></span>",
                    },
                     password: {
                        required: "<span style='color:red'><div >Password Required.. Please Enter your password</div></span>",
                    },
                    
                    submitHandler: function(form) {
                    form.submit();
                  }
                },
            })
        }
    
        $("#login_form").submit(function(event){
          submitForm();
        });
        });
    function submitForm(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>home/HomeController/LoginUser",
            cache:false,
            data: $('form#loginForm').serialize(),
                success: function(response){
                  
                },
            error: function(){
                  
             
            }
        });
    }
    $(document).ready(function() {
       var toastMixin = Swal.mixin({
                    toast: true,
                    title: 'General Title',
                    animation: false,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 5000,
                  });
        <?php 
            if($this->session->flashdata('error_login')){ ?>
            $("#login-modal").modal('show');
            
            toastMixin.fire({
                    title: '<?php echo $this->session->flashdata("error_login"); ?>',
                    icon: 'error'
                });
                
        <?php } if($this->session->flashdata('error')) { ?>
             
            toastMixin.fire({
                    title: '<?php echo $this->session->flashdata("error"); ?>',
                    icon: 'error'
                });
                  
        <?php } if($this->session->flashdata('success')) { ?>
             
            toastMixin.fire({
                    title: '<?php echo $this->session->flashdata("success"); ?>',
                    icon: 'success'
                });

        <?php } ?>
            
    });
</script>

