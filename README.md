# THEME - MotChill 2023 - OPHIM CMS

## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/KKmxz2s/MOTCHILL-INDEX.png "Home Page")

### Trang Danh Sách Phim
![Alt text](https://i.ibb.co/Wg5Pc20/MOTCHILL-CATALOG.png "Catalog Page")

### Trang Thông Tin Phim
![Alt text](https://i.ibb.co/557G7Kc/MOTCHILL-SINGLE.png "Single Page")

### Trang Xem Phim
![Alt text](https://i.ibb.co/S6By19h/MOTCHILL-EPISODE.png "Episode Page")

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/theme-motchill`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/theme-motchill`
2. Re-Activate giao diện trong Admin Panel

## Document
### List
- Trang chủ: `display_label|relation|find_by_field|value|limit|show_more_url`
    ```
    Phim chiếu rạp mới||is_shown_in_theater|1|8|/danh-sach/phim-chieu-rap
    Phim bộ mới||type|series|8|/danh-sach/phim-bo
    Phim lẻ mới||type|single|8|/danh-sach/phim-le
    Phim hoạt hình|categories|slug|hoat-hinh|8|/the-loai/hoat-hinh
    ```

- Danh sách hot:  `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (top_text|top_thumb)`
    ```
    Sắp chiếu||status|trailer|publish_year|desc|10|top_text
    Top phim lẻ||type|single|view_week|desc|10|top_thumb
    Top phim bộ||type|series|view_week|desc|10|top_thumb
    ```

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-motchill/resources/views/thememotchill`
- Copy file cần custom đến: `/resources/views/vendor/themes/thememotchill`
