Для локального использования:
1. Скачать Composer
2. Прописать в терминале для подключения библиотек - Composer update.

Общие сведения:
1. Автоматический пуш с ветки master в Heroku:
https://mmorpg-bot.herokuapp.com/
2. Для БД используется PostgreSQL (до 20 подключений, 10к строк)

Пример вызова клавиатуры для параметра 'reply_markup':

```
$k = Keyboard::replyKeyboardMarkup([
	[KeyboardButton::new('One btn'), KeyboardButton::new('Two btn')],
	[KeyboardButton::new('Three btn')]
]);
 
Telegram::sendMessage(Parse::$fromID, Parse::$text, null, null, $k);
```

```
/home      - |Таверна|     => BTN(Приключения, Шахта, Арена, Магазин, Персонаж), TXT(Чего хотел?)
/adventure - |Приключения| => BTN(1 мин, 5 мин, 10 мин), TXT(Приключения? Давай-ка посмотрим, что у меня есть.)
/arena     - |Арена|       => BTN(1 персонаж, 2 персонаж, 3 персонаж), TXT(Выберите опоннента)
/mine      - |Шахта|       => BTN(1 час, 2 часа, 3 часа, 4 часа, 5 часов, 6 часов, 7 часов, 8 часов), TXT()
/shop      - |Магазин|     => 
/me        - |Персонаж|    => 
```

Методы:
```
registration - Регистрация
complete_registration - Завершение регистрации
```
