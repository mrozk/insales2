<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @var array $config Global blog configuration
 * @var Model_User $user Global Kohana user object
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?>
Привет админка
<?php
    /*
    foreach($usr_ins as $user)
    {

        $insales_api =  new InsalesApi('ddelivery', $user['passwd'], $user['shop'] );
       // print_r($xmlstring );
        /*
        $xml = simplexml_load_string($xmlstring);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        */
        //var_dump(array_map('ini_get', array('safe_mode', 'open_basedir')));
/*
        try
        {
           $result = $insales_api->api('DELETE', '/admin/js_tags/7223.xml');
        }
        catch( InsalesApiException $e)
        {
           echo 'error';

        }
        */
        //print_r($result);
        /*
        InsalesApi::insales_api_client();

       /// echo 'ozk';
       $xml = simplexml_load_string($xmlstring);
       $json = json_encode($xml);
       $array = json_decode($json,TRUE);
       //print_r($insales_api);
       // $array = json_decode($json,TRUE);
           $orders = $insales_api('POST', '/admin/delivery_variants.xml', $array);
        //var_dump($orders);
        //open_basedir is set

    }
*/
?>


<style type="text/css">
    .jumbotron{ padding-top: 40px; }
</style>