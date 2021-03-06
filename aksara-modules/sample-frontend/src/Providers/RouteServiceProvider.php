<?php
namespace Frontend\Sample\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function boot()
    {
        \Eventy::addAction('aksara.init-completed', function () {

            register_menu(
              ['primary' => [
                            'label' => __('sample-frontend::global.primary')
                            ]]
                          );

            register_menu(
              ['footer' => [
                            'label' => __('sample-frontend::global.footer')
                          ]]
                        );
            // register_image_size('thumbnail',500,500,true);
            // register_image_size('thumbnail-2',600,600,false);
            // register_image_size('large',1200,900,true);
            // register_image_size('mashead',0,900,true);
            register_image_size('masthead',0,600);

            // Enqueue Style
            aksara_enqueue_style(url("assets/modules-v2/sample-frontend/vendor/bootstrap/css/bootstrap.min.css"));
            aksara_enqueue_style(url("assets/modules-v2/sample-frontend/vendor/font-awesome/css/font-awesome.min.css"));
            aksara_enqueue_style('https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic');
            aksara_enqueue_style('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
            aksara_enqueue_style(url("assets/modules-v2/sample-frontend/css/clean-blog.css"));

            //TODO check if multibas active if needed
            aksara_enqueue_style(url("assets/modules-v2/aksara-multi-bas/css/flag-icon.min.css"), "flag-icon" , 25, true);

            // Enqueue Script
            aksara_enqueue_script(url("assets/modules-v2/sample-frontend/vendor/jquery/jquery.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/sample-frontend/vendor/popper/popper.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/sample-frontend/vendor/bootstrap/js/bootstrap.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/sample-frontend/js/clean-blog.min.js"));
            aksara_enqueue_script(url("assets/modules-v2/sample-frontend/js/custom.js"));

            add_page_template('Contact Form', 'sample-frontend::page-contact-form');
            add_page_template('About Us', 'sample-frontend::page-about-us');
        });
    }
}
