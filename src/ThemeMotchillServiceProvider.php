<?php

namespace Ophim\ThemeMotchill;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeMotchillServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/motchill')
        ], 'motchill-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'motchill' => [
                'name' => 'Motchill',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-motchill',
                'publishes' => ['motchill-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommended movies limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 20,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 10,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => <<<EOT
                        Phim chiếu rạp mới||is_shown_in_theater|1|8|/danh-sach/phim-chieu-rap
                        Phim bộ mới||type|series|8|/danh-sach/phim-bo
                        Phim lẻ mới||type|single|8|/danh-sach/phim-le
                        Phim hoạt hình|categories|slug|hoat-hinh|8|/the-loai/hoat-hinh
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (top_text|top_thumb)',
                        'value' => <<<EOT
                        Sắp chiếu||status|trailer|publish_year|desc|10|top_text
                        Top phim lẻ||type|single|view_week|desc|10|top_thumb
                        Top phim bộ||type|series|view_week|desc|10|top_thumb
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <a href="#" class="btn-contact" title="inbox">
                            <i class="fa fa-envelope-o"></i>
                        </a>
                        <div id="footer">
                            <div class="container">
                                <div class="desc">
                                    <p>
                                        <b>
                                            <a href="/">Xem phim online</a>
                                        </b> miễn phí chất lượng cao với phụ đề tiếng việt - thuyết minh - lồng tiếng. Mọt phim có nhiều thể
                                        loại phim phong phú, đặc sắc, nhiều bộ phim hay nhất - mới nhất.
                                    </p>
                                    <p>Website với giao diện trực quan, thuận tiện, tốc độ tải nhanh, thường xuyên cập nhật các
                                        bộ phim mới hứa hẹn sẽ đem lại những trải nghiệm tốt cho người dùng.</p>
                                </div>
                                <div class="info">
                                    <!--contact-->
                                    <div class="column">
                                        <div class="heading">Quy định</div>
                                        <ul>
                                            <li>
                                                <a href="#">Điều khoản chung</a>
                                            </li>
                                            <li>
                                                <a href="#">Chính sách riêng tư</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="column">
                                        <div class="heading">Giới thiệu</div>
                                        <ul>
                                            <li>
                                                <a href="#">Trang chủ</a>
                                            </li>
                                            <li>
                                                <a href="#">Facebook</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
