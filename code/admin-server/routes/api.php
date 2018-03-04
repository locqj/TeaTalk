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

        /*兴趣圈*/
        $api->get('getintmoment/{user_code}', 'IntMomentsController@getMoments');
        $api->post('addintmoment', 'IntMomentsController@addMoments');

        $api->post('friends/getownfriends', 'FriendsController@getFriends');
        $api->get('friends/getfriends', 'FriendsController@getFriendsList');
        $api->get('friends/getwaitacceptusers', 'FriendsController@getWaitAcceptUsers');
        $api->get('friends/getacceptusers', 'FriendsController@getAcceptUsers');
        $api->get('friends/getlist', 'FriendsController@getLists');
        $api->get('friends/getusers', 'FriendsController@doFindUsers');
        /*查询用户详情*/
        $api->get('friends/getuser', 'FriendsController@getFriendDetails');

        /*添加用户*/
        $api->post('friends/doadd', 'FriendsController@doAddFriend');
        /*接受添加用户*/
        $api->post('friends/doaccept', 'FriendsController@doAcceptFriend');
        /*拒绝添加用户*/
        $api->post('friends/dorefuse', 'FriendsController@doRefuseFriend');

        /*获取自己的moments*/
        $api->post('own/moments', 'MomentsController@ownMoments');
        $api->get('test', 'MomentsController@test');

    });

    $api->group(['namespace' => 'App\Api\Controllers', 'middleware'=>'jwt.auth'],function ($api){
       $api->get('lessons','LessonsController@index');
       $api->get('lessons/{id}','LessonsController@show');
    });
});
