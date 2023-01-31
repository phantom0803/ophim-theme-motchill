# THEME - MotChill 2023 - OPHIM CMS

## Demo
### Trang Chủ
<!-- ![Alt text](https://i.ibb.co/bWkS4Sf/theme-motchill-Home-Page.png "Home Page") -->

### Trang Danh Sách Phim
<!-- ![Alt text](https://i.ibb.co/B2dPj5S/theme-motchill-Catalog-Page.png "Catalog Page") -->

### Trang Thông Tin Phim
<!-- ![Alt text](https://i.ibb.co/6r1Z70Y/theme-motchill-Single-Page.png "Single Page") -->

### Trang Xem Phim
<!-- ![Alt text](https://i.ibb.co/Pxb8m1G/theme-motchill-Episode-Page.png "Episode Page") -->

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/ophim-theme-motchill`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/ophim-theme-motchill`
2. Re-Activate giao diện trong Admin Panel

## Document
### List
- Trang chủ: `display_label|relation|find_by_field|value|limit|show_more_url`
    + Ví dụ theo định dạng: `Phim bộ mới||type|series|12|/danh-sach/phim-bo`
    + Ví dụ theo định dạng: `Phim lẻ mới||type|single|12|/danh-sach/phim-bo`
    + Ví dụ theo thể loại: `Phim hành động|categories|slug|hanh-dong|12|/the-loai/hanh-dong`
    + Ví dụ theo quốc gia: `Phim hàn quốc|regions|slug|han-quoc|12|/quoc-gia/han-quoc`
    + Ví dụ với các field khác: `Phim chiếu rạp||is_shown_in_theater|1|12|`

- Danh sách hot:  `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (top_text|top_thumb)`
    + `Phim sắp chiếu||status|trailer|publish_year|desc|9|top_text`
    + `Top phim bộ||type|series|view_total|desc|9|top_thumb`
    + `Top phim lẻ||type|single|view_total|desc|9|top_thumb`

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/ophim-theme-motchill/resources/views/thememotchill`
- Copy file cần custom đến: `/resources/views/vendor/themes/thememotchill`
