var topWindow = parent;


while(topWindow != topWindow.parent) {
    topWindow = topWindow.parent;
}

if(typeof(topWindow.DDeliveryProtocolManager) == 'undefined')
    topWindow.DDeliveryProtocolManager = (function(){
        var th = {};
        var productList = {};
        var productIdsString = '';
        var orderPrice;
        th.token = '';
        if (!window.location.origin)
            window.location.origin = window.location.protocol+"//"+window.location.host;

        function getProductsInfoFromInsales(){
            $.ajax({
                dataType: "json",
                url: window.location.origin + '/products_by_id/' + productIdsString + '.json',
                async: false,
                success:function( data ){
                    if( data.status == "ok" ){
                        $.each( data.products, function( key,value ){
                            product =  productList[value.id];
                            product.product_field_values = value.product_field_values;
                        })
                    }
                }
            });
            console.log(productList);
        };
        function getProductsInfo(){
            $.ajax({
                dataType: "json",
                url: window.location.origin + '/cart_items.json',
                async: false,
                success: function(data){

                   if( data.items_count > 0 ){
                       $.each( data.order_lines,function( key,value ){
                           //product = { id:value.product_id, title : value.title, quantity:value.quantity, product_field_values:{}};
                           //productList[value.product_id] = product;
                           productIdsString += ( value.product_id + ':' + value.quantity + ',' );
                       });
                   }
                }
            });
        };

        th.setCartToInsales = function( key_on_server ){
            var url = ddelivery_insales.url + "sdk/putcart/";
            $.ajax({
                url: url,
                type: 'POST',
                jsonpCallback: 'jsonCallback',
                async: false,
                dataType: "jsonp",
                data: {
                    token: key_on_server,
                    data: JSON.stringify(productList)
                },
                success:function(){
                    alert('hello');
                }
            });
        };
        th.getProductList = function(){
            return JSON.stringify(productList);
        };
        th.getProductString = function(){
            return productIdsString;
        };
        th.checkServer = function(){
            alert('hello');
        };
        th.updatePriceAndSend = function( key_on_server ){
            getProductsInfo();
            //getProductsInfoFromInsales();
            th.token = key_on_server;
            // setCartToInsales( th.token );
        };
        return th;
})();
var DDeliveryProtocolManager = topWindow.DDeliveryProtocolManager;

function updatePriceAndSend( key_on_server ){
    DDeliveryProtocolManager.updatePriceAndSend( key_on_server );
}
function enableDDButton(){
    $('#startDD').removeAttr('disabled');
}

