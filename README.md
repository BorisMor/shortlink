# Shortlink

Сервис для создания коротких адресов страниц.

**Установка**

Установить внешние компоненты через Composer
```bash
composer install
```

Проиницилизировать yii
```bash
./init
```

Прописываем базу.
Открываем "common/config/main-local.php"
```
'dsn' => 'mysql:host=localhost;dbname=dbname',
'username' => 'root',
'password' => '',
```
dbname меняем на рабочее имя базы.
Указываем пользвотеля базы и его пароль

Выполнить обновление базы через миграцию
```bash
./yii migrate
```