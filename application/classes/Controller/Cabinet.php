<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet extends  Controller_Base{

    public function _extractPost(){
        $zabor = $this->request->post('zabor');
        if( empty( $zabor ) )
        {
            $this->request->post('zabor', '');
        }

        $pvz_companies = $this->request->post('pvz_companies');
        $cur_companies = $this->request->post('cur_companies');
        if( is_array( $pvz_companies ) )
        {
            $pvz_companies = implode( ',', $this->request->post('pvz_companies') );
        }
        else
        {
            $pvz_companies = '';
        }

        if( is_array( $cur_companies ) )
        {
            $cur_companies = implode( ',', $this->request->post('cur_companies') );
        }
        else
        {
            $cur_companies = '';
        }
        $this->request->post('pvz_companies', $pvz_companies);
        $this->request->post('cur_companies', $cur_companies);
        $address = $this->request->post('address');
        $this->request->post('address', json_encode($address));

        return json_encode(
            array( 'api' => $this->request->post('api'),
                   'rezhim' => $this->request->post('rezhim'),
                   'declared' => $this->request->post('declared'),
                   'width' => $this->request->post('width'),
                   'height' => $this->request->post('height'),
                   'length' => $this->request->post('length'),
                   'weight' => $this->request->post('weight'),
                   'status' => $this->request->post('status'),
                   'secondname' => $this->request->post('secondname'),
                   'firstname' => $this->request->post('firstname'),
                   'plan_width' => $this->request->post('plan_width'),
                   'plan_lenght' => $this->request->post('plan_lenght'),
                   'plan_height' => $this->request->post('plan_height'),
                   'plan_weight' => $this->request->post('plan_weight'),
                   'type' => $this->request->post('type'),
                   'pvz_companies' => $this->request->post('pvz_companies'),
                   'cur_companies' => $this->request->post('cur_companies'),
                   'from1' => $this->request->post('from1'),
                    'to1' => $this->request->post('to1'),
                    'val1' => $this->request->post('val1'),
                    'sum1' => $this->request->post('sum1'),
                    'from2' => $this->request->post('from2'),
                    'to2' => $this->request->post('to2'),
                    'val2' => $this->request->post('val2'),
                    'sum2' => $this->request->post('sum2'),
                    'from3' => $this->request->post('from3'),
                    'to3' => $this->request->post('to3'),
                    'val3' => $this->request->post('val3'),
                    'sum3' => $this->request->post('sum3'),
                    'okrugl' => $this->request->post('okrugl'),
                    'shag' => $this->request->post('shag'),
                    'zabor' => $this->request->post('zabor'),
                    'payment' => $this->request->post('payment'),
                    'address' => $this->request->post('address')
        ));


    }
    public function action_save()
    {
        $session = Session::instance();
        $insalesuser = (int)$session->get('insalesuser');
        if ( !empty( $insalesuser ) )
        {
            $insales_user = ORM::factory('InsalesUser', array('insales_id' => $insalesuser));
            if($insales_user->loaded())
            {
                $settings = $this->_extractPost();



                $query = DB::update( 'insalesusers')->set( array('settings' => $settings) )
                         ->where('insales_id','=', $insalesuser)->execute() ;

                $memcache = MemController::getMemcacheInstance();
                if( !empty( $insales_user->shop ) ){
                    $settings = json_decode($settings);
                    $settings->insalesuser_id = $insales_user->id;
                    $memcache->set( $insales_user->shop, json_encode( $settings ) );
                }

                Notice::add( Notice::SUCCESS,'Успешно сохранено' );
                $this->redirect( URL::base( $this->request ) . 'cabinet/' );
            }

        }
        else
        {
            Notice::add( Notice::ERROR,'Доступ только из админпанели магазина insales' );
            $this->redirect( URL::base( $this->request ) . 'cabinet/' );
        }
    }



    public function action_addway()
    {
        $session = Session::instance();
        $insalesuser = (int)$session->get('insalesuser');

        if ( $insalesuser )
        {

            $insales_user = ORM::factory('InsalesUser', array('insales_id' => $insalesuser));
            if ( $insales_user->loaded() )
            {
                $insales_api =  new InsalesApi( $insales_user->passwd, $insales_user->shop );
                $this->preClean( $insales_api );

                // Добавляем поля для хранения id заказа ddelivery
                $field = $this->isFieldExists($insales_api, 'ddelivery_id');
                if( $field == null ){
                    $payload = $this->getXmlField( 'ddelivery_id' );
                    $data = json_decode( $insales_api->api('POST', '/admin/fields.json', $payload) );
                }
                else{
                    $data = $field;
                }
                // Добавляем поля для хранения id заказа ddelivery

                // Добавляем поля для хранения id ddelivery_insales
                $field = $this->isFieldExists($insales_api, 'ddelivery_insales');
                if( $field == null ){
                    $payload = $this->getXmlField( 'ddelivery_insales' );
                    $data2 = json_decode( $insales_api->api('POST', '/admin/fields.json', $payload) );
                }else{
                    $data2 = $field;
                }
                // Добавляем поля для хранения id ddelivery_insales

                // Добавляем поля для оформления заказа
                /*
                $payload  = $this->getXmlAddress( 'street', 'Улица' );
                $addr_fields =  json_decode( $insales_api->api('POST', '/admin/fields.json', $payload) );
                $data_fields['street'] = $addr_fields->id;
                $payload  = $this->getXmlAddress( 'house', 'Дом' );
                $addr_fields =  json_decode( $insales_api->api('POST', '/admin/fields.json', $payload) );
                $data_fields['house'] = $addr_fields->id;
                $payload  = $this->getXmlAddress( 'flat', 'Квартира' );
                $addr_fields =  json_decode( $insales_api->api('POST', '/admin/fields.json', $payload) );
                $data_fields['flat'] = $addr_fields->id;
                $payload  = $this->getXmlAddress( 'corp', 'Корпус' );
                $addr_fields =  json_decode( $insales_api->api('POST', '/admin/fields.json', $payload) );
                $data_fields['corp'] = $addr_fields->id;
                */
                // Добавляем поля для оформления заказа

                // Добавляем Способ доставки
                $payload = $this->getShippingMethod( );
                $delivery = json_decode( $insales_api->api('POST', '/admin/delivery_variants.json', $payload) );
                // Добавляем Способ доставки
                $payload = $this->getWidgetXml();
                $w = $insales_api->api('POST', '/admin/application_widgets.xml  ', $payload);
                // Добавляем JS
                $payload = $this->getXmlJsToInsales( $insales_user->id, $data->id, $data2->id, $delivery->id);
                json_decode( $insales_api->api('PUT', '/admin/delivery_variants/' . $delivery->id . '.json', $payload) );
                // Добавляем JS

                // Подписываемся на хук на создание заказа
                $payload = $this->getXmlCreateHook( $insales_user->id );
                $insales_api->api('POST', '/admin/webhooks.xml', $payload) ;
                // Подписываемся на хук на создание заказа

                // Подписываемся на хук на обновление заказа
                $payload = $this->getXmlUpdateHook( $insales_user->id );
                $insales_api->api('POST', '/admin/webhooks.xml', $payload) ;
                // Подписываемся на хук на обновление заказа

                $insales_user->delivery_variant_id = $delivery->id;
                $insales_user->save();

                Notice::add( Notice::SUCCESS,'Способ доставки успешно добавлен' );
                $this->redirect( URL::base( $this->request ) . 'cabinet/' );
            }
        }
    }

    public function getWidgetXml(){
        return $pulet = "<application-widget>
<code>
  &lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot;&gt;
  &lt;head&gt;
    &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;/&gt;
    &lt;style&gt;
      table#statuses {
        border-collapse: collapse;
        border-right: 1px solid black;
        border-left: 1px solid black;
      }
      table#statuses td, table#statuses th {
        border: 1px solid black;
      }
    &lt;/style&gt;
  &lt;/head&gt;
  &lt;body&gt;

    &lt;table id='statuses' style='border: 1px solid black;'&gt;

    &lt;/table&gt;

    &lt;script&gt;

      var data = {};
      // функция которая вызывается во внешнем js файле и устанавливает значение переменной data
      function set_data(input_object) {
        data = input_object;
      }
      var table = document.getElementById('statuses');

      // устанавливаем номер заказа, используя id из переменной window.order_info
      var order_number_field = document.getElementById('order_number');
      // order_number_field.innerHTML = window.order_info.id;
      fields = window.order_info.fields_values;
      size = fields.length;
      var i = 0;
      var green_lite = 0;
      var ddelivery_id = 0;
      while(size != 0){
        if( fields[size - 1].name == 'ddelivery_id' ){
            if(fields[size - 1].value != 0){
                green_lite = 1;
                ddelivery_id = fields[size - 1].value;
            }
        }

        size--;
      };
      if( green_lite != 0 ){
                // подключаем скрипт который передаёт нам данные через JSONP
          var script = document.createElement('script');
          script.src = '" . URL::base( $this->request ) . "sdk/orderinfo/?order=' + ddelivery_id;
          document.documentElement.appendChild(script);

          // после отработки внешнего скрипта, заполняем таблицу пришедшими данными
          script.onload = function() {
              for (var key in data) {
                  var new_tr = document.createElement('tr');
                  new_tr.innerHTML= '&lt;td&gt;'+ key +'&lt;/td&gt;&lt;td&gt;'+ data[key] +'&lt;/td&gt;';
              table.appendChild(new_tr);
            }
          }
      }
    &lt;/script&gt;
  &lt;/body&gt;
  &lt;/html&gt;
</code>
<height>200</height>
</application-widget>";
    }
    public function isFieldExists( $insales_api, $fname ){
        $data = json_decode( $insales_api->api('GET', '/admin/fields.json') );
        if( count($data) )
        {
            foreach( $data as $item )
            {
                if( ( $item->office_title == $fname )  )
                    //$insales_api->api('DELETE', '/admin/fields/' . $item->id . '.json');
                return $item;
            }
        }
        return null;
    }
    public function preClean( $insales_api )
    {
        $data = json_decode( $insales_api->api('GET', '/admin/webhooks.json') );
        if( count($data) )
        {
            foreach( $data as $item )
            {

                if( substr_count( $item->address, URL::base( $this->request ) ) )
                {
                   $insales_api->api('DELETE', '/admin/webhooks/' . $item->id . '.json');
                }
            }
        }
        /*
        $data = json_decode( $insales_api->api('GET', '/admin/fields.json') );
        if( count($data) )
        {
            foreach( $data as $item )
            {
                if( ( $item->office_title == 'ddelivery_id' ) || ( $item->office_title == 'ddelivery_insales' ) )
                    $insales_api->api('DELETE', '/admin/fields/' . $item->id . '.json');

            }
        }
        */
        $data = json_decode( $insales_api->api('GET', '/admin/application_widgets.json') );
        if( count($data) )
        {
            foreach( $data as $item )
            {
                $insales_api->api('DELETE', '/admin/application_widgets/' . $item->id . '.json');
            }
        }
        $data = json_decode( $insales_api->api('GET', '/admin/delivery_variants.json') );
        if( count($data) )
        {
            foreach( $data as $item )
            {
                if( $item->title == 'DDelivery' )
                    $insales_api->api('DELETE', '/admin/delivery_variants/' . $item->id . '.json');
            }
        }

        $data = json_decode( $insales_api->api('GET', '/admin/delivery_variants.json') );
        if( count($data) )
        {
            foreach( $data as $item )
            {
                if( $item->title == 'DDelivery' )
                    $insales_api->api('DELETE', '/admin/delivery_variants/' . $item->id . '.json');
            }
        }
    }
    /*
    public function getXmlAddress( $name, $human_title ){
        return $pulet = '<field>
                                <active type="boolean">true</active>
                                <destiny type="integer">1</destiny>
                                <for-buyer type="boolean">true</for-buyer>
                                <obligatory type="boolean">false</obligatory>
                                <office-title>' . $human_title . '</office-title>
                                <position type="integer">4</position>
                                <show-in-checkout type="boolean">true</show-in-checkout>
                                <show-in-result type="boolean">true</show-in-result>
                                <system-name>' . $name .'</system-name>
                                <title>' . $human_title . '</title>
                                <example></example>
                                <type>Field::TextField</type>
                           </field>';
    }
    */
    public function getShippingMethod(){
        return $payload = '<?xml version="1.0" encoding="UTF-8"?>
                            <delivery-variant>
                              <title>DDelivery</title>
                              <position type="integer">1</position>
                              <url>' . URL::base( $this->request ) . 'hello/gus/</url>
                              <description>Доставка товаров во все населенные пункты России + пункты самовывоза в 150 городах</description>
                              <type>DeliveryVariant::External</type>
                              <delivery-locations type="array"/>
                              <javascript></javascript>
                              <price type="decimal">0</price>
                              <add-payment-gateways>true</add-payment-gateways>
                            </delivery-variant>';
    }
    public function getXmlField( $name )
    {
        return $pulet = '<field>
                          <type>Field::TextField</type>
                          <for-buyer type="boolean">false</for-buyer>
                          <office-title>' . $name . '</office-title>
                          <obligatory type="boolean">false</obligatory>
                          <title>' . $name . '</title>
                          <destiny type="integer">3</destiny>
                          <for-buyer type="boolean">true</for-buyer>
                          <show-in-checkout type="boolean">true</show-in-checkout>
                          <show-in-result type="boolean">false</show-in-result>
                        </field>';
    }
    public function getXmlUpdateHook( $insalesuser )
    {
        return $payload = '<webhook>
                               <address>' . URL::base( $this->request ) . 'orders/update/?mag_id=' .
                               $insalesuser . '</address>
                               <topic>orders/update</topic>
                               <format type="integer">1</format>
                           </webhook>';
    }
    public function getXmlCreateHook( $insalesuser )
    {
        return $payload = '<webhook>
                               <address>' . URL::base( $this->request ) . 'orders/create/?mag_id=' .
                               $insalesuser . '</address>
                               <topic>orders/create</topic>
                               <format type="integer">1</format>
                           </webhook>';
    }
    public function getXmlJsToInsales( $insalesuser_id, $field_id, $field2_id, $deliveryID)
    {
        return $payload = '<?xml version="1.0" encoding="UTF-8"?>
                            <delivery-variant>
                              <id type="integer">' . $deliveryID . '</id>
                              <javascript>&lt;script type="text/javascript" src="' . URL::base( $this->request ) . 'html/js/ddelivery.js"&gt;&lt;/script&gt;
                                     &lt;script type="text/javascript"&gt;var ddelivery_insales={
                                     "delivery_id" : ' . $deliveryID . ',
                                     "field_id":' . $field_id . ',
                                     "field2_id":' . $field2_id . ',"_id":' . $insalesuser_id . ',
                                     "url": "' . URL::base( $this->request ) . '"
                                       };
                                       &lt;/script&gt;
                                    &lt;script type="text/javascript" src="' . URL::base( $this->request ) . 'html/action.js"&gt;&lt;/script&gt;
                              </javascript>
                            </delivery-variant>';
    }

    public function getPaymentWays( $passwd, $shop )
    {
        $options = array();
        $insales_api =  new InsalesApi( $passwd, $shop );
        $payment_gateways = json_decode( $insales_api->api('GET', '/admin/payment_gateways.json') );


        $options[0] = 'Выберитите поле';
        if( count( $payment_gateways ) )
        {
            foreach( $payment_gateways as $gateways )
            {
                $options[$gateways->id] = $gateways->title;
            }
        }
        return $options;
    }

    public function getStatuses( $passwd, $shop )
    {
        // $insales_api =  new InsalesApi('ddelivery', $passwd, $shop );
        // $status = json_decode( $insales_api->api('GET', '/admin/payment_gateways.json') );

    }
    public function action_index()
    {

        $insales_id = (int)$this->request->query('insales_id');
        $shop = $this->request->query('shop');
        if( !$insales_id ){
            $session = Session::instance();
            $insalesuser = (int)$session->get('insalesuser');
        }

        if ( isset($insalesuser) && !empty( $insalesuser ) )
        {
            $usersettings = ORM::factory('InsalesUser', array('insales_id' => $insalesuser));
            $payment = $this->getPaymentWays( $usersettings->passwd, $usersettings->shop );
            $fields = $this->getFields( $usersettings->passwd, $usersettings->shop );
            $addr_fields = $this->getAddressFields( $usersettings->passwd, $usersettings->shop );

            $this->template->set('content', View::factory('panel')->set('usersettings', $usersettings )
                           ->set('addr_fields', $addr_fields)
                           ->set('payment', $payment)->set('fields', $fields)->set('base_url', URL::base( $this->request )));

            }
        else
        {

            if( !empty( $insales_id ) && !empty( $shop ) )
            {

                $this->_proccess_enter($insales_id, $shop);
            }
            else
            {
                echo 'Вход осуществляется через личный кабинет insales.ru';
                Notice::add( Notice::ERROR,'Доступ только из админпанели магазина insales' );
            }
        }
    }

    public function getAddressFields( $passwd, $shop )
    {
        $options = array();
        $insales_api =  new InsalesApi($passwd, $shop );
        /*
        $payment_gateways = json_decode( $insales_api->api('GET', '/admin/option_names.json') );
        */
        $payment_gateways = json_decode( $insales_api->api('GET', '/admin/fields.json') );
        //print_r($payment_gateways);
        $options[0] = 'Выберитите поле';
        if( count( $payment_gateways ) )
        {
            foreach( $payment_gateways as $gateways )
            {
                if($gateways->for_buyer && ($gateways->type !='Field::Phone')){
                    $options[$gateways->id] = $gateways->office_title;
                }
            }
        }

        return $options;
    }

    public function getFields( $passwd, $shop )
    {
        $options = array();
        $insales_api =  new InsalesApi($passwd, $shop );
        /*
        $payment_gateways = json_decode( $insales_api->api('GET', '/admin/option_names.json') );
        */
        $payment_gateways = json_decode( $insales_api->api('GET', '/admin/product_fields.json') );
        //print_r($payment_gateways);
        $options[0] = 'Выберитите поле';
        if( count( $payment_gateways ) )
        {
              foreach( $payment_gateways as $gateways )
              {
                  $options[$gateways->id] = $gateways->title;
              }
        }

        return $options;
    }
    public function action_autologin()
    {

        $insales_token = $this->request->query('token');

        $session = Session::instance();
        $token = $session->get('ddelivery_token');
        $insales_id = $session->get('token_insales_id');
        echo $token;
        echo $insales_id;

        $insales_user = ORM::factory('InsalesUser', array('insales_id' => $insales_id));
        if( $insales_user->loaded() )
        {
            if( $insales_token == md5( $token . $insales_user->passwd ) )
            {
                $session->set('insalesuser', $insales_id);
                $this->redirect( URL::base( $this->request ) . 'cabinet/' );
            }
            else
            {
                echo 'Invalid token';
            }
        }
        else
        {
            echo 'shop no found';
        }

    }

    private function _proccess_enter( $insales_id, $shop )
    {
        $back_url = URL::base( $this->request ) . 'cabinet/autologin/';
        $token = md5( time() . $insales_id );

        $session = Session::instance();
        $session->set('ddelivery_token', $token);
        $session->set('token_insales_id', $insales_id);

        $url = 'http://' . $shop . '/admin/applications/' . InsalesApi::$api_key . '/login?token=' . $token . '&login=' . $back_url;

        $this->redirect( $url );
    }

}