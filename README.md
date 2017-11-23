# Shortlink

Сервис для создания коротких адресов страниц.<br />
Функционал в модуле "/frontend/modules/shortlink"

Фронт (vue.js).<br />
Добавление url и список добавленных ссылок:
```
http://localhost/add-link
```

Для перехода по короткой ссылке
```
http://localhost/code
```
_code_ - короткий  код ссылки

Операция с ссылками через REST /api/link

**Установка**

Установить внешние компоненты через Composer
```bash
composer install
```

Проиницилизировать yii
```bash
./init
```

Прописываем базу.<br />
Открываем "common/config/main-local.php"
```
'dsn' => 'mysql:host=localhost;dbname=dbname',
'username' => 'root',
'password' => '',
```
"dbname" меняем на рабочее имя базы.<br />
Указываем пользователя базы и его пароль.

Выполнить обновление базы через миграцию
```bash
./yii migrate
```