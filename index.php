<?php
    // Required Variables
    $svcScope = "https://www.googleapis.com/auth/youtube.readonly";
    $authFile = "auth/client_secret.json";
    $oauthRedirect = "/";

    // Load the Composer library
    require "vendor/autoload.php";

    // Google OAuth Begins
    $client = new Google_Client();
    $client->setAuthConfig($authFile);
    $client->addScope($svcScope);
    $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . $oauthRedirect);

    // Begin User Prompt
    $authUrl = $client->createAuthUrl();
    $revoke = $client->revokeToken();
    echo '<a href="' . $authUrl . '" class="authButton">Auth</a> | <a href"' . $revoke . '">Revoke</a>';

    // Exchange code for auth token and do the request.
    if (isset($_GET['code'])) {
        $authtoken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($authtoken);
        $service = new Google_Service_YouTube($client);

        $queryParams = [
            'mine' => true
        ];

        $response = $service->liveBroadcasts->listLiveBroadcasts('id', $queryParams);
        $streamId = $response->items[0]->id;
        header('Location: https://www.youtube.com/live_chat?v=' . $streamId . '&is_popout=1&dark_theme=1');
        
    } else {
        echo '<script>console.log("Either something is munted, or you didn\'t actually log in.");</script>';
    }

?>

<html>
    <head>
        <title>YouTube Chat Loader v2.0 by @hyp3rstrike</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="inc/main.css"></script>
        <script src="inc/main.js" type="text/javascript"></script>
    </head>
    <body>

    </body>
</html>