<?php
    session_set_cookie_params(["SameSite" => "none"]); //none, lax, strict
    session_set_cookie_params(["Secure" => "true"]); //false, true
    session_start();
    // Required Variables
    $svcScope = "https://www.googleapis.com/auth/youtube.readonly";
    $authFile = "auth/client_secret.json";
    $version = "2.0.1";

    // Load the Composer library
    require "vendor/autoload.php";

    // Google OAuth Begins *dramatic music*
    $client = new Google_Client();
    $client->setAuthConfig($authFile);
    $client->addScope($svcScope);
    $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/ytchat');
    $client->setPrompt('select_account');

    // Begin User Prompt
    $authUrl = $client->createAuthUrl();

    function revokeToken() {
        $revoke = $client->revokeToken();
        echo '<script>console.log("Token revoked")</script>';
    }
    // Exchange code for auth token and do the thing.
    if (isset($_GET['code'])) {
        $authtoken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($authtoken);
        $service = new Google_Service_YouTube($client);

        $queryParams = [
            'mine' => true
        ];

        

        $response = $service->liveBroadcasts->listLiveBroadcasts('id', $queryParams);
        $streamId = $response->items[0]->id;
        $streamName = $response->items[0]->title;
        header('Location: https://www.youtube.com/live_chat?v=' . $streamId . '&is_popout=1&dark_theme=1');

        echo $streamName;
        
    } else {
        // or tell you something fucked up
        echo '<script>console.log("Either something is munted, or you didn\'t actually log in.");</script>';
    }

?>

<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="inc/main.css"></script>
        <script src="inc/main.js" type="text/javascript"></script>
        <title>YouTube Chat Loader v<?php echo $version?> by @hyp3rstrike</title>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="#">
                    <img src="inc/ytchat-logo.png" alt="" width="30" height="24"> YouTube Chat Loader
                    </a>

                    <div class="pull-right">
                        <a href="<?php echo $authUrl ?>" class="btn btn-success btn-sm" type="button">Login</button></a>
                    </div>
                </div>
            </nav>
            <div class="alert alert-light" role="alert">
                <h4 class="alert-heading">What does this app do?</h4>
                    <p>This app uses the <a href="https://developers.google.com/youtube/v3/">YouTube Data API V3</a> to fetch the unique video ID string given to your YouTube livestreams. Once the ID string has been located in the API, this app will automatically load the relevant chat window.</p>
                    <hr>
                    <p>Please note that in order to use this app, you must click "Login" and log in with your Google account.</p>
            </div>

            <div class="mx-auto">
                <p class="text-center">
                    Created by <a href="https://twitter.com/hyp3rstrike">@hyp3rstrike</a> | <a href="https://github.com/hyp3rstrike/ytchat-loader">GitHub</a> | <a href="privacy.html">Privacy Policy</a> | Version <?php echo $version ?>
                </p>
            </div>
        </div> 
    </body>
</html>