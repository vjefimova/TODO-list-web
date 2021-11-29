<?php
require('../conf.php');

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>login TODO-list</title>
</head>
<body>
<section class="vh-100">
    <div class="container  py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-15 col-xl-14">
                <form onsubmit="event.preventDefault()" class="box">
                    <h1>Login</h1>
                    <p class="text-muted"> Please enter your login and password!</p> 
                    <input type="text" name="" placeholder="Username"> 
                    <input type="password" name="" placeholder="Password"> 
                    <input type="submit" name="" value="Login" href="#">
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>