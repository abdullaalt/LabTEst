# API Endpoints

## /users

- **Method:** GET
- **Description:** Получить список пользователей

## /users/register

- **Method:** POST
- **Description:** Регистрация нового пользователя
- **Parameters:**
  - **nickname** (string): Никнейм пользователя
  - **email** (string): Электронная почта пользователя
  - **password** (string): Пароль пользователя
  - **born** (string): Дата рождения пользователя (например, 01-01-1990)

  
## /users/login

- **Method:** POST
- **Description:** Авторизация
- **Parameters:**
  - **email** (string): Электронная почта пользователя
  - **password** (string): Пароль пользователя

  ## /users

- **Method:** POST
- **Description:** Обновление пользователя
- **Parameters:**
  - **nickname** (string): Никнейм пользователя
  - **email** (string): Электронная почта пользователя
  - **password** (string): Пароль пользователя
  - **born** (string): Дата рождения пользователя (например, 01-01-1990)
- **Headers:**
  - **Token** (string): Авторизационный токен пользователя для идентификации


## /users/{user_id}

- **Method:** Delete
- **Description:** Удаление пользователя
- **Headers:**
  - **Token** (string): Авторизационный токен пользователя для идентификации

## /users/{user_id}

- **Method:** Get
- **Description:** Получение пользователя
- **Headers:**
  - **Token** (string): Авторизационный токен пользователя для идентификации