<?php
if (!function_exists('katen_theme_custom_css'))
{
    function katen_theme_custom_css()
    {

        // init colors
        $body_bg_color = '';
        $primary_color = '';
        $secondary_color = '';
        $body_color = '';
        $body_secondary_color = '';
        $headings_color = '';
        $content_color = '';
        $dark_text_color = '';
        $menu_color = '';
        $menu_hover_color = '';
        $canvas_menu_color = '';
        $canvas_menu_hover_color = '';
        $canvas_submenu_color = '';
        $canvas_submenu_hover_color = '';
        $preloader_bg = '';
        $content_width = '';

        // enqueue
        $dir = get_template_directory_uri();
        wp_enqueue_style('katen-theme-color', $dir . '/css/custom_script.css', array() , '', 'all');

        // customizer options
        $body_bg_color = esc_attr(get_theme_mod('body_bg_color'));
        $primary_color = esc_attr(get_theme_mod('primary_color'));
        $secondary_color = esc_attr(get_theme_mod('secondary_color'));
        $body_color = esc_attr(get_theme_mod('body_color'));
        $body_secondary_color = esc_attr(get_theme_mod('body_secondary_color'));
        $headings_color = esc_attr(get_theme_mod('headings_color'));
        $content_color = esc_attr(get_theme_mod('content_color'));
        $dark_text_color = esc_attr(get_theme_mod('dark_text_color'));
        $menu_color = esc_attr(get_theme_mod('menu_color'));
        $menu_hover_color = esc_attr(get_theme_mod('menu_hover_color'));
        $canvas_menu_color = esc_attr(get_theme_mod('canvas_menu_color'));
        $canvas_menu_hover_color = esc_attr(get_theme_mod('canvas_menu_hover_color'));
        $canvas_submenu_color = esc_attr(get_theme_mod('canvas_submenu_color'));
        $canvas_submenu_hover_color = esc_attr(get_theme_mod('canvas_submenu_hover_color'));
        $preloader_bg = esc_attr(get_theme_mod('preloader_bg'));
        $content_width = esc_attr(get_theme_mod('content_width'));
        $dark_bg_color = esc_attr(get_theme_mod('dark_bg_color'));

        if ($body_bg_color)
        {

            $body_bg_color = "
            body {
              background-color: {$body_bg_color};
            }
          ";

        }

        if ($primary_color)
        {

            $primary_color = "
            ::selection {
              color: #FFF;
              background: {$primary_color};
              /* WebKit/Blink Browsers */
            }
            
            ::-moz-selection {
              color: #FFF;
              background: {$primary_color};
              /* Gecko Browsers */
            }
            .slick-prev:hover,
            .slick-next:hover
            {
              background: {$primary_color};
            }

            .navbar-nav li .nav-link.active,
            .contact-item .icon,
            .slick-dots li.slick-active button:before,
            .woocommerce ul.products li.product .onsale,
            .woocommerce span.onsale,
            .reading-bar
            {
              background: {$primary_color};
              background: -webkit-linear-gradient(left, {$primary_color} 0%, {$secondary_color} 100%);
              background: linear-gradient(to right, {$primary_color} 0%, {$secondary_color} 100%);
            }

            .wc-block-grid .wc-block-grid__product-onsale
            {
              background: {$primary_color} !important;
              background: -webkit-linear-gradient(left, {$primary_color} 0%, {$secondary_color} 100%) !important;
              background: linear-gradient(to right, {$primary_color} 0%, {$secondary_color} 100%) !important;
            }

            .post .category-badge,
            .btn-default, .wp-block-search button[type=submit], 
            .widget .searchform input[type=submit], 
            .comment-reply-link, 
            .post-password-form input[type=submit], 
            input[type=submit],
            .nav-pills .nav-link.active, 
            .nav-pills .show > .nav-link,
            .woocommerce #respond input#submit, 
            .woocommerce a.button, 
            .woocommerce button.button, 
            .woocommerce input.button,
            .woocommerce #respond input#submit:hover, 
            .woocommerce a.button:hover, 
            .woocommerce button.button:hover, 
            .woocommerce input.button:hover,
            .woocommerce div.product .woocommerce-tabs ul.tabs li.active,
            .wc-block-components-form .wc-block-components-text-input input:-webkit-autofill + label,
            .wc-block-components-form .wc-block-components-text-input.is-active label,
            .wc-block-components-text-input input:-webkit-autofill + label,
            .wc-block-components-text-input.is-active label,
            body:not(.woocommerce-block-theme-has-button-styles) .wc-block-components-button:not(.is-link),
            .wp-block-button__link 
            {
              background: {$primary_color};
              background: -webkit-linear-gradient(left, {$primary_color} 0%, {$secondary_color} 51%, {$primary_color} 100%);
              background: linear-gradient(to right, {$primary_color} 0%, {$secondary_color} 51%, {$primary_color} 100%);
              background-size: 200% auto;
            }

            .icon-button,
            .page-item .page-numbers.current,
            .page-numbers:hover,
            .comments-pagination .page-numbers.current,
            .page-links li,
            .page-links li:hover,
            .page-links a li:hover,
            .woocommerce nav.woocommerce-pagination ul li a:focus, 
            .woocommerce nav.woocommerce-pagination ul li a:hover, 
            .woocommerce nav.woocommerce-pagination ul li span.current,
            .woocommerce .widget_product_search button.wp-element-button,
            .woocommerce .woocommerce-product-search button[type=submit]:not(:disabled),
            .woocommerce .woocommerce-product-search button:not(:disabled)
            {
              background: {$secondary_color};
              background: -webkit-linear-gradient(bottom, {$secondary_color} 0%, {$primary_color} 51%, {$secondary_color} 100%);
              background: linear-gradient(to top, {$secondary_color} 0%, {$primary_color} 51%, {$secondary_color} 100%);
              background-size: auto 200%;
            }

            .post .post-format,
            .post .post-format-sm,
            .post.post-list-sm .thumb .number,
            .post.post-list-sm.counter:before
            {
              background: {$primary_color};
              background: -webkit-linear-gradient(bottom, {$primary_color} 0%, {$secondary_color} 100%);
              background: linear-gradient(to top, {$primary_color} 0%, {$secondary_color} 100%);
            }

            .book {
              --color: {$primary_color};
            }

            a,
            header.dark .social-icons li a:hover,
            .text-logo .dot,
            .dropdown-item:focus, .dropdown-item:hover,
            .dropdown-item.active, .dropdown-item:active,
            .canvas-menu .vertical-menu li.current-menu-item a,
            .canvas-menu .vertical-menu li .switch,
            .post .post-title a:hover,
            .post .meta a:hover,
            .post .post-bottom .more-button a:hover,
            .about-author .details h4.name a:hover,
            .comments li.comment .details h4.name a:hover,
            .comments li.trackback .details h4.name a:hover,
            .comments li.pingback .details h4.name a:hover,
            .widget ul.list li a:before,
            .widget ul.list li a:hover,
            .tags a:hover,
            .tagcloud a:hover,
            .wp-block-tag-cloud a:hover,
            .btn-simple:hover,
            .btn-light:hover,
            .breadcrumb li a:hover,
            #return-to-top:hover,
            .social-icons a:hover,
            .slick-custom-buttons:hover,
            .widget ul li a:hover,
            .widget_categories ul li a:before,
            .widget_archive ul li a:before,
            .widget_meta ul li a:before,
            .widget_pages ul li a:before,
            .widget_recent_entries ul li a:before,
            .widget_nav_menu ul li a:before,
            .widget_block ul li a:before,
            .wp-block-calendar tfoot a,
            .wp-block-archives-list li a:hover,
            .wp-block-archives-list li a:before,
            .woocommerce div.product p.price, 
            .woocommerce div.product span.price,
            .woocommerce-info::before,
            .woocommerce .woocommerce-MyAccount-navigation ul li a:hover,
            body.dark .post .post-title a:hover,
            body.dark .widget ul li a:hover,
            body.dark .social-icons a:hover
            {
                color: {$primary_color};
            }

            {
                color: {$primary_color} !important;
            }

            .post .meta li:after,
            .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
            .woocommerce .widget_price_filter .ui-slider .ui-slider-handle
            {
              background-color: {$primary_color};
            }

            .tags a:hover,
            .tagcloud a:hover,
            .wp-block-tag-cloud a:hover,
            .btn-simple:hover,
            .form-control:focus, 
            .wp-block-search input[type=search]:focus, 
            .widget .searchform input[type=text]:focus, 
            .post-password-form input[type=password]:focus, 
            .comment-form-url input:focus,
            .comment-form-email input:focus,
            .comment-form-author input:focus,
            .comment-form-comment textarea:focus,
            #return-to-top:hover,
            .slick-custom-buttons:hover,
            body.dark #return-to-top:hover,
            body.dark .btn-simple:hover,
            body.dark .tags a:hover, 
            body.dark .tagcloud a:hover, 
            body.dark .wp-block-tag-cloud a:hover,
            body.dark .slick-custom-buttons:hover
            {
              border-color: {$primary_color};
            }
            
            blockquote,
            .wp-block-quote,
            .wp-block-quote.is-large, .wp-block-quote.is-style-large
            {
              border-left-color: {$primary_color};
            }

            .wp-block-quote.has-text-align-right 
            {
              border-right-color: {$primary_color};
            }

            .woocommerce-error, .woocommerce-info, .woocommerce-message
            {
              border-top-color: {$primary_color};
            }

            .lds-dual-ring:after {
              border-color: {$primary_color} transparent {$primary_color} transparent;
            }
            ";

        }

        if ($secondary_color)
        {

            $secondary_color = "
            .slick-next:hover:before, .slick-next:focus:before, .slick-prev:hover:before, .slick-prev:focus:before {
                color: {$secondary_color};
            }
          ";
        }

        if ($body_color)
        {

            $body_color = "
            {
              background: {$body_color};
            }
            body,
            .tags a,
            .tagcloud a,
            .wp-block-tag-cloud a,
            .btn-simple,
            .form-control, 
            .wp-block-search input[type=search], 
            .widget .searchform input[type=text], 
            .post-password-form input[type=password], 
            .comment-form-url input,
            .comment-form-email input,
            .comment-form-author input,
            .comment-form-comment textarea,
            .page-numbers,
            #return-to-top,
            .widget select,
            .wp-block-archives-list li span.widget-count,
            .wp-block-categories-dropdown select,
            .wp-block-archives-dropdown select,
            .wp-block-calendar table caption, .wp-block-calendar table tbody,
            .woocommerce ul.products li.product .price,
            .woocommerce div.product .woocommerce-tabs ul.tabs li a,
            .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover
            {
              color: {$body_color};
            }
            .nav-fill .nav-item > .nav-link {
              color: {$body_color} !important;
            }
          ";
        }

        if ($body_secondary_color)
        {

            $body_secondary_color = "
            {
              background: {$body_secondary_color};
            }

            .slogan,
            .post .meta,
            .post .meta a,
            .post .post-bottom .social-share .toggle-button,
            .post .post-bottom .social-share .icons li a,
            .post .post-bottom .more-button a,
            .post .post-bottom .more-link i,
            .comments li.comment .details .date,
            .comments li.trackback .details .date,
            .comments li.pingback .details .date,
            footer.footer .footer-inner .copyright,
            .breadcrumb li a,
            .breadcrumb li.active,
            .breadcrumb li:before,
            .form-control::-webkit-input-placeholder, 
            .wp-block-search input[type=search]::-webkit-input-placeholder, 
            .widget .searchform input[type=text]::-webkit-input-placeholder, 
            .post-password-form input[type=password]::-webkit-input-placeholder, 
            .comment-form-url input::-webkit-input-placeholder,
            .comment-form-email input::-webkit-input-placeholder,
            .comment-form-author input::-webkit-input-placeholder,
            .comment-form-comment textarea::-webkit-input-placeholder,
            .woocommerce .woocommerce-ordering select
            {
                color: {$body_secondary_color};
            }
            .form-control::-webkit-input-placeholder, .wp-block-search input[type=search]::-webkit-input-placeholder, .widget .searchform input[type=text]::-webkit-input-placeholder, .post-password-form input[type=password]::-webkit-input-placeholder, .comment-form-url input::-webkit-input-placeholder,
            .comment-form-email input::-webkit-input-placeholder,
            .comment-form-author input::-webkit-input-placeholder,
            .comment-form-comment textarea::-webkit-input-placeholder {
              /* Chrome/Opera/Safari */
              color: {$body_secondary_color};
            }

            .form-control::-moz-placeholder, .wp-block-search input[type=search]::-moz-placeholder, .widget .searchform input[type=text]::-moz-placeholder, .post-password-form input[type=password]::-moz-placeholder, .comment-form-url input::-moz-placeholder,
            .comment-form-email input::-moz-placeholder,
            .comment-form-author input::-moz-placeholder,
            .comment-form-comment textarea::-moz-placeholder {
              /* Firefox 19+ */
              color: {$body_secondary_color};
            }

            .form-control:-ms-input-placeholder, .wp-block-search input[type=search]:-ms-input-placeholder, .widget .searchform input[type=text]:-ms-input-placeholder, .post-password-form input[type=password]:-ms-input-placeholder, .comment-form-url input:-ms-input-placeholder,
            .comment-form-email input:-ms-input-placeholder,
            .comment-form-author input:-ms-input-placeholder,
            .comment-form-comment textarea:-ms-input-placeholder {
              /* IE 10+ */
              color: {$body_secondary_color};
            }

            .form-control:-moz-placeholder, .wp-block-search input[type=search]:-moz-placeholder, .widget .searchform input[type=text]:-moz-placeholder, .post-password-form input[type=password]:-moz-placeholder, .comment-form-url input:-moz-placeholder,
            .comment-form-email input:-moz-placeholder,
            .comment-form-author input:-moz-placeholder,
            .comment-form-comment textarea:-moz-placeholder {
              /* Firefox 18- */
              color: {$body_secondary_color};
            }
          ";
        }

        if ($headings_color)
        {

            $headings_color = "
            h1, h2, h3, h4, h5, h6 {
              color: {$headings_color};
            }
          ";

        }

        if ($content_color)
        {

            $content_color = "
            .table,
            .post-single .post-content,
            .page-content
            {
              color: {$content_color};
            }
          ";

        }

        if ($dark_text_color)
        {

            $dark_text_color = "
            a:hover,
            .text-logo,
            .post .post-bottom .social-share .icons li a:hover,
            .post .post-bottom .more-link,
            .about-author .details h4.name a,
            .comments li.comment .details h4.name a,
            .comments li.trackback .details h4.name a,
            .comments li.pingback .details h4.name a,
            .widget ul.list li a,
            .newsletter-headline,
            .social-icons a,
            th,
            dt,
            strong,
            .widget ul li a,
            .wp-block-archives-list li a,
            .wp-block-calendar table th,
            .post .post-title a:not(.featured-post-lg .post-title a, .post.post-over-content .post-title a, .featured-post-md .post-title a, .featured-post-xl .post-title a, :hover)
            {
              color: {$dark_text_color};
            }
          ";

        }

        if ($menu_color)
        {

            $menu_color = "
            .navbar-nav .nav-link
            {
              color: {$menu_color};
            }
          ";

        }

        if ($menu_hover_color)
        {

            $menu_hover_color = "
            .navbar-nav .nav-link:hover
            {
              color: {$menu_hover_color};
            }
          ";

        }

        if ($canvas_menu_color)
        {

            $canvas_menu_color = "
            .canvas-menu .vertical-menu li a
            {
              color: {$canvas_menu_color};
            }
          ";

        }

        if ($canvas_menu_hover_color)
        {

            $canvas_menu_hover_color = "
            .canvas-menu .vertical-menu li a:hover
            {
              color: {$canvas_menu_hover_color};
            }
          ";

        }

        if ($canvas_submenu_color)
        {

            $canvas_submenu_color = "
            .canvas-menu .sub-menu li a
            {
              color: {$canvas_submenu_color};
            }
          ";

        }

        if ($canvas_submenu_hover_color)
        {

            $canvas_submenu_hover_color = "
            .canvas-menu .sub-menu li a:hover
            {
              color: {$canvas_submenu_hover_color};
            }
          ";

        }

        if ($preloader_bg)
        {

            $preloader_bg = "
            #preloader {
              background: {$preloader_bg};
            }
          ";

        }

        if ($content_width)
        {

            $content_width = "
            .post-container {
              max-width: {$content_width}px;
            }
          ";

        }

        if ($dark_bg_color)
        {

            $dark_bg_color = "
            body.dark,
            body.dark header,
            body.dark .header-default.clone,
            body.dark .search-popup, 
            body.dark .canvas-menu,
            body.dark .site-wrapper .main-overlay
            {
              background-color: {$dark_bg_color};
            }
          ";

        }
        
        wp_add_inline_style('katen-theme-color', $body_bg_color);
        wp_add_inline_style('katen-theme-color', $primary_color);
        wp_add_inline_style('katen-theme-color', $secondary_color);
        wp_add_inline_style('katen-theme-color', $body_color);
        wp_add_inline_style('katen-theme-color', $body_secondary_color);
        wp_add_inline_style('katen-theme-color', $headings_color);
        wp_add_inline_style('katen-theme-color', $content_color);
        wp_add_inline_style('katen-theme-color', $dark_text_color);
        wp_add_inline_style('katen-theme-color', $menu_color);
        wp_add_inline_style('katen-theme-color', $menu_hover_color);
        wp_add_inline_style('katen-theme-color', $canvas_menu_color);
        wp_add_inline_style('katen-theme-color', $canvas_menu_hover_color);
        wp_add_inline_style('katen-theme-color', $canvas_submenu_color);
        wp_add_inline_style('katen-theme-color', $canvas_submenu_hover_color);
        wp_add_inline_style('katen-theme-color', $preloader_bg);
        wp_add_inline_style('katen-theme-color', $content_width);
        wp_add_inline_style('katen-theme-color', $dark_bg_color);
    }
    add_action('wp_enqueue_scripts', 'katen_theme_custom_css', PHP_INT_MAX);
}