if(typeof(topWindow.DDeliveryIntegration) == 'undefined')
    topWindow.DDeliveryIntegration = (function(){
        var th = {};
        var status = 'Выберите условия доставки';
        th.getStatus = function(){
            return status;
        };

        function hideCover() {
            document.body.removeChild(document.getElementById('ddelivery_cover'));
        }

        function showPrompt() {
            var cover = document.createElement('div');
            cover.id = 'ddelivery_cover';
            document.body.appendChild(cover);
            document.getElementById('ddelivery_container').style.display = 'block';
        }


        function fillFeields(data)
        {
            $( '#client_name').val(data.userInfo.firstName);
            $( '#client_phone').val(data.userInfo.toPhone);
            $( '#shipping_address_city').val(data.city_name);
            //typeof(topWindow.DDeliveryIntegration) == 'undefined'
            //$( '#shipping_address_address').val(data.comment);
            if( data.type == "2" ){
                $('#shipping_address_field_' + data.house).val(data.userInfo.toHouse);
                $('#shipping_address_field_' + data.street).val(data.userInfo.toStreet);
                $('#shipping_address_field_' + data.flat).val(data.userInfo.toFlat);
                $('#shipping_address_field_' + data.corp).val(data.userInfo.toHousing);
            }
        }
        th.openPopup = function(){
            showPrompt();
            document.getElementById('ddelivery_popup').innerHTML = '';
            var callback = {
                close: function(){
                    hideCover();
                    document.getElementById('ddelivery_container').style.display = 'none';
                },
                change: function(data) {

                    fillFeields(data);
                    $( '.moto_moto').empty();
                    $( '.dd_asset_conteiner').append( '<div class="moto_moto" style="position: absolute;' +
                        'margin-top: 10px; color:#E98B73" >' + data.comment + '</div>' );
                    var variant_id = ddelivery_insales.delivery_id;
                    CheckoutDelivery.find( variant_id ).setFieldsValues( [{fieldId: ddelivery_insales.field2_id, value: ddelivery_insales._id}] );
                    //alert(data.comment+ ' интернет магазину нужно взять с пользователя за доставку '+data.clientPrice+' руб. OrderId: '+data.orderId);

                    CheckoutDelivery.find( variant_id ).setFieldsValues( [{fieldId: ddelivery_insales.field_id, value: data.orderId }] );
                    CheckoutDelivery.find( variant_id ).toExternal().setPrice(data.clientPrice);
                    $('.dd_last_check').val(data.orderId);
                    $('#price_' + variant_id).css('display','block');
                    status = data.comment;

                    hideCover();
                    document.getElementById('ddelivery_container').style.display = 'none';
                    $('#shipping_address_city').attr('disabled','disabled');

                }
            };
            order_form = $('#order_form').serializeArray();
            params =  {};
            params.client_name = $('#client_name').val();
            params.client_phone = $('#client_phone').val();
            parametrs = $.param(params);
            order_form = $.param(order_form);

            url = ddelivery_insales.url + "sdk/?token=" + DDeliveryProtocolManager.token + "&items=" + DDeliveryProtocolManager.getProductString()
                  + "&" + parametrs + "&" + order_form ;
            DDelivery.delivery('ddelivery_popup', url, {}, callback);

        };
        var style = document.createElement('STYLE');
        style.innerHTML = // Скрываем ненужную кнопку
            ' #delivery_info_ddelivery_all a{display: none;} ' +
                ' #ddelivery_popup { display: inline-block; position:relative; vertical-align: middle; margin: 10px auto; width: 1000px; height: 650px;} ' +
                ' #ddelivery_container { position: fixed; top: 0; left: 0; z-index: 9999;display: none; width: 100%; height: 100%; text-align: center;  } ' +
                ' #ddelivery_container:before { display: inline-block; height: 100%; content: \'\'; vertical-align: middle;} ' +
                ' #ddelivery_cover {  position: fixed; top: 0; left: 0; z-index: 9000; width: 100%; height: 100%; background-color: #000; background: rgba(0, 0, 0, 0.5); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = #7F000000, endColorstr = #7F000000); } ';
        var body = document.getElementsByTagName('body')[0];
        body.appendChild(style);
        var div = document.createElement('div');
        div.innerHTML = '<div id="ddelivery_popup"></div>';
        div.id = 'ddelivery_container';
        body.appendChild(div);

        return th;
    })();
var DDeliveryIntegration = topWindow.DDeliveryIntegration;

$(function(){
    $(document).ready(function(){
        var variant_id = ddelivery_insales.delivery_id;
        $(".button" ).on('click',function(){
            checked = $('#order_delivery_variant_id_' + ddelivery_insales.delivery_id).attr("checked");
            if( checked == 'checked' )
            {
                if( $('.dd_last_check').val() != '' )
                {
                    $('#order_form').submit();
                    return true;
                }
                else
                {
                    alert('Выберите точку доставки DDelivery');
                    return false;
                }
            }
            else
            {
                return true;
            }
            return false;

        });
        $('#create_order').on('click',function(){
            checked = $('#order_delivery_variant_id_' + ddelivery_insales.delivery_id).attr("checked");
            if( checked == 'checked' )
            {
                if( $('.dd_last_check').val() != '' )
                {
                    $('#order_form').submit();
                    return true;
                }
                else
                {
                    alert('Выберите точку доставки DDelivery');
                    return false;
                }
            }
            else
            {
                return true;
            }
            return false;
        });
        $('#order_delivery_variant_id_' + ddelivery_insales.delivery_id).parent().next().append('<div class=\"dd_asset_conteiner\" style=\"position: relative\">' +
            '<input type=\"hidden\" class=\"dd_last_check\" value=\"\">' +
            '<button disabled="disabled" onclick=\"return false\" class=\"button\" style=\"max-height:18px;font:12px Tahoma,sans-serif; padding:  2px 9px;display:block;position: absolute;top: -32px; left:65px;min-width: 190px\" id=\"startDD\" ' +
            ' href=\"javascript:void(0);\" >Выбрать способ доставки</button>' );
        $('.delivery_variants .radio_button').on('change',function(){
            if( $(this).val() == ddelivery_insales.delivery_id ){
                $('#shipping_address_city').attr('disabled','disabled');
            }else{
                $('#shipping_address_city').removeAttr('disabled');
            }
        });
        $('#startDD').on('click', function(){
            $('#order_delivery_variant_id_' + ddelivery_insales.delivery_id).click();
            DD