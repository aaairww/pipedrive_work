<?php
$api_token = '37fbc4e2f53b2776fa62708be527c59032692980';
$company_domain = 'salesautomators2';

$data = array(
    'name' =>  'Test Select', 
    'field_type' => 'set',
);

$url = 'https://' . $company_domain . '.pipedrive.com/api/v1/dealFields?api_token=' . $api_token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

// преобразуем массив в JSON
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Указываем, что отправляем JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// Отключить SSL проверку, если ты ещё не настроил cacert.pem (убери потом!)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

echo 'Sending request...' . PHP_EOL;

$output = curl_exec($ch);

if ($output === false) {
    echo "cURL Error: " . curl_error($ch) . PHP_EOL;
    curl_close($ch);
    exit;
}

curl_close($ch);

// Декодируем JSON
$result = json_decode($output, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Ошибка JSON: " . json_last_error_msg() . PHP_EOL;
    exit;
}

// Проверяем результат
if (empty($result['data'])) {
    exit('Adding failed' . PHP_EOL);
}

if (!empty($result['data']['id'])) {
    echo 'Custom field was added successfully! (Custom field API key: ' . $result['data']['key'] . ')' . PHP_EOL;
}
?>
