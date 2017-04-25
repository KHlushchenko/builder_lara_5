<?php
$menuLinks = config('builder.admin.menu');

if ($menuLinks) {

    $all_links = array();
    array_walk_recursive($menuLinks, function($item, $key) use (&$all_links) {
        if($key == 'link'){
            $all_links[] = $item;
        }
    });

    $all_links = array_flatten($all_links);
    $all_links_str = implode("|", $all_links);
    $all_links_str = str_replace("/", "", $all_links_str);

    Route::pattern('page_admin', $all_links_str);
    Route::pattern('tree_name', '[a-z0-9-_]+');
    Route::pattern('any', '[a-z0-9-_/\]+');
    Route::group(['middleware' => ['web']], function () {
        Route::group(
            ['prefix' => 'admin', 'middleware' => 'auth.admin'],
            function () {

                Route::any(
                    '/tree',
                    'Vis\Builder\TableAdminController@showTree'
                );
                Route::any(
                    '/handle/tree',
                    'Vis\Builder\TableAdminController@handleTree'
                );

                Route::any(
                    '/{tree_name}_tree',
                    'Vis\Builder\TableAdminController@showTreeOther'
                );
                Route::any(
                    '/handle/{tree_name}_tree',
                    'Vis\Builder\TableAdminController@handleTreeOther'
                );

                Route::post(
                    '/show_all_tree/{tree_name}',
                    'Vis\Builder\TableAdminController@showTreeAll'
                );

                //router for pages builder
                Route::get(
                    '/{page_admin}',
                    'Vis\Builder\TableAdminController@showPage'
                );
                if (Request::ajax()) {
                    Route::get (
                        '/{page_admin}',
                        'Vis\Builder\TableAdminController@showPagePost'
                    );
                }

                Route::post(
                    '/handle/{page_admin}',
                    'Vis\Builder\TableAdminController@handlePage'
                );

                // view showDashboard
                Route::get('/', 'Vis\Builder\TBController@showDashboard');

                // logout
                Route::get('logout', array (
                        'as' => 'logout',
                        'uses' => 'Vis\Builder\LoginController@doLogout'
                    ));

                //routes for froala editor

                Route::post('upload_file', array (
                        'as' => 'upload_file',
                        'uses' => 'Vis\Builder\EditorController@uploadFile'
                    ));
                Route::get('load_image', array (
                        'as' => 'load_image',
                        'uses' => 'Vis\Builder\EditorController@loadImages'
                    ));
                Route::post('delete_image', array (
                        'as' => 'delete_image',
                        'uses' => 'Vis\Builder\EditorController@deleteImages'
                    ));

                Route::post('quick_edit', array (
                        'as' => 'quick_edit',
                        'uses' => 'Vis\Builder\EditorController@doQuickEdit'
                    ));

                //change skin for admin panel
                Route::post('change_skin', array (
                        'as' => 'change_skin',
                        'uses' => 'Vis\Builder\TBController@doChangeSkin'
                    ));

                Route::get('change_lang', array (
                        'as' => 'change_lang',
                        'uses' => 'Vis\Builder\TBController@doChangeLangAdmin'
                    ));

                Route::any('/photos/gallery', array (
                        'as' => 'photos_all',
                        'uses' => 'Vis\Builder\PhotosController@fetchShowAll'
                    ));
                Route::post('/photos/save_album', array (
                        'as' => 'save_album',
                        'uses' => 'Vis\Builder\PhotosController@doSaveAlbum'
                    ));

                Route::post('upload_image', array (
                        'as' => 'upload_image',
                        'uses' => 'Vis\Builder\EditorController@uploadFoto'
                    ));

                Route::post('save_croped_img', array (
                        'as' => 'save_croped_img',
                        'uses' => 'Vis\Builder\TBController@doSaveCropImg'
                    ));
                Route::post('change-relation-field', array (
                    'as' => 'change-relation-field',
                    'uses' => 'Vis\Builder\TableAdminController@doChangeRelationField'
                ));
              
            }
        );
    });
    
    // login post

    Route::group(['middleware' => ['web']], function () {
        Route::get('login', array (
                'as' => 'login_show',
                'uses' => 'Vis\Builder\LoginController@showLogin'
            ));
        Route::get('login', array (
                'as' => 'login_show',
                'uses' => 'Vis\Builder\LoginController@showLogin'
            ));
        Route::post('login', array (
                'as' => 'login',
                'uses' => 'Vis\Builder\LoginController@postLogin'
            ));


    });
    //login show
}
