<?php
    Route::get('login/test_login', 'TestLoginController@index')->name('test_login');
    Route::post('login/login', 'TestLoginController@login')->name('login-login');
    Route::get('login/logout', 'TestLoginController@logout')->name('login-logout');
?>