#### Описание

Пакет содержит `livewire` компонент для загрузки галереи изображений, модель для файла, трейты для подключения к модели и четыре стандартных шаблона для конвертации изображений (используется `intervention/image`).

- `ShouldImage` трейт для добавления изображения к модели, необходимо поле `image_id`, можно переопределить через `imageKey`. Добавляются методы `image`, `uploadImage` (загрузка изображения, полученного через `request()`), `livewireImage` (загрузка изображения через `livewire`), `clearImage` (очистить изображение).
- `ShouldGallery` трейт для добавления галереи изображений к модели. Добавляются методы `images`, `cover` (обложка, или первое изображение по приоритету), `livewireGalleryImage` (загрузка изображения через `livewire`), `clearImages` (очистить галерею)
- `fa-images` компонент для галереи на `livewire`, параметр `model` для модели, у которой есть трейт `ShouldGallery`. В компоненте интерфейс для управления галерей (поиск по названию, загрузка группы изображений, удаление изображения, изменение имени изображения, изменение приоритета изображения через drag&drop)
- `thumb:clear { --template= : clear only by template } { --all : clear all }` команда для очистки обрезанных изображений.
- `/thumbnail/{template}/{filename}` роут для генерации и сохранения превью файлов

В конфигурации можно задать расширенную модель для файла, необходимо что бы модель наследовалась от той что в пакете. Так же можно расширить observer, компонент для livewire и контроллер для генерации превью. 

Что бы добавить новые шаблоны, нужно расширить в конфиге `templates`.

### Установка

Добавить `"./vendor/aweram/fileable/src/resources/views/**/*.blade.php"` в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

Для добавления таблицы с файлами:

    php artisan migrate

Файлы хранить в `public` или во внешнем хранилище:
- В конфиге изменить `FILESYSTEM_DISK=public`

    
    php artisan storage:link
