<?php defined('SYSPATH') or die('No direct script access.');?>
<style type="text/css">
    .form-group{
        margin-top: 10px;
        clear: both;
    }
    .form-group
    {
        padding-top: 20px;
    }
    .bg-success
    {
        padding: 10px;
    }
</style>
<?php

if( empty($usersettings->settings) ){
    $settings =
        array(
            'api' => '',
            'rezhim' => '',
            'declared' => '',
            'width' => '',
            'height' => '',
            'length' => '',
            'weight' => '',
            'status' => '',
            'secondname' => '',
            'firstname' => '',
            'plan_width' => '',
            'plan_lenght' => '',
            'plan_height' => '',
            'plan_weight' => '',
            'type' => '',
            'pvz_companies' => '',
            'cur_companies' => '',
            'from1' => '',
            'to1' => '',
            'val1' => '',
            'sum1' => '',
            'from2' => '',
            'to2' => '',
            'val2' => '',
            'sum2' => '',
            'from3' =>'',
            'to3' => '',
            'val3' => '',
            'sum3' => '',
            'okrugl' => '',
            'shag' => '',
            'zabor' => '',
            'payment' => '',
            'address' => ''
        );
}else{
    $settings = json_decode( $usersettings->settings, true );
}
?>
<?php

if(empty($settings['address'])){
    $address = array('street' => '','house' => '','corp' => '','flat' => '');
}else{
    $address = json_decode($settings['address'],true);
}
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<!--
<div class="jumbotron">
    <div class="container">
        <h1>Hello, world!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
    </div>
</div>
-->
<?php
    $pvz_companies = explode( ',', $settings['pvz_companies'] );
    $cur_companies = explode( ',', $settings['cur_companies'] );
?>
            <h1>Настройки</h1>
<div class="navbar-collapse collapse">
    <div class="navbar-form navbar-right">
        <button type="submit" onclick="jQuery('#insales-form').submit();"  class="btn btn-success">Сохранить</button>
    </div>
    <div class="navbar-form navbar-right">
        <a href="<?php echo $base_url . 'cabinet/addway/'?>"  class="btn btn-success">Добавить способ доставки в Insales</a>
    </div>
    <div class="navbar-form navbar-left">
        <a href="http://<?php echo $usersettings->shop . '/admin/installed_applications/';  ?>"  class="btn  btn-warning">Вернуться в кабинет</a>
    </div>

