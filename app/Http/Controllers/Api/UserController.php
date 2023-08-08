<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Authenticate a user and generate an access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginUser(Request $request)
    {
        // Attempt to authenticate the user with provided credentials (email and password)
        if (Auth::attempt($request->only(['email', 'password']))) {
            // If the authentication is successful, create an access token for the user
            $user = Auth::user();
            $token = $user->createToken('asset-management')->accessToken;
            $username = $user->name;
            $accountType = $user->account_type;

            // Retrieve user permissions for the authenticated user
            $getPermission = UserPermission::select(
                'user_permissions.asset_create',
                'user_permissions.asset_update',
                'user_permissions.asset_transfer',
                'user_permissions.asset_device',
                'user_permissions.asset_dispose',
                'user_permissions.asset_download',
                'user_permissions.dashboard',
                'user_permissions.license_create',
                'user_permissions.license_update',
                'user_permissions.license_delete',
                'user_permissions.asset_upload',
                'user_permissions.view_logs',
                'user_permissions.dev_tools',

            )
                ->where('user_id', $user->id)
                ->get();

            // Return the access token, user permissions, username, and account type as a response with HTTP status code 200 (OK)
            return response([
                'token' => $token,
                'permission' => $getPermission,
                'username' => $username,
                'accountType' => $accountType
            ], 200);
        } else {
            // If authentication fails, return an error response with HTTP status code 401 (Unauthorized)
            return response(['status' => 401, 'message' => 'Invalid Credentials'], 401);
        }
    }

    /**
     * Get a list of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        // Retrieve a list of all users from the database
        $userList = User::select(
            'id',
            'name',
            'email',
            'password',
            'account_type'
        )->get();

        // Return the user list as a response with HTTP status code 200 (OK)
        return response([
            'status' => 200,
            'list' => $userList
        ], 200);
    }

    /**
     * Get details of the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserDetails()
    {
        // Check if the user is authenticated (via API guard)
        if (Auth::guard('api')->check()) {
            // If authenticated, retrieve the authenticated user's details
            $user = Auth::guard('api')->user();
            return response(['data' => $user], 200);
        }
        // If not authenticated, return an error response with HTTP status code 401 (Unauthorized)
        return response(['message' => 'Unauthorized Access'], 401);
    }

    /**
     * Log out the authenticated user by revoking the access token.
     *
     * @return \Illuminate\Http\Response
     */
    public function userLogout()
    {
        // Check if the user is authenticated (via API guard)
        if (Auth::guard('api')->check()) {
            // If authenticated, revoke the access token and delete it
            $accessToken = Auth::guard('api')->user()->token();

            DB::table('personal_access_tokens')
                ->where('tokenable_id', $accessToken->tokenable_id)
                ->update(['revoked' => true]);

            $accessToken->delete();
            // Return a success response with HTTP status code 200 (OK)
            return response(['message' => 'Logged Out'], 200);
        }
        // If not authenticated, return an error response with HTTP status code 401 (Unauthorized)
        return response(['message' => 'Unauthorized Access'], 401);
    }

    /**
     * Register a new user account along with user permissions.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function registerAccount(UserRequest $request)
    {
        // Create a new User object and store it in the database
        $register = new User();
        $register->name = $request->input('name');
        $register->email = $request->input('email');
        $register->password = $request->input('password');
        $register->account_type = $request->input('account_type');
        $register->save();

        // Create a new UserPermission object and store it in the database with permissions
        $userPermission = new UserPermission();
        $userPermission->user_id =  $register->id;
        $userPermission->asset_create = $request->input('Asset_create');
        $userPermission->asset_update = $request->input('Asset_update');
        $userPermission->asset_transfer = $request->input('Asset_transfer');
        $userPermission->asset_device = $request->input('Asset_device');
        $userPermission->asset_dispose = $request->input('Asset_dispose');
        $userPermission->asset_download = $request->input('Asset_download');
        $userPermission->dashboard = $request->input('Dashboard');
        $userPermission->license_create = $request->input('License_create');
        $userPermission->license_update = $request->input('License_update');
        $userPermission->license_delete = $request->input('License_delete');
        $userPermission->asset_upload = $request->input('Asset_upload');
        $userPermission->view_logs = $request->input('View_logs');
        $userPermission->dev_tools = $request->input('Dev_tools');
        $userPermission->save();

        // Return a success response with HTTP status code 200 (OK)
        return response(['status' => 200], 200);
    }

    /**
     * Update the password for a specific user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        // Find the User object with the given $id in the database
        $update_password = User::find($id);

        // Update the 'password' attribute of the User object with the new value from the request ('genPass')
        $update_password->password = $request->input('genPass');

        // Save the updated User object to the database
        $update_password->save();

        // Return a success response with HTTP status code 200 (OK)
        return response(['status' => 200], 200);
    }

    /**
     * Delete a user account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount($id)
    {
        // Find the User object with the given $id in the database
        $delete_account = User::find($id);

        // If the User object is found, delete it from the database
        if ($delete_account) {
            $delete_account->delete();
            // Return a success response with HTTP status code 200 (OK)
            return response(['status' => 200], 200);
        }
        // If the User object is not found, return a response with HTTP status code 200 (OK) and no data
        return response(['status' => 200], 200);
    }
}
