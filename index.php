<?php
    session_set_cookie_params(["SameSite" => "none"]); //none, lax, strict
    session_set_cookie_params(["Secure" => "true"]); //false, true
    session_start();
    // Required Variables
    $svcScope = "https://www.googleapis.com/auth/youtube.readonly";
    $authFile = "auth/client_secret.json";
    $version = "2.0.0 [Stupid-Dick-Fuck]";

    // Load the Composer library
    require "vendor/autoload.php";

    // Google OAuth Begins *dramatic music*
    $client = new Google_Client();
    $client->setApplicationName('YouTube Chat Loader');
    $client->setAuthConfig($authFile);
    $client->addScope($svcScope);
    $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/ytchat');
    $client->setPrompt('consent');

    // Begin User Prompt
    $authUrl = $client->createAuthUrl();
    $revoke = $client->revokeToken();

    echo '
    <div class="d-grid gap-2 col-6 mx-auto">
        <img src="inc/ytchat-logo.png" class="img-fluid mx-auto" alt="..." width="100px">
        <h3 class="text-center">YouTube Chat Loader</h3>
        <p class="text-center">Click on Authenticate to fetch your next stream chat room.</p>
    </div>
    <div class="d-grid gap-2 col-6 mx-auto buttons console">
        <a href="' . $authUrl . '" class="btn btn-success" type="button">Authenticate</button></a>
        <button class="btn btn-danger" type="button" disabled>Revoke Access</button>
    </div>
    <div class="d-grid gap-2 col-6 mx-auto">
        <p class="text-center">Created by <a href="https://twitter.com/hyp3rstrike">@hyp3rstrike</a> | Version ' . $version . '</p>
    </div>
    ';

    // Exchange code for auth token and do the thing.
    if (isset($_GET['code'])) {
        $authtoken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($authtoken);
        $service = new Google_Service_YouTube($client);

        $queryParams = [
            'mine' => true
        ];

        $response = $service->liveBroadcasts->listLiveBroadcasts('snippet', $queryParams);
        $stream1id = $response->items[0]->id;
        $stream1name = $response->items[0]->title;
        $stream2id = $response->items[1]->id;
        $stream2name = $response->items[1]->title;
        $stream3id = $response->items[2]->id;
        $stream3name = $response->items[2]->title;

        print_r($stream1id);
        print_r($stream1name);

        // header('Location: https://www.youtube.com/live_chat?v=' . $stream1id . '&is_popout=1&dark_theme=1');
        
    } else {
        // or tell you something fucked up
        echo '<script>console.log("Either something is munted, or you didn\'t actually log in.");</script>';
    }

?>

<html>
    <head>
        <title>YouTube Chat Loader by @hyp3rstrike</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="inc/main.css"></script>
        <script src="inc/main.js" type="text/javascript"></script>
    </head>
    <body>
        

        <a href="privacy.html">Privacy Policy</a>
    </body>
</html>