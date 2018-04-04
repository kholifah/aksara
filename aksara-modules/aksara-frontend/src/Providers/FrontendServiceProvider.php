<?php

namespace Frontend\Aksara\Providers;

use Aksara\Providers\AbstractModuleProvider;

class FrontendServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        \Eventy::addAction('aksara.init', function () {
            register_menu(
                ['primary' => [
                    'label' => __('aksara-frontend::default.primary')
                ]]
            );

            register_menu(
                ['footer' => [
                    'label' => __('aksara-frontend::default.footer')
                ]]
            );
            register_image_size('masthead',0,600);

            // Enqueue Style
            aksara_enqueue_style(url("assets/modules-v2/aksara-frontend/vendor/bootstrap/css/bootstrap.min.css"));
            aksara_enqueue_style(url("assets/modules-v2/aksara-frontend/vendor/font-awesome/css/font-awesome.min.css"));
            aksara_enqueue_style('https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic');
            aksara_enqueue_style('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
            aksara_enqueue_style(url("assets/modules-v2/aksara-frontend/css/clean-blog.css"));
            aksara_enqueue_style(url("assets/modules-v2/aksara-multi-bas/css/flag-icon.min.css"), "flag-icon" , 25, true);

            // Enqueue Script
            aksara_enqueue_script(url("assets/modules-v2/aksara-frontend/vendor/jquery/jquery.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/aksara-frontend/vendor/popper/popper.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/aksara-frontend/vendor/bootstrap/js/bootstrap.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/aksara-frontend/js/clean-blog.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/aksara-frontend/js/custom.js"));

            add_page_template('Contact Form', 'aksara-frontend::page-contact-form');
            add_page_template('About Us', 'aksara-frontend::page-about-us');

        });
    }
}

