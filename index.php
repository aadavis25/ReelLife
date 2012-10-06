<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ReelLife</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A social picture taking competition among friends">
    <meta name="author" content="Aaron Davis">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <div id="fb-root"></div>
  <?php

// Provides access to app specific values such as your app id and app secret.
// Defined in 'AppInfo.php'
require_once('AppInfo.php');

// Enforce https on production
if (substr(AppInfo::getUrl(), 0, 8) != 'https://' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
  header('Location: https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}

// This provides access to helper functions defined in 'utils.php'
require_once('utils.php');

require_once('sdk/src/facebook.php');

$facebook = new Facebook(array(
  'appId'  => AppInfo::appID(),
  'secret' => AppInfo::appSecret(),
  'sharedSession' => true,
  'trustForwarded' => true,
));

$user_id = $facebook->getUser();
if ($user_id) {

  try {
    // Fetch the viewer's basic information
    $basic = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    // If the call fails we check if we still have a user. The user will be
    // cleared if the error is because of an invalid accesstoken
    if (!$facebook->getUser()) {
      header('Location: '. AppInfo::getUrl($_SERVER['REQUEST_URI']));
      exit();
    }
  }
}
 ?>
  </head>

  <body>

      <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <img class="brand" src="/ico/favicon.ico">
          <a class="brand" href="#">ReelLife</a>

          <div class="nav-collapse collapse">
            
            <ul class="nav">

              <li class="active"><a href="/">Home</a></li>
              <li><a href="images.php">Images</a></li>
                          </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
    <div class="row" style="margin-left:-90px">
      <div class="titletext hero-unit span12" style="border:solid 2px white; color:#fff;float: left;">
        <?php if (isset($basic)) { ?>
        <img src="https://graph.facebook.com/<?php echo he(idx($basic, 'id')); ?>/picture?type=normal" style="margin-top:20px;float: left;">
        <?php } ?>
         <h1 class="offset1">Welcome to your ReelLife
        <?php if (isset($basic)) { ?>,
          <br>
          <span style="text-decoration:underline"><?php echo he(idx($basic, 'name')); ?> </span></h1>
          <?php } ?>
          <h2 class="offset1">You have 7 seconds to capture a moment... make it count!</h2>
      </div> 
    <span class="span9 offset2 ">
      <div class="well"><h3 class="reveal">What exactly is ReelLife?</h3>
        <ul style="display: none; ">
          <li>ReelLife is a mobile app that will prompt the user to take pictures at random times during the day when his or her phone is in use.</li>
          <li>Over time, the user and his or her friends will have a story of photos with which to look back on their <strong>"reel"</strong> lives.</li>
        </ul>
      </div>
      <div class="well"><h3 class="reveal">How does ReelLife work?</h3>
        <ul style="display: none; ">
          <li>The app will notify the user with instructions for the upcoming photo to be taken at a random time during the day (within reasonable hours). A countdown from 7 seconds will then begin. </li>
          <li>The user will have those seconds to take the most <strong>fantastic</strong> picture based on the theme given to them.</li>
          <li>Their photo will go up against their friends' photos to be judged and voted on by the group.</li>
        </ul>
      </div>
      <div class="well"><h3 class="reveal">What's awesome about ReelLife?</h3>
        <ul style="display: none; ">
          <li>Get the most likes on your reel.</li>
          <li>Show off your moment capturing skills.</li>
          <li>Keep the reels going with your friends, capture awesome moments in your <strong>"reel"</strong> lives!</li>
        </ul>
      </div>
      </span>
   
  </div>
  </div><!-- /container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
    <script src="js/events.js"></script>
    <script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?php echo AppInfo::appID(); ?>', // App ID
          channelUrl : '//<?php echo $_SERVER["HTTP_HOST"]; ?>/channel.html', // Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true // parse XFBML
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location = window.location;
        });

        FB.Canvas.setAutoGrow();
      };

      // Load the SDK Asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    

    
  </body>
</html>​