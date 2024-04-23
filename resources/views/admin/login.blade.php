<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Ubar-cab</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="{{ asset('assets/images/fevicon.png')}}" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}" />
      <!-- site css -->
      <link rel="stylesheet" href="{{ asset('assets/style.css')}}" />
      <!-- responsive css -->
      <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}" />
      <!-- color css -->
      <link rel="stylesheet" href="{{ asset('assets/css/colors.css')}}" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.css')}}" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css')}}" />
      <!-- custom css -->
      <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="{{ asset('assets/js/semantic.min.css')}}" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <link rel="stylesheet" href="{{asset('assets/css/toast.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/confirm.css')}}">

   </head>
   <body class="inner_page login">
    <span id="load"></span>
    <div class="col-sm-6 text-center">
        <div class="loader4"></div>
      </div>
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="">
                  <div class="">
                     <div class="center  ">
                     <img width="210" src="{{ asset('assets/logo.png')}}" alt="#" />
                     </div>
                  </div>
                  <div class="login_form" >
                     <form class="login" method="POST"  id="LoginDetail" >
                        <fieldset>
                           <div class="field">
                              <label class="label_field text-success" style="font-size : 24px;"><b>Username</b></label>
                              <input type="email" name="email"  required/>
                           </div>
                           <div class="field">
                              <label class="label_field text-success" style="font-size : 24px;"><b>Password</b></label>
                              <input type="password" name="password" required/>
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label text-success"><input type="checkbox" class="form-check-input "> Remember Me</label>
                           </div>
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt" type="submit" name="submit">Sing In</button>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
      <script src="{{ asset('assets/js/popper.min.js')}}"></script>
      <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
      <!-- wow animation -->
      <script src="{{ asset('assets/js/animate.js')}}"></script>
      <!-- select country -->
      <script src="{{ asset('assets/js/bootstrap-select.js')}}"></script>
      <!-- nice scrollbar -->
      <script src="{{ asset('assets/js/perfect-scrollbar.min.js')}}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="{{ asset('assets/js/custom.js')}}"></script>

      <script src="{{asset('assets/js/confirm.js')}}"></script>
      <script src="{{asset('assets/js/toast.js')}}"></script>
      <script src="{{asset('assets/js/toastDemo.js')}}"></script>
      <script src="{{asset('assets/js/alerts.js')}}"></script>
      <script>
        $('#load').hide();
        var toast = new Toasty();
        toast.configure();
        $(function() {
            $("#LoginDetail").on("submit" , function(e) {
                e.preventDefault();
                let fd = new FormData($("#LoginDetail")[0]);
                fd.append('_token',"{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('user.login') }}",
                    type:"POST",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#load').show();
                    },
                    success:function(result){
                        if(result.status)
                        {
                            toast.success(result.message);
                            setTimeout(function(){
                                window.location.href = result.location;
                            }, 500);
                        }
                        else
                        {
                            toast.error(result.message);

                        }
                    },
                    complete: function () {
                        $('#load').hide();
                    },
                    error: function(jqXHR, exception) {
                    }
                });
            })
        })
      </script>
   </body>
</html>
