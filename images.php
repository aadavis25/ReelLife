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
    <link href="css/jquery.lightbox-0.5.css" rel="stylesheet">
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
              <li><a href="/">Home</a></li>
              <li class="active"><a href="images.php">Images</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">


     
      <?php if (isset($basic)) { ?>
      <div class="row">
      <div class="well titletext">
        <span class="span2" id="picture" style="background: url(https://graph.facebook.com/<?php echo he($user_id); ?>/picture?type=normal) no-repeat; height:100%;"></span>
        <br>
         <h1><?php echo he(idx($basic, 'name')); ?></h1>
      <?php } ?>
      </div> 
      <div class="well bodytext">
        <h2>Check out your ReelLife</h2>
      </div>
    <span class="span10 offset2">
      <div id="gallery">
        <ul>
          <?php
           $albums = idx($facebook->api('/me/albums/'), 'data', array());
           foreach ($albums as $album)
              if (idx($album, 'name') == "ReelLife Photos"){
                $albumid = idx($album, 'id');
                break;
              }
            if ($albumid != null){
              $photos = idx($facebook->api($albumid . '/photos?limit=200'), 'data', array());
              $i = 0;
              foreach ($photos as $photo) {
              // Extract the pieces of info we need from the requests above
              $id = idx($photo, 'id');
              $name = idx($photo, 'name');
              $link = idx($photo, 'source');
              $likes = idx($photo, 'likes');
              if ($likes != null)
                $likeNum = sizeof(idx($likes, 'data'));
              else 
                $likeNum = 0;
            
          ?>
          
              <h4 class="well">Likes : <span class="badge badge-info"><?php echo $likeNum?></span></h4>
             <li>
              <a href="<?php echo he($link); ?>" target="_top" title="<?php echo $name?> Likes = <?php echo $likeNum?>"><img src=<?php echo he($link); ?> style="height:50%; width:50%;"></a>
            </li>
          
          <?php
            }
          }
          else 
            echo "You have no pictures in your ReelLife album! Get the app and start your reel!";
          ?>
        </ul>
      </div>
    </div>
      </span>


    </div> 


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
    <script src="js/jquery.lightbox-0.5.js"></script>
    
    

    
  </body>
</html>​