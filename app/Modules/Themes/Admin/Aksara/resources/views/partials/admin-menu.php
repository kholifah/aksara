<ul>
<?php foreach ($adminMenu as $position => $menu): ?>
    <?php foreach ($menu as $menuKey => $menuArgs): ?>
        <?php
        $has_sub = "";
        if (isset($adminSubMenu[$menuArgs['routeName']]))
            $has_sub = "has_sub";

        if ($has_sub):
            ?>
            <li class="<?php echo $has_sub ?>">
                <a href="javascript:void(0);" class=""><i class="<?php echo $menuArgs['icon'] ?>"></i> <span> <?php echo $menuArgs['menu_title'] ?> </span> <span class="menu-arrow"></span></a>
                <?php if ($has_sub): ?>
                    <ul class="list-unstyled">
                        <?php
                        foreach ($adminSubMenu[$menuArgs['routeName']] as $subMenu) :
                            echo '<li><a href="' . route($subMenu['routeName']) . '" data-route="' . $subMenu['routeName'] . '" >' . $subMenu['menu_title'] . '</a></li>';
                        endforeach;
                        ?>
                    </ul>
                <?php endif; ?>
            </li>
            <?php
        else:
            ?>
            <li class="active">
                <?php echo '<a href="' . route($menuArgs['routeName']) . '" data-route="' . $menuArgs['routeName'] . '" ><i class="' . $menuArgs['icon'] . '"></i><span>' . $menuArgs['menu_title'] . '</span></a>'; ?>
            </li>
        <?php
        endif;
    endforeach;
endforeach;
?>
 </ul>
