<!-- Dashboard -->
<li class="menu-item <?php echo ((uri_string() == 'principal') ? 'active' : ''); ?> ">
    <a href="<?php echo base_url('principal'); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Inicio</div>
    </a>
</li>

<li class="menu-item <?php echo ((uri_string() == 'pagos') ? 'active' : ''); ?>">
    <a href="<?php echo base_url('pagos'); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dollar"></i>
        <div data-i18n="Analytics">Pagos</div>
    </a>
</li>

<!-- Layouts -->
<!--<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dollar"></i>
        <div data-i18n="Layouts">Pagos</div>
    </a>

    <ul class="menu-sub">
        <li class="menu-item">
            <a href="layouts-without-menu.html" class="menu-link">
                <div data-i18n="Without menu">Without menu</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="layouts-without-navbar.html" class="menu-link">
                <div data-i18n="Without navbar">Without navbar</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="layouts-container.html" class="menu-link">
                <div data-i18n="Container">Container</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="layouts-fluid.html" class="menu-link">
                <div data-i18n="Fluid">Fluid</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="layouts-blank.html" class="menu-link">
                <div data-i18n="Blank">Blank</div>
            </a>
        </li>
    </ul>
</li>-->