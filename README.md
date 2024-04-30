# Поднять сервер
```bash
php -S 127.0.0.1:8000
```
### О проекте
- Роуты находится в routes.php
- Команды php wahelp.php migrate для миграции. php wahelp.php failedJobs для перезапуска отправки
рассылки с ошибкой (учитывается момент с заранее отправленными)
- Конфигурация БД находится в config/main.php

#### Примечание!
Можно было сделать Модель для БД или использовать ORM (RedBeanPHP к примеру), но я избежал таких моментов и по сторону с
безопастностью к примеру экранирование и т.д. при записи данных в БД