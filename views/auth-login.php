<?php
session_start();
include('partial/header.php');
include('partial/loader.php');
?>

<style>
    body {
        margin: 0;
        padding: 0;
        background-image: url('../assets/images/login/login_bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Rubik', sans-serif;
    }

    /* Elegant Green Overlay */
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(36, 105, 92, 0.8), rgba(0, 0, 0, 0.6)); /* Green to Black overlay */
        backdrop-filter: blur(5px);
        z-index: -1;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95) !important;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); /* Softer, deeper shadow */
        border: 1px solid rgba(255, 255, 255, 0.6);
        padding: 45px;
        width: 100%;
        max-width: 450px;
        margin: auto;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .logo img {
        max-height: 70px; /* Slightly larger logo */
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px 18px;
        border: 2px solid #eee;
        transition: all 0.3s ease;
        background-color: #f8fcfb; /* Very light green tint */
    }

    .form-control:focus {
        border-color: #24695c;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(36, 105, 92, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #24695c 0%, #164f44 100%) !important; /* Elegant Gradient */
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-weight: 600;
        letter-spacing: 0.8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(36, 105, 92, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(36, 105, 92, 0.4);
    }

    .btn-primary:active {
        transform: scale(0.98);
    }
    
    .social .btn-showcase .btn-light {
        border-radius: 12px;
        width: 45px;
        height: 45px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 8px;
        color: #555;
        border: 1px solid #eee;
        transition: all 0.3s;
        background-color: #fff;
    }
    
    .social .btn-showcase .btn-light:hover {
        background-color: #f0faf8;
        color: #24695c;
        border-color: #24695c;
        transform: translateY(-2px);
    }

    h4 {
        color: #24695c;
        font-weight: 700;
    }

    .checkbox label {
        color: #666;
    }
    
    a.link {
        color: #24695c !important;
        font-weight: 500;
        text-decoration: none;
    }
    
    a.link:hover {
        text-decoration: underline;
    }
</style>

<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div class="text-center">
                        <a class="logo" href="index.php">
                            <!-- Try getting the logo from assets if preferred, or use text if image fails -->
                            <img class="img-fluid" src="../assets/images/logo/login.png" alt="Healty App">
                        </a>
                    </div>
                    <div class="login-main">
                        <form class="theme-form" action="../process/login-proses.php" method="POST">
                            <h4 class="text-center mb-2">Welcome Back!</h4>
                            <p class="text-center text-muted mb-4">Sign in to continue to your healthy journey</p>
                            
                            <div class="form-group mb-4">
                                <label class="col-form-label">Email Address</label>
                                <input class="form-control" type="email" name="email" required="" placeholder="name@example.com">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="col-form-label">Password</label>
                                <div class="form-input position-relative">
                                    <input class="form-control" type="password" name="password" required="" placeholder="*********">
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-0">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted mb-0" for="checkbox1">Remember me</label>
                                    </div>
                                    <a class="link" href="forget-password.html" style="font-size: 14px;">Forgot password?</a>
                                </div>
                                
                                <button class="btn btn-primary btn-block w-100" type="submit">Sign In</button>
                            </div>
                            
                            <div class="position-relative mt-4">
                                <hr class="bg-light">
                                <p class="small text-muted position-absolute top-0 start-50 translate-middle bg-white px-2" style="margin-top: -1px;">Or continue with</p>
                            </div>

                            <div class="social mt-4 text-center">
                                <div class="btn-showcase">
                                    <a class="btn btn-light" href="#" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i></a>
                                    <a class="btn btn-light" href="#" target="_blank"><i class="txt-twitter" data-feather="twitter"></i></a>
                                    <a class="btn btn-light" href="#" target="_blank"><i class="txt-fb" data-feather="facebook"></i></a>
                                </div>
                            </div>
                            
                            <p class="mt-4 mb-0 text-center text-muted">Don't have an account? <a class="ms-2 fw-bold" href="auth-register.php" style="color: #24695c;">Sign Up</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('partial/scripts.php'); ?>
</div>
<?php include('partial/footer-end.php'); ?>