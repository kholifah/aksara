<?php

\Eventy::addAction('aksara.init', function () {
    register_menu(
      ['primary' => [
                    'label' => 'Primary'
                    ]]
                  );

    register_menu(
      ['footer' => [
                    'label' => 'Footer'
                  ]]
                );

    register_menu(
      ['top' => [
                    'label' => 'Top'
                  ]]
                );

    // Load Jquery on Top
    aksara_admin_enqueue_script(url('assets/modules/Admin/Aksara/js/jquery.min.js'),'jquery',10,false);
    aksara_admin_enqueue_script(url('assets/modules/Admin/Aksara/js/bootstrap.min.js'),'jquery',10,false);

    // Code Miror
    aksara_admin_enqueue_script(url('assets/modules/Admin/Aksara/lib/codemirror/js/codemirror.js'),'codemirror',10,true);
    aksara_admin_enqueue_style(url('assets/modules/Admin/Aksara/lib/codemirror/css/codemirror.css'),'codemirror');

    // Base Script
    aksara_admin_enqueue_script(url('assets/modules/Admin/Aksara/js/script.min.js'),'aksara-admin-script',10,true);
    aksara_admin_enqueue_style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300|Noto+Sans:400,700');
    aksara_admin_enqueue_style(url('assets/modules/Admin/Aksara/css/base.css'));
    aksara_admin_enqueue_style(url('assets/modules/Admin/Aksara/css/custom.css'));

});

//@TODO Enqueue semua script dan css admin side kesini

/**
  * Header
  * 1. script utama admin
  * 2. JS Jquery
  * Footer
  * 2. script utama admin
  */
