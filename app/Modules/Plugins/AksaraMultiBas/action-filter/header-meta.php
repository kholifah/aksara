<?php
/*
 * Add locale header tag
 */
\Eventy::addAction('aksara.front-end.head',function(){
    $locales = get_registered_locales();

    if(sizeof($locales)==0) {
        return;
    }

    if(is_default_multibas_locale()) {
        echo '<link rel="canonical" href="'.url('/').'"/>'."\n";
    }
    else {
        echo '<link rel="canonical" href="'.url('/').get_current_multibas_locale().'"/>'."\n";
    }

    foreach ($locales as $locale) {

        if(is_default_multibas_locale($locale['language_code'])) {
            echo '<link rel="alternate" hrefLang="'.$locale['language_code'].'" href="'.url('/').'"/>'."\n";
        }
        else {
            echo '<link rel="alternate" hrefLang="'.$locale['language_code'].'" href="'.url('/'.$locale['language_code']).'"/>'."\n";
        }
    }
});
