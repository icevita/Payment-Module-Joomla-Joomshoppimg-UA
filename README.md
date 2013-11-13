### ПЛАТЕЖНЫЙ МОДУЛЬ MONEXY ДЛЯ JOOMLA 2.5 JOOMSHOPPING

Платежный модуль Monexy позволяет принимать оплату за товары или услуги электронными деньгами MoneXy в интернет-магазинах, которые используют Joomla 2.5 CMS (модуль JoomShoping). Модуль предназначен для приема платежей, исключительно на территории Украины. Для работы с электронными деньгами необходимо выполнить два шага:

1. Зарегистрироваться в системе Monexy как бизнес клиент, чтобы получить электронный кошелек 
2. 2. Установить модуль в интернет-магазин

### РЕГИСТРАЦИЯ В MONEXY

Для получения электронного кошелька, вам необходимо зарегистрироваться в системе Monexy как бизнес-клиент https://www.monexy.ua/ru/merchant/register После регистрации, вы получите электронный кошелек Monexy для вашего интернет магазина и сможете принимать оплату электронными деньгами. Полученные электронные деньги вы сможете выводить из системы различными способами: на р/с по банковским реквизитам, на карты Visa, MasterCard, наличными в отделениях Фидобанка и др.

### УСТАНОВКА И НАСТРОЙКА МОДУЛЯ

Данный платежный модуль расчитан на работу с CMS Joomla версии 2.5.x с установленным модулем онлайн магазина JoomShoping (http://joomshopping.pro/).

Порядок установки:

1. Скопируйте папку components в корневую директорию сайта;
2. Зайдите в панель управления вашего сайта;
3. Откройте "Опции" компонента JoomShoping (меню Компоненты/JoomShoping/Опции);
4. Выберите пункт "Способы оплаты" и нажмите "Создать";
5. Заполните поля:

 - Публикация: отметьте галочкой, если хотите, чтобы этот способ оплаты отобразился на сайте;
 - Код: Код способа оплаты. Укажите в этом поле значение "Monexy";
 - Название: Название способа оплаты, которое будут видеть ваши клиенты (Например: Monexy);
 - Псевдоним: Название PHP-класса, который отвечает за настройку этого способа оплаты. Укажите в этом поле значение "pm_monexy";
 - Тип: Тип способа оплаты. В последних версиях JoomShopping это поле убрали. Если вы его видите, выберите значение "Расширенный". Если поля "Тип" нет, то необходимо выполнить действия, описанные в пункте 5.1, иначе модуль не будет работать.;
 - Описание: Перечислите наиболее популярные способы оплаты чтобы ваши клиенты понимали что дальше найдут нужный им способ.
5.1 - зайти в базу данных Вашего сайта (чаще всего это делается при помощи утилиты phpMyAdmin, доступной на большинстве хостингов);
- в базе данных найти таблицу jshopping_payment_method (перед названием всех таблиц системы будет стоять префикс, уникальный для конкретной установки Joomla, т.е. таблица будет иметь название префикс_jshopping_payment_method);
- внутри таблицы для способа оплаты Monexy нужно значение поля "payment_type" установить в значение "2".
6. Сохраните и перейдите на вкладку "Конфигурация";
7. Заполните поля:
 - Merchant ID: Идентификатор электронного кошелька Вашего интернет магазина в системе Monexy, значение указано в панели управления магазином на сайте monexy.ua;
 - Shop name: Значение по­умолчанию ­ название сайта, например MyShop Monexy
 - Check hash: флаг проверки HASH. Нужно заполнить поле “Secret key” (секретный ключ), если включить эту проверку
 - Secret key: секретный ключ – Ваше кодовое слово будет использоваться во всех запросах как часть процесса аутентификации (минимум 10 символов). Он должен совпадать с секретным ключом в "Настройка безопасности" в системе https://www.monexy.ua На рисунке приведен пример
 - Validity time: время, за которое пользователь должен осуществить платеж. Другими словами ­ время жизни заказа.
 - Статус заказа для успешных транзакций: Например "Paid";
 - Статус заказа для незавершенных транзакций: Начальный статус заказа, например "Pending"
 - Статус заказа для неуспешных транзакций: Если при отказе оплаты нужно отменять заказ, то выберите "Canceled". Если хотите дать возможность после отказа повторно переходить к оплате, выберите "Pending";
8. Сохраните изменения.

### ТЕХНИЧЕСКАЯ ПОДДЕРЖКА

Вы можете задать технические вопросы нашим специалистам:

- в интерактивном чате через сайт https://www.monexy.ua
- позвонив по телефону +380(44)2233138
- отправив сообщение через форму обратной святи на сайте https://www.monexy.ua
- отправить сообщение на e-mail support@monexy.ua

Регламент работы онлайн поддержки Пн-Пт, 9.00-18.00 (GMT+2).
