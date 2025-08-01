# API Документация - Новостной портал

## Базовый URL
```
http://localhost:8000/api/v1
```

## Аутентификация
В настоящее время API не требует аутентификации для чтения данных.

## Endpoints

### 1. Получить список всех новостей

**GET** `/news`

#### Параметры запроса:
- `per_page` (опционально) - количество новостей на странице (по умолчанию: 10)
- `search` (опционально) - поиск по названию или описанию
- `author` (опционально) - фильтр по автору

#### Примеры запросов:
```bash
# Получить все новости
GET /api/v1/news

# Получить 20 новостей на странице
GET /api/v1/news?per_page=20

# Поиск новостей
GET /api/v1/news?search=технологии

# Фильтр по автору
GET /api/v1/news?author=admin

# Комбинированный запрос
GET /api/v1/news?per_page=15&search=новости&author=admin
```

#### Пример ответа:
```json
{
    "success": true,
    "data": {
        "news": [
            {
                "id": 1,
                "name": "Название новости",
                "description": "Описание новости...",
                "author": "admin",
                "photo": "http://localhost:8000/uploads/1234567890.jpg",
                "created_at": "2025-08-01 16:30:00",
                "updated_at": "2025-08-01 16:30:00"
            }
        ],
        "pagination": {
            "current_page": 1,
            "last_page": 5,
            "per_page": 10,
            "total": 50,
            "from": 1,
            "to": 10
        }
    },
    "message": "Новости успешно получены"
}
```

### 2. Получить подробную информацию о новости

**GET** `/news/{id}`

#### Параметры пути:
- `id` - ID новости

#### Пример запроса:
```bash
GET /api/v1/news/1
```

#### Пример ответа:
```json
{
    "success": true,
    "data": {
        "news": {
            "id": 1,
            "name": "Название новости",
            "description": "Полное описание новости...",
            "author": "admin",
            "photo": "http://localhost:8000/uploads/1234567890.jpg",
            "created_at": "2025-08-01 16:30:00",
            "updated_at": "2025-08-01 16:30:00",
            "created_at_formatted": "01.08.2025 16:30",
            "updated_at_formatted": "01.08.2025 16:30"
        },
        "author_info": {
            "name": "admin",
            "total_news": 15,
            "last_news_date": "01.08.2025 16:30"
        },
        "related_news": [
            {
                "id": 2,
                "name": "Другая новость",
                "description": "Краткое описание...",
                "photo": "http://localhost:8000/uploads/1234567891.jpg",
                "created_at": "01.08.2025 15:30"
            }
        ]
    },
    "message": "Информация о новости успешно получена"
}
```

### 3. Получить статистику по новостям

**GET** `/news/stats/overview`

#### Пример запроса:
```bash
GET /api/v1/news/stats/overview
```

#### Пример ответа:
```json
{
    "success": true,
    "data": {
        "total_news": 50,
        "total_authors": 8,
        "latest_news": "01.08.2025 16:30",
        "top_authors": [
            {
                "author": "admin",
                "news_count": 15
            },
            {
                "author": "content_manager",
                "news_count": 12
            }
        ],
        "news_by_month": [
            {
                "period": "2025-08",
                "count": 25
            },
            {
                "period": "2025-07",
                "count": 20
            }
        ]
    },
    "message": "Статистика успешно получена"
}
```

### 4. Получить новости по автору

**GET** `/news/author/{author}`

#### Параметры пути:
- `author` - имя автора

#### Пример запроса:
```bash
GET /api/v1/news/author/admin
```

#### Пример ответа:
```json
{
    "success": true,
    "data": {
        "author": "admin",
        "total_news": 15,
        "news": [
            {
                "id": 1,
                "name": "Название новости",
                "description": "Краткое описание новости...",
                "photo": "http://localhost:8000/uploads/1234567890.jpg",
                "created_at": "01.08.2025 16:30",
                "updated_at": "01.08.2025 16:30"
            }
        ]
    },
    "message": "Новости автора успешно получены"
}
```

## Коды ответов

- **200** - Успешный запрос
- **404** - Ресурс не найден
- **500** - Внутренняя ошибка сервера

## Формат ошибок

```json
{
    "success": false,
    "message": "Описание ошибки",
    "error": "Техническая информация об ошибке"
}
```

## Примеры использования с JavaScript

### Получение списка новостей:
```javascript
fetch('/api/v1/news?per_page=10')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Новости:', data.data.news);
            console.log('Пагинация:', data.data.pagination);
        }
    });
```

### Получение подробной информации о новости:
```javascript
fetch('/api/v1/news/1')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Новость:', data.data.news);
            console.log('Автор:', data.data.author_info);
            console.log('Похожие новости:', data.data.related_news);
        }
    });
```

### Получение статистики:
```javascript
fetch('/api/v1/news/stats/overview')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Общая статистика:', data.data);
        }
    });
```

## Примечания

- Все даты возвращаются в формате ISO 8601 (`Y-m-d H:i:s`)
- Для удобства также предоставляются отформатированные даты (`d.m.Y H:i`)
- Фотографии возвращаются как полные URL
- Поиск не чувствителен к регистру
- Пагинация начинается с 1 