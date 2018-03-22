var app = new Vue({
    delimiters: ['${', '}'],
    el: '#multibas-option',
    data: {
        lang_options: lang_options,
        selected_country: lang_options["af:af_ZA:za"],
        countries: countries
    },
    methods: {
        addCountry: function(selected_country) {

            selected_country = Vue.util.extend({}, selected_country)

            if( this.countries.length == 0 ) {
                selected_country.default = true;
            }
            else {
                selected_country.default = false;
            }

            this.countries.push(selected_country)
        },
        removeCountry: function(index) {
            this.countries.splice(index, 1);
        },
        makeDefault: function(index) {
            this.countries = this.countries.filter(function(value,key){
                value.default = false;
                return value;
            })

            this.countries[index].default = true;
        }
    }
})
