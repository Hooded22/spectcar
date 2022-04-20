<?php
    function getEndpoint($controller, $uri, $withoutToken = FALSE) {
        if(!$withoutToken) {
            $auth = new AuthorizationController();
            $auth->authorizeEndpoint();
        }
        $strMethodName = $uri[3] . 'Action';
        $controller->{$strMethodName}($uri);
    }

    function createJWT($userId) {

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['user_id' => 123, 'current_timestamp' => $date = date('Y-m-d H:i:s')]);
        $secret = APP_SECRET_KEY;

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }
?>