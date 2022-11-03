<?php
// Данные о пользователе
    $name = '';
    $email = '';
    $phone = '';

// Добавочные поля
    $utm_source = '';
    $utm_medium = '';
    $utm_campaign = '';
    $utm_content = '';
    $utm_term = '';
    $web_date = '';

// Параметры сессии
    $gcpc = '';
    $gcao = '';

//Параметры сделки
    $offer_code = '555';
    $deal_cost = 0;
    
    getUserData($name, $email, $phone);
    getFieldsData($utm_source, $utm_medium, $utm_campaign, $utm_content, $utm_term, $web_date);
    getSeesionData($gcpc, $gcao);
    addOrderInGetCourse($name, $email, $phone, $utm_source, $utm_medium, $utm_campaign, $utm_content, $offer_code, $deal_cost, $gcpc, $gcao, $utm_term, $web_date);
    
    function getUserData(&$name, &$email, &$phone){
        $name = $_POST['Name'];
        $email = $_POST['Email'];
        $phone = $_POST['Phone'];
    }

    function getFieldsData(&$utm_source, &$utm_medium, &$utm_campaign, &$utm_content, &$utm_term, &$web_date){
        $utm_source = $_POST['Utm_source'];
        $utm_medium = $_POST['Utm_medium'];
        $utm_campaign = $_POST['Utm_campaign'];
        $utm_content = $_POST['Utm_content'];
        $utm_term = $_POST['Utm_term'];
        $web_date = $_POST['Web_date'];
    }

    function getSeesionData(&$gcpc, &$gcao){
        $gcpc = $_POST['Gcpc'];
        $gcao = $_POST['Gcao'];
    }
    
    function addOrderInGetCourse($name, $email, $phone, $utm_source, $utm_medium, $utm_campaign, $utm_content, $offer_code, $deal_cost, $gcpc, $gcao, $utm_term, $web_date){
        $accountName = 'pro-academy';
        $secretKey = 'SVfbuy1rN6ugdzbxo9G4Pmkgs2PfA72xba6W4WP0NifO9VzkvBLsobt5Vs0ZrqbpOgFZtVzQgWwwBz2iFjZQ8z1fuehYCHYEU6rpKFNAVFZ8hj686Jtk8zgQl18Eqgik';
        $group_name = ['Авто'];
        $quantity = 1;

        $addfields['utm_source'] = $utm_source;
        $addfields['utm_medium'] = $utm_medium;
        $addfields['utm_content'] = $utm_content;
        $addfields['utm_campaign'] = $utm_campaign;
        $addfields['utm_term'] = $utm_term;
        $addfields['web_date'] = $web_date;

        $order = [];
        $order['user']['email'] = $email;
        $order['user']['phone'] = $phone;
        $order['user']['first_name'] = $name;
        $order['user']['group_name'] = $group_name;
        $order['system']['refresh_if_exists'] = 1;
        $order['system']['return_payment_link'] = 0;
        $order['system']['return_deal_number'] = 0;
        $order['session']['gcpc'] = $gcpc;
        $order['session']['gcao'] = $gcao;
        $order['deal']['offer_code'] = $offer_code;
        $order['deal']['quantity'] = $quantity;
        $order['deal']['deal_cost'] = $deal_cost;
        $order['deal']['addfields'] = $addfields;
        
        $json = json_encode($order);
        $base64 = base64_encode($json);
        
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'https://' . $accountName . '.getcourse.ru/pl/api/deals');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'action=add&key=' . $secretKey . '&params=' . $base64);
            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        } else {
            echo 'Failed initialization';
        }
    }
?>