</div><!--/.navbar-collapse -->
            <form role="form" id="insales-form" action="<?php echo $base_url . 'cabinet/save/';?>" method="post">
                <h3>Магазин <?php echo $usersettings->shop; ?></h3>

                <p class="bg-success" >
                    Уважаемые пользователи! Мы постарались сделать настройки наиболее гибкими,
                    но от вас требуется внимательность при выборе параметров. Если Вам непонятно
                    значение каких-то настроек, просим связатся с менеджерами DD. В случае, если
                    Вам потребуется больше настроек, так же просим связатся с клиентским отделом.
                </p>

                <h3>Основые</h3>


                <div class="form-group" >

                    <label for="inputEmail3" class="col-sm-10 control-label">API ключ из личного кабинета
                        <p class="bg-success" >
                            Ключ можно получить в личном кабинете DDelivery.ru, зарегистрировавшись на сайте ( для новых клиентов )
                        </p>
                    </label>

                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'placeholder' => 'API ключ из личного кабинета',
                                'class' => 'form-control',
                                'required' => ''
                            );
                            echo Form::input('api', $settings['api'], $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rezhim" class="col-sm-10 control-label">Режим работы
                        <p class="bg-success" >
                            Для отладки модуля используйте пожалуйста режим тестирования.
                        </p>

                    </label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'class' => 'form-control'
                            );
                            $options = array(
                                '1' => 'Тестирование (stage.ddelivery.ru)',
                                '2' => 'Рабочий (cabinet.ddelivery.ru)'
                            );
                            echo Form::select('rezhim', $options, $settings['rezhim'], $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="declared" class="col-sm-10 control-label">Какой % от стоимости товара страхуется
                        <p class="bg-success" >
                            Вы можете снизить оценочную стоимость для уменьшения стоимости
                            доставки за счет снижения размеров страховки
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Какой % от стоимости товара страхуется',
                                'class' => 'form-control'
                            );
                            echo Form::input('declared', (isset($settings['declared'])?$settings['declared']:100), $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <h3>Соответствие полей</h3>
                </div>
                <div class="form-group">
                    <label for="width" class="col-sm-10 control-label">Оплата на месте
                        <p class="bg-success" >
                            Выберите поле соответствующее способу оплаты "оплата на месте".
                            Например "оплата курьеру". У вас в системе может быть только 1 такой способ
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'class' => 'form-control'
                            );
                        ///print_r($payment);
                        echo Form::select('payment', $payment, $settings['payment'], $attrs);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="width" class="col-sm-10 control-label">Ширина
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "ширина товара" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php

                            $attrs = array(
                                'class' => 'form-control'
                            );

                            echo Form::select('width', $fields, $settings['width'], $attrs);

                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="length" class="col-sm-10 control-label">Длина
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "длина товара" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php

                            $attrs = array(
                                'class' => 'form-control'
                            );

                            echo Form::select('length', $fields, $settings['length'], $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="height" class="col-sm-10 control-label">Высота
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "высота товара" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php


                            $attrs = array(
                                'class' => 'form-control'
                            );

                            echo Form::select('height', $fields, $settings['height'], $attrs);

                        ?>
                    </div>
                </div>



                <div class="form-group" >
                    <label for="status" class="col-sm-10 control-label">
                        Статус для отправки
                        <p class="bg-success" >
                            Выберите статус при котором заявки из вашей системы будут уходить в DDelivery.
                            Помните что отправка означает готовность отгрузить заказ на следующий рабочий день
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php

                            $attrs = array(
                                'class' => 'form-control'
                            );
                            $options = array(
                                'new' => 'новый',
                                'accepted' => 'в обработке',
                                'approved' => 'согласован',
                                'dispatched' => 'отгружен',
                                'delivered' => 'доставлен',
                                'declined' => 'отменен',
                            );
                            echo Form::select('status', $options, $settings['status'], $attrs);

                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <h3>Соответствие полей оформления заказа</h3>
                </div>
                <div class="form-group" >
                    <label for="height" class="col-sm-10 control-label">Улица
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "Улица" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php


                        $attrs = array(
                            'class' => 'form-control'
                        );

                        echo Form::select('address[street]', $addr_fields, $address['street'], $attrs);

                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="height" class="col-sm-10 control-label">Номер дома
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "Номер дома" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php


                        $attrs = array(
                            'class' => 'form-control'
                        );

                        echo Form::select('address[house]', $addr_fields, $address['house'], $attrs);

                        ?>
                    </div>
                </div>

                <div class="form-group" >
                    <label for="height" class="col-sm-10 control-label">Корпус
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "Корпус" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php


                        $attrs = array(
                            'class' => 'form-control'
                        );

                        echo Form::select('address[corp]', $addr_fields, $address['corp'], $attrs);

                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="height" class="col-sm-10 control-label">Квартира
                        <p class="bg-success" >
                            Выберите поле, соответствуещее "Квартира" в Вашей системе
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php


                        $attrs = array(
                            'class' => 'form-control'
                        );

                        echo Form::select('address[flat]', $addr_fields, $address['flat'], $attrs);

                        ?>
                    </div>
                </div>



                <div class="form-group" >
                    <h3>Габариты по умолчанию</h3>
                    <p class="bg-success" >
                        Данные габариты используются для определения цены доставки в случае, если у товара не прописаны размеры. Просим внимательней отнестись к ввод данных полей
                    </p>
                </div>
                <div class="form-group" >
                    <label for="plan_width" class="col-sm-10 control-label">Ширина, см


                    </label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Ширина, см',
                                'class' => 'form-control'
                            );
                            echo Form::input('plan_width', (isset($settings['plan_width'])?$settings['plan_width']:10), $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="plan_length" class="col-sm-6 control-label">Длина, см</label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Длина, см',
                                'class' => 'form-control'
                            );
                            echo Form::input('plan_lenght', (isset($settings['plan_lenght'] )?$settings['plan_lenght']:10), $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="plan_height" class="col-sm-6 control-label">Высота, см</label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Высота, см',
                                'class' => 'form-control'
                            );
                            echo Form::input('plan_height', (isset($settings['plan_height'] )?$settings['plan_height']:10), $attrs);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="plan_weight" class="col-sm-6 control-label">Вес</label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Вес, кг',
                                'class' => 'form-control'
                            );
                            echo Form::input('plan_weight', (isset($settings['plan_weight'])?$settings['plan_weight']:1), $attrs);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <h3>Настройка способов доставки</h3>
                </div>
                <div class="form-group" >
                    <label for="avalible_way" class="col-sm-6 control-label">Доступные способы
                        <p class="bg-success" >
                            Настройка влияет на то, какие методы будут отображатся
                        </p>
                    </label>
                    <div class="col-sm-10">
                        <?php
                            $attrs = array(
                                'class' => 'form-control'
                            );
                            $options = array(
                                '1' => 'ПВЗ и Курьеры',
                                '2' => 'ПВЗ',
                                '3' => 'Курьеры'
                            );
                            echo Form::select('type', $options, $settings['type'], $attrs);
                        ?>

                    </div>
                </div>
                <div class="form-group">
                    <h4>Доступные компании ПВЗ</h4>
                    <p class="bg-success" >
                        Выберите компании доставки, которые вы бы хотели сделать НЕ доступными для для ваших клиентов
                    </p>
                </div>
                <div class="form-group" >
                    <label class="checkbox-inline">
                        <?php

                            echo Form::checkbox('pvz_companies[]', '4', in_array('4', $pvz_companies) );
                        ?>
                        Boxberry
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                            echo Form::checkbox('pvz_companies[]', '21', in_array('21', $pvz_companies) );
                        ?>
                        Boxberry Express
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                            echo Form::checkbox('pvz_companies[]', '29', in_array('29', $pvz_companies) );
                        ?>
                        DPD Classic
                    </label>
                </div>


                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                            echo Form::checkbox('pvz_companies[]', '23', in_array('23', $pvz_companies) );
                        ?>
                        DPD Consumer
                    </label>
                </div>


                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                            echo Form::checkbox('pvz_companies[]', '27', in_array('27', $pvz_companies) );
                        ?>
                        DPD ECONOMY
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '28', in_array('28', $pvz_companies) );
                        ?>
                        DPD Express
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '20', in_array('20', $pvz_companies) );
                        ?>
                        DPD Parcel
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '30', in_array('30', $pvz_companies) );
                        ?>
                        EMS
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '31', in_array('31', $pvz_companies) );
                        ?>
                        Grastin
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '11', in_array('11', $pvz_companies) );
                        ?>
                        Hermes
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '16', in_array('16', $pvz_companies) );
                        ?>
                        IM Logistics Пушкинская
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '22', in_array('22', $pvz_companies) );
                        ?>
                        IM Logistics Экспресс
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '17', in_array('11', $pvz_companies) );
                        ?>
                        IMLogistics
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '3', in_array('3', $pvz_companies) );
                        ?>
                        Logibox
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '14', in_array('14', $pvz_companies) );
                        ?>
                        Maxima Express
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '1', in_array('1', $pvz_companies) );
                        ?>
                        PickPoint
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '13', in_array('13', $pvz_companies) );
                        ?>
                        КТС
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '18', in_array('18', $pvz_companies) );
                        ?>
                        Сам Заберу
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '6', in_array('6', $pvz_companies) );
                        ?>
                        СДЭК забор
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '26', in_array('26', $pvz_companies) );
                        ?>
                        СДЭК Посылка
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '25', in_array('25', $pvz_companies) );
                        ?>
                        СДЭК Посылка Самовывоз
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '24', in_array('24', $pvz_companies) );
                        ?>
                        Сити Курьер
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('pvz_companies[]', '7', in_array('7', $pvz_companies) );
                        ?>
                        QIWI Post
                    </label>
                </div>

                <div class="form-group" >
                    <h4>Доступные компании Курьерская доставка</h4>
                    <p class="bg-success" >
                        Выберите компании доставки, которые вы бы хотели сделать НЕ доступными для для ваших клиентов
                    </p>
                </div>

                <div class="form-group" >
                    <label class="checkbox-inline">
                        <?php

                        echo Form::checkbox('cur_companies[]', '4', in_array('4', $cur_companies) );
                        ?>
                        Boxberry
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '21', in_array('21', $cur_companies) );
                        ?>
                        Boxberry Express
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '29', in_array('29', $cur_companies) );
                        ?>
                        DPD Classic
                    </label>
                </div>


                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '23', in_array('23', $cur_companies) );
                        ?>
                        DPD Consumer
                    </label>
                </div>


                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '27', in_array('27', $cur_companies) );
                        ?>
                        DPD ECONOMY
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '28', in_array('28', $cur_companies) );
                        ?>
                        DPD Express
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '20', in_array('20', $cur_companies) );
                        ?>
                        DPD Parcel
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '30', in_array('30', $cur_companies) );
                        ?>
                        EMS
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '31', in_array('31', $cur_companies) );
                        ?>
                        Grastin
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '11', in_array('11', $cur_companies) );
                        ?>
                        Hermes
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '16', in_array('16', $cur_companies) );
                        ?>
                        IM Logistics Пушкинская
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '22', in_array('22', $cur_companies) );
                        ?>
                        IM Logistics Экспресс
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '17', in_array('11', $cur_companies) );
                        ?>
                        IMLogistics
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '3', in_array('3', $cur_companies) );
                        ?>
                        Logibox
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '14', in_array('14', $cur_companies) );
                        ?>
                        Maxima Express
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '1', in_array('1', $cur_companies) );
                        ?>
                        PickPoint
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '13', in_array('13', $cur_companies) );
                        ?>
                        КТС
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '18', in_array('18', $cur_companies) );
                        ?>
                        Сам Заберу
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '6', in_array('6', $cur_companies) );
                        ?>
                        СДЭК забор
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '26', in_array('26', $cur_companies) );
                        ?>
                        СДЭК Посылка
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '25', in_array('25', $cur_companies) );
                        ?>
                        СДЭК Посылка Самовывоз
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '24', in_array('24', $cur_companies) );
                        ?>
                        Сити Курьер
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <?php
                        echo Form::checkbox('cur_companies[]', '7', in_array('7', $cur_companies) );
                        ?>
                        QIWI Post
                    </label>
                </div>

                <div class="form-group" >
                    <h3>Настройка цены доставки</h3>
                    <p class="bg-success" >
                        Как меняется стоимость доставки в зависимости от размера заказа в руб. Вы можете гибко настроить
                        условия доставки,чтобы учесть вашу маркетинговую политику.
                    </p>
                </div>

                <div class="navbar-form" >

                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'placeholder' => 'От',
                                'class' => 'form-control'
                            );
                            echo Form::input('from1', $settings['from1'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'placeholder' => 'До',
                                'class' => 'form-control'
                            );
                            echo Form::input('to1', $settings['to1'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'class' => 'form-control',
                                'style' => 'width: 200px;'
                            );
                            $options = array(
                                '1' => 'Клиент оплачивает все',
                                '2' => 'Магазин оплачивает все',
                                '3' => 'Магазин оплачивает процент от стоимости доставки',
                                '4' => 'Магазин оплачивает конкретную сумму от доставки. Если сумма больше, то всю доставку<'
                            );
                            echo Form::select('val1', $options, $settings['val1'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Сумма',
                                'class' => 'form-control'
                            );
                            echo Form::input('sum1', $settings['sum1'], $attrs);
                        ?>
                    </div>
                </div>

                <div class="navbar-form" >
                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'placeholder' => 'От',
                            'class' => 'form-control'
                        );
                        echo Form::input('from2', $settings['from2'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'placeholder' => 'До',
                            'class' => 'form-control'
                        );
                        echo Form::input('to2', $settings['to2'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'class' => 'form-control',
                            'style' => 'width: 200px;'
                        );
                        $options = array(
                            '1' => 'Клиент оплачивает все',
                            '2' => 'Магазин оплачивает все',
                            '3' => 'Магазин оплачивает процент от стоимости доставки',
                            '4' => 'Магазин оплачивает конкретную сумму от доставки. Если сумма больше, то всю доставку<'
                        );
                        echo Form::select('val2', $options, $settings['val2'], $attrs);
                        ?>
                    </div>


                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'placeholder' => 'Сумма',
                            'class' => 'form-control'
                        );
                        echo Form::input('sum2', $settings['sum2'], $attrs);
                        ?>
                    </div>
                </div>

                <div class="navbar-form" >
                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'placeholder' => 'От',
                            'class' => 'form-control'
                        );
                        echo Form::input('from3', $settings['from3'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'placeholder' => 'До',
                            'class' => 'form-control'
                        );
                        echo Form::input('to3', $settings['to3'], $attrs);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'class' => 'form-control',
                                'style' => 'width: 200px;'
                            );
                            $options = array(
                                '1' => 'Клиент оплачивает все',
                                '2' => 'Магазин оплачивает все',
                                '3' => 'Магазин оплачивает процент от стоимости доставки',
                                '4' => 'Магазин оплачивает конкретную сумму от доставки. Если сумма больше, то всю доставку<'
                            );
                            echo Form::select('val3', $options, $settings['val2'], $attrs);
                        ?>
                    </div>


                    <div class="form-group">
                        <?php
                        $attrs = array(
                            'placeholder' => 'Сумма',
                            'class' => 'form-control'
                        );
                        echo Form::input('sum3', $settings['sum2'], $attrs);
                        ?>
                    </div>
                </div>

                <div class="navbar-form" >


                    <div class="form-group">
                        Округление цены доставки для покупателя
                    </div>

                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'class' => 'form-control',
                                'style' => 'width: 200px;'
                            );
                            $options = array(
                                '1' => 'Округлять в меньшую сторону',
                                '2' => 'Округлять в большую сторону',
                                '3' => 'Округлять цену в математически',
                            );
                            echo Form::select('okrugl', $options, $settings['okrugl'], $attrs);
                        ?>
                    </div>

                    <div class="form-group">
                        Шаг
                    </div>

                    <div class="form-group">
                        <?php
                            $attrs = array(
                                'placeholder' => 'Шаг',
                                'class' => 'form-control'
                            );
                            echo Form::input('shag', $settings['shag'], $attrs);
                        ?>
                    </div>

                    <div class="form-group" >
                        <p class="bg-success" >
                            В некоторых случаях есть необходимость включить цену забора
                        </p>
                        <label class="checkbox-inline">
                            <?php
                                echo Form::checkbox('zabor', '1', ( $settings['zabor'] )? true : false );
                            ?>
                            Выводить стоимость забора в цене доставки
                        </label>
                    </div>

                </div>

            </form>
            <!--
            <p><input type="password" placeholder="Password" class="form-control"></p>
            -->
            <!--
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            -->
