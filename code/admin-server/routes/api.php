<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*'middleware' => ['jwt.api.auth']*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers'], function ($api) {

        $api->post('user/login','AuthController@authenticate');

        $api->post('user/register','RegisterController@register');
	    $api->post('uploadheadimg','UploadsController@uploadHeadImg');
        $api->get('user/register/interesttag', 'RegisterController@getInterestTag');

        $api->post('addmoment', 'MomentsController@addMoments');
        $api->get('getmoment/{user_code}', 'MomentsController@getMoments');
        $api->get('getzan', 'MomentsController@getZans');
        $api->get('dozan', 'MomentsController@doZans');
        $api->post('docomment', 'MomentsController@doComment');

        $api->post('friends/getownfriends', 'FriendsController@getFriends');
        $api->get('friends/getfriends', 'FriendsController@getFriendsList');
        $api->get('friends/getwaitacceptusers', 'FriendsController@getWaitAcceptUsers');
        $api->get('friends/getacceptusers', 'FriendsController@getAcceptUsers');
        $api->get('friends/getlist', 'FriendsController@getLists');
        $api->get('friends/getusers', 'FriendsController@doFindUsers');
        $api->get('friends/getuser', 'FriendsController@getFriendDetails');
        $api->post('friends/doadd', 'FriendsController@doAddFriend');
        $api->post('friends/doaccept', 'FriendsController@doAcceptFriend');
        $api->post('friends/dorefuse', 'FriendsController@doRefuseFriend');



        $api->get('test', 'MomentsController@test');
    });

    $api->group(['namespace' => 'App\Api\Controllers', 'middleware'=>'jwt.auth'],function ($api){
       $api->get('lessons','LessonsController@index');
       $api->get('lessons/{id}','LessonsController@show');
    });
});
