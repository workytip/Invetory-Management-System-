<?php 

 require 'helpers/dbConnection.php';
 require  'helpers/functions.php';


  if($_SERVER['REQUEST_METHOD'] == "POST"){
    // code . . . 
    $email      = Clean($_POST['email']);
    $password   = Clean($_POST['password']); 
     
     # Validate Input . . . 
    $errors = [];

  if (!Validate($email, 'required')) {
    $errors['Email'] = "Field Required";
  } elseif (!Validate($email, 'email')) {
    $errors['Email'] = "Invalid Email";
  }

  if (!Validate($password, 'required')) {
    $errors['Password'] = "Field Required";
  } elseif (!Validate($password, 'min', 6)) {
    $errors['Password'] = "Length Must be >= 6 chars";
  }

  
   # Check Errors . . . 
 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    }else{
        // db Code . . . 
        $password = md5($password);
         $sql = "select * from user_details where email = '$email' and password = '$password'";
         $op  = DoQuery($sql);

         if(mysqli_num_rows($op) > 0){
            $user = mysqli_fetch_assoc($op);
            $_SESSION['user'] = $user;
            header('Location: '.url('index.php'));
    }else{
        $_SESSION['Message'] = ["Login Error" => "Invalid Email or Password"];
    }

  }
}



?>


<!doctype html>
<html lang="en">
  <head>
  	<title>Login IMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="forlogin/css/style.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(forlogin/images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Login</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
                    <?php 
                                          // print Errors . . . 
                                          Message();
                                       ?>

		      	<h3 class="mb-4 text-center">Have an account?</h3>

                  <form   action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"  class="signin-form" method="post">

		      		<div class="form-group">
		      			<input type="email" class="form-control" placeholder="Enter E-mail" name="email" required>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" name="password" class="form-control" placeholder="Enter Password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Forgot Password</a>
								</div>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="forlogin/js/jquery.min.js"></script>
  <script src="forlogin/js/popper.js"></script>
  <script src="forlogin/js/bootstrap.min.js"></script>
  <script src="forlogin/js/main.js"></script>

	</body>
</html>

