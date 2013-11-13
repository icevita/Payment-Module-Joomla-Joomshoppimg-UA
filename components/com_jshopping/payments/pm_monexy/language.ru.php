<?php
define ('ADMIN_CFG_MONEXY_MERCHANT_ID', 'Merchant ID');
define ('ADMIN_CFG_MONEXY_MERCHANT_ID_DESCRIPTION', 'Идентификатор интернет-магазина, полученный при регистрации в Monexy');

define ('ADMIN_CFG_MONEXY_SHOP_NAME', 'Название магазина');
define ('ADMIN_CFG_MONEXY_SHOP_NAME_DESCRIPTION', 'Значение по­умолчанию ­ название сайта, например MyShop Monexy');

define ('ADMIN_CFG_MONEXY_SECRET_KEY', 'Секретный ключ');
define ('ADMIN_CFG_MONEXY_SECRET_KEY_DESCRIPTION', 'Секретный ключ');

define ('ADMIN_CFG_MONEXY_CHECK_HASH', 'Проверять хеш"');
define ('ADMIN_CFG_MONEXY_CHECK_HASH_DESCRIPTION', 'Флаг проверки HASH. Нужно заполнить поле “Secret key” (секретный ключ), если включить эту проверку"');

define ('ADMIN_CFG_MONEXY_VALIDITY_TIME', 'Время жизни"');
define ('ADMIN_CFG_MONEXY_VALIDITY_TIME_DESCRIPTION', 'Время, за которое пользователь должен осуществить платеж. Другими словами ­ время жизни заказа."');

define ('ADMIN_CFG_MONEXY_PAYMODE', 'Способ оплаты');
define ('ADMIN_CFG_MONEXY_PAYMODE_DESCRIPTION', 'Код для предопределения способа оплаты');

define ('MONEXY_ERROR_INCORRECT_SIGN', 'Подпись не совпадает');
define ('MONEXY_ERROR_WRONG_ORDER_NUMBER', 'Неправильный номер заказа');
define ('MONEXY_ERROR_INCORRECT_CURRENCY', 'Не совпадает валюта');
define ('MONEXY_ERROR_INCORRECT_AMOUNT', 'Не совпадает сумма');

define ('monexy_PAY', 'Оплатить');
?>