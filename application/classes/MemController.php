<?php
/**
 * Created by PhpStorm.
 * User: mrozk
 * Date: 7/29/14
 * Time: 9:25 AM
 */

class MemController{

    private static $memcacheInstance = null;

    public static function getMemcacheInstance(){
        if( self::$memcacheInstance == null ){
            self::$memcacheInstance = new Memcache;
            self::$memcacheInstance->connect('localhost', 11211) or die ("Could not connect to Memcache");
        }
        return self::$memcacheInstance;
    }

    public static function initSettingsMemcache( $url ){
        $memcache = self::getMemcacheInstance();
        if( !empty( $url ) ){
            $settings = $memcache->get($url);
            if( !$settings ){
                $query = DB::select( 'settings', 'shop', 'id')->from('insalesusers')->
                             where( 'shop', '=', $url )->as_object()->execute();
                if( isset( $query[0]->shop ) && !empty( $query[0]->shop ) ){
                    $settings = json_decode( $query[0]->settings );

                    $settings->insalesuser_id = $query[0]->id;

                    $memcache->set( $url, json_encode( $settings ) );
                    //print_r($settings);
                }else{
                    $settings = false;
                }
            }
            return $settings;
        }
        return false;
    }
}