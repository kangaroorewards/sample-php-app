<?php
// auth.php
require_once __DIR__ . '/config.php';

function getAccessToken() {
    // Check if token already exists in session
    session_start();
    if (isset($_SESSION['access_token']) && time() < $_SESSION['token_expires']) {
        return $_SESSION['access_token'];
    }
    
    // Request a new token
    $postData = http_build_query([
        'grant_type'      => 'password',
        'client_id'       => CLIENT_ID,
        'client_secret'   => CLIENT_SECRET,
        'username'        => USERNAME,
        'password'        => PASSWORD,
        'scope'           => 'admin',
        'application_key' => APPLICATION_KEY,
    ]);
    
    $ch = curl_init(OAUTH_TOKEN_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    $tokenData = json_decode($response, true);
    if (isset($tokenData['access_token'])) {
        $_SESSION['access_token'] = $tokenData['access_token'];
        $_SESSION['refresh_token'] = $tokenData['refresh_token'];
        $_SESSION['token_expires'] = time() + $tokenData['expires_in'];
        return $tokenData['access_token'];
    } else {
        die('Error fetching access token: ' . $response);
    }
}
