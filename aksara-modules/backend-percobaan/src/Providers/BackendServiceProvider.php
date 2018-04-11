<?php

namespace Backend\Percobaan\Providers;

use Aksara\Providers\AbstractModuleProvider;

class BackendServiceProvider extends AbstractModuleProvider
{
    protected function safeBoot()
    {
        \Eventy::addAction('aksara.init', function () {
            // Load Jquery on Top
            aksara_admin_enqueue_script(url('assets/modules-v2/backend-percobaan/js/jquery.min.js'),'jquery',10,false);
            aksara_admin_enqueue_script(url('assets/modules-v2/backend-percobaan/js/bootstrap.min.js'),'jquery',10,false);

            // Code Miror
            aksara_admin_enqueue_script(url('assets/modules-v2/backend-percobaan/lib/codemirror/js/codemirror.js'),'codemirror',10,true);
            aksara_admin_enqueue_style(url('assets/modules-v2/backend-percobaan/lib/codemirror/css/codemirror.css'),'codemirror');

            // Base Script
            aksara_admin_enqueue_script(url('assets/modules-v2/backend-percobaan/js/script.min.js'),'aksara-admin-script',10,true);
            aksara_admin_enqueue_style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300|Noto+Sans:400,700');
            aksara_admin_enqueue_style(url('assets/modules-v2/backend-percobaan/css/base.css'));
            aksara_admin_enqueue_style(url('assets/modules-v2/backend-percobaan/css/custom.css'));
            aksara_admin_enqueue_style(url('assets/modules-v2/backend-percobaan/css/style.css'));

            //jquery dataTable
            aksara_admin_enqueue_style(url('assets/plugins/datatables/jquery.dataTables.min.css'));
            aksara_admin_enqueue_style(url('assets/plugins/datatables/responsive.bootstrap.min.css'));
        });

        \Eventy::addFilter('aksara.email_reset_password', function ($name) {
            return 'backend-percobaan::emails.forgot-password';
        });
    }
}
