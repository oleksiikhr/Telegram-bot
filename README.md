Для локального использования:
1. Скачать Composer
2. Прописать в терминале для подключения библиотек - Composer update.

Общие сведения:
1. Автоматический пуш с ветки master в Heroku:
https://mmorpg-bot.herokuapp.com/
2. Для БД используется PostgreSQL (до 20 подключений, 10к строк)

Пример вызова клавиатуры для параметра 'reply_markup':
`$k = Keyboard::replyKeyboardMarkup([
	[KeyboardButton::new('One btn'), KeyboardButton::new('Two btn')],
	[KeyboardButton::new('Three btn')]
]);`
