# Taskflw

Однопользовательская мини-CRM: трекер клиентов, сделок, взаимодействий и задач с дашбордом.

## Возможности

- **Дашборд** — сводка по клиентам, сделкам, выручке и ближайшим дедлайнам
- **Клиенты** — создание, редактирование, удаление, поиск по имени/компании/email
- **Сделки** — учёт сделок с фильтрацией по статусу, клиенту и сумме
- **Взаимодействия** — история звонков, писем, встреч и других контактов с клиентами
- **Задачи** — трекер задач с дедлайнами и статусами выполнения
- **Цветовая тема** — переключение светлой/тёмной темы с сохранением выбора
- **Локализация** — русский и английский языки интерфейса

## Технологии

| Компонент | Версия |
|-----------|--------|
| PHP | 8.4 |
| Laravel | 13 |
| PostgreSQL | 18 |
| Bootstrap | 5.3 |
| Pest PHP | 4.x |
| Docker Compose | — |

## Установка

### Требования

- Docker
- Docker Compose

### Запуск

```bash
docker compose up -d --build
docker compose exec app php artisan migrate:fresh --seed
```

Приложение доступно на `http://localhost:8080`.

### Остановка

```bash
docker compose down
```

## Тесты

```bash
docker compose exec app php artisan test
```

## Структура проекта

```
app/
├── Http/
│   ├── Controllers/    # Контроллеры
│   └── Middleware/     # SetTheme, SetLocale
├── Models/             # Client, Deal, Interaction, Task
database/
├── migrations/         # Миграции таблиц
├── seeders/            # DemoSeeder с демо-данными
lang/
├── ru/                 # Русская локализация
└── en/                 # Английская локализация
resources/
├── views/              # Blade-шаблоны
│   ├── layouts/        # Базовый layout
│   ├── clients/        # Страницы клиентов
│   ├── deals/          # Страницы сделок
│   ├── tasks/          # Страницы задач
│   └── dashboard.blade.php
tests/
├── Unit/               # Тесты моделей
└── Feature/            # Тесты контроллеров
```

## Команды

```bash
# Миграции
docker compose exec app php artisan migrate

# Демо-данные
docker compose exec app php artisan migrate:fresh --seed
```