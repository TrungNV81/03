<?php
set_time_limit(600);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:81/Module03/public/export");
try {
    var_dump('cho trung');
    curl_exec($ch);
} catch (Exception $e) {
    var_dump($e);
};
curl_close($ch);
