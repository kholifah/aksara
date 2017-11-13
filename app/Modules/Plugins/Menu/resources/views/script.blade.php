<script>
    var vms = []; // vue app
</script>
<?php
$menus = get_registered_menu();
$menus_data = get_menus(true);

foreach ($menus as $id => $dataMenuUser) {
    ?>
    <script>


    vms['<?php echo $id ?>'] = new Vue({
        delimiters: ['${', '}'],
        el: '#<?php echo $id; ?>-form-app',
        methods: {
            addMenuLevelOne: function () {

                var menu = {
                    data: {
                        label: "Menu",
                        class: "",
                        url: "",
                        display:"block"
                    },
                    menus: []
                };
                // console.log(this.menus)
                this.menus.push(menu);
            },
            addMenu: function (menu, index_menu, index_sub_menu) {

                if (typeof index_sub_menu !== 'undefined') {
                    var menu = {
                        data: {
                            label: "Sub Sub Menu",
                            class: "",
                            url: "",
                            display:"block"
                        }
                    };
                    this.menus[index_menu].menus[index_sub_menu].menus.push(menu)
                } else {
                    var menu = {
                        data: {
                            label: "Sub Menu",
                            class: "",
                            url: "",
                            display:"block"
                        },
                        menus: []
                    };
                    this.menus[index_menu].menus.push(menu)
                }
            },
            showMenu: function  (menu, index_menu, index_sub_menu, index_sub_sub_menu)
            {
                Vue.set(menu.data,'display',"block");
            },
            hideMenu: function  (menu, index_menu, index_sub_menu, index_sub_sub_menu)
            {
                Vue.set(menu.data,'display',"none");
            },
            deleteMenu: function (menu, index_menu, index_sub_menu, index_sub_sub_menu) {
                if (typeof index_sub_menu === 'undefined' && typeof index_sub_sub_menu == 'undefined') {
                    this.menus.splice(index_menu, 1)
                } else if (typeof index_sub_sub_menu == 'undefined') {
                    this.menus[index_menu].menus.splice(index_sub_menu, 1)
                } else {
                    this.menus[index_menu].menus[index_sub_menu].menus.splice(index_sub_sub_menu, 1)
                }
            }
        },
        data: {
                menus: <?php
                            if (isset($menus_data[$id]))
                                echo $menus_data[$id];
                            else
                                echo '[]';
                        ?>
                }
    })



    </script>
    <?php
}
