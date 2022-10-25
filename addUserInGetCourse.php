<?php
    $name = '';
    $email = '';
    $phone = '';

    getUserData($name, $email, $phone);
    addUserInGetCourse($name, $email, $phone);
    
    function getUserData(&$name, &$email, &$phone){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $phone = $_GET['phone'];
    }
    
    function addUserInGetCourse($name, $email, $phone){
        $accountName = 'humansedtech';
        $secretKey = 'uQZ9kazGpcLUF3qptlWUS2wcLla1oVVwoK04noCtr9w9kCw2KkwTimet9gueLibIBEVvtacDLRf0EEBc7mDX10WzyrpEIpbGipN0C7o3KPBOybWCOipwzCT8URgjD3d9';
        
        $user = [];
        $user['user']['email'] = $email;
        $user['user']['phone'] = $phone;
        $user['user']['first_name'] = $name;
        $user['system']['refresh_if_exists'] = 1;
        
        $json = json_encode($user);
        $base64 = base64_encode($json);
        
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'https://' . $accountName . '.getcourse.ru/pl/api/users');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'action=add&key=' . $secretKey . '&params=' . $base64);
            $out = curl_exec($curl);
            $response = json_decode($out, true);
            if($response['success'] == 1 & $response['result']['user_status'] == 'updated'){
                echo 'Обновлены данные пользователя с id = '.$response['result']['user_id']."\n";
            } else if($response['success'] == 1 & $response['result']['user_status'] == 'added'){
                echo 'Добавлен пользователь с id = '.$response['result']['user_id']."\n";
            } else {
                echo 'Ошибка! Пользователь не добавлен';
            }
            curl_close($curl);
        } else {
            echo 'Failed initialization';
        }
    }
?>