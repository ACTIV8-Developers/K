<?php
/*
|--------------------------------------------------------------------------
| Definitions of all hooks comes here.
|--------------------------------------------------------------------------
*/
$app->hook('before.routing', function($app) {
   if(true) 
        return;

   $setup = [
        'create_controllers_from_routes' => true,
        'create_users_table' => true,
        'create_pages_table' => true,

       'languages' => [
           'default'=>'latin',
           'languages'=>['en', 'cyr']
       ]
   ];

    /*
    |--------------------------------------------------------------------------
    | Create controllers
    |--------------------------------------------------------------------------
    */
    if($setup['create_controllers_from_routes']) {
        $routes = $app['router']->getRoutes();
        $list = [];
        foreach($routes as $r) {
            $c = $r->getCallable();
            $list[$c[0]][] = $c[1];
        }

        foreach($list as $cont => $func) {
            $pref = '';
            $cont = explode('/', $cont);
            if(count($cont )>1) {
                $pref = $cont[0].'/';
                if(!file_exists(APP.'Controllers/'.stripslashes($pref))) {
                    mkdir(APP.'Controllers/'.stripslashes($pref), 0750);
                }
            }
            $cont = end($cont);

            if(!file_exists(APP.'Controllers/'.$pref.$cont.'.php')) {
                $content = '';
                $content .= "<?php\n\n";

                $content .= 'class '.$cont;
                $content .= " extends Controller\n{";

                foreach($func as $f) {
                    $content .= "\n    public function ".$f."()\n    {";
                    $content .= "\n\n";
                    $content .= "    }\n";
                }
                $content .= "}";
                file_put_contents(APP.'Controllers/'.$pref.$cont.'.php', $content, LOCK_EX);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Create database tables
    |--------------------------------------------------------------------------
    */
    if($setup['create_users_table']) {
        $db = $app['dbdefault'];
        $params = [
            'user_id'	=> 'INT AUTO_INCREMENT NOT NULL',
            'user_name'	=> 'varchar(127)',
            'user_pass'	=> 'varchar(255)',
            'user_created_on'=> 'DATETIME',
            'user_last_login'=> 'DATETIME',
            ];
        $db->createTable('users', $params);
    }

    if($setup['create_pages_table']) {
        $db = $app['dbdefault'];
        $params = [
            'page_id' => 'INT AUTO_INCREMENT NOT NULL',
            'slug'	=> 'varchar(127)'
        ];

        if($setup['languages']) {
            $params['content_'.$setup['languages']['default']] = 'varchar(4095)';
            foreach($setup['languages']['languages'] as $val) {
                $params['content_'.$val] = 'varchar(4095)';
            }
        } else {
            $params['content'] = 'varchar(4095)';
        }
        $db->createTable('pages', $params);
    }
    die();
});