# language: ru
Функционал: Деление чисел
  Поскольку деление сложный процесс и люди часто допускают ошибки
  Нужно дать им возможность делить на калькуляторе

  Структура сценария: Целочисленное деление
    Допустим я ввожу число <делимое>
    И затем ввожу число <делитель>
    Если я нажимаю "/"
    То результатом должно быть число <частное>

  Значения:
    | делимое | делитель | частное |
    | 100     | 2        | 50      |
    | 28      | 7        | 4       |
    | 0       | 5        | 0       |