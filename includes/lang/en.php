<?php 
function lang($pharse) {
    static $lang = array(
        'CATEGORIES'    => 'Categories',
        'Home_PAGE'     => 'Home',
        'ITEMS'         => 'Items',
        'MEMBERS'       => 'Memeber',
        'STATISTICS'    => 'Statistics',
        'LOGS'          => 'Logs',
        ''              => '',
        ''              => ''

    );
    return $lang[$pharse];
}