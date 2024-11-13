<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSetting;
use App\Facebook\LaravelPersistentDataHandler;

class MeFacebookController extends Controller
{
    /**
     * Show the facebook settings page for the logged in user
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        // Get user settings
        $setting = UserSetting::findOrFail(Auth()->user()->settings->id);

        $url           = null;
        $facebookPhoto = null;

        $fb = new \Facebook\Facebook([
            'app_id'                  => config('facebook.app_id'),
            'app_secret'              => config('facebook.app_secret'),
            'default_graph_version'   => 'v19.0',
            'persistent_data_handler' => new LaravelPersistentDataHandler(),
        ]);

        // See if the user already has a fb token
        if (session()->missing('facebook_token'))
        {
            $helper = $fb->getRedirectLoginHelper();

            $permissions = ['user_photos'];

            $url = $helper->getLoginUrl(route('my.facebook.callback'), $permissions);
        }
        else
        {
            $token = session('facebook_token');

            try
            {
                $response = $fb->get('/10159659745606199/photos?fields=images', $token);
                $photos = $response->getGraphEdge();

                $response = $fb->get('/10159659745606199/picture?redirect=0&type=large', $token);
                $node = $response->getGraphUser();
                $facebookPhoto = $node->getField('url');
            }
            catch(Facebook\Exception\ResponseException $e)
            {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            }
            catch(Facebook\Exception\SDKException $e)
            {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $helper = $fb->getRedirectLoginHelper();

            $url = $helper->getLogoutUrl($token, route('my.facebook'));

        }

        return view('me.facebook', [
            'user'  => Auth()->user(),
            'url'   => $url,
            'photo' => $facebookPhoto,
        ]);
    }

    /**
     * callback 
     * 
     * @return null
     */
    public function callback()
    {
        // Get user settings
        $setting = UserSetting::findOrFail(Auth()->user()->settings->id);

        // Get facebook token
        $fb = new \Facebook\Facebook([
            'app_id'                  => config('facebook.app_id'),
            'app_secret'              => config('facebook.app_secret'),
            'default_graph_version'   => 'v19.0',
            'persistent_data_handler' => new LaravelPersistentDataHandler(),
        ]);

        $helper = $fb->getRedirectLoginHelper();

        //$_SESSION['FBRLH_state'] = $_GET['state'];

        try
        {
            $token = $helper->getAccessToken();
        }
        // Catch Facebook issue
        catch(Facebook\Exception\ResponseException $e)
        {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        }
        // Catch SDK or local issue
        catch(Facebook\Exception\SDKException $e)
        {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        // Make sure we always have a long lived token
        if (!$token->isLongLived())
        {
            try
            {
                $token = $oAuth2Client->getLongLivedAccessToken($token);
            }
            catch (Facebook\Exception\SDKException $e)
            {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }
        }

        session(['facebook_token' => $token->getValue()]);

        // Save token
        $setting->facebook_token = $token->getValue();
        $setting->save();

        return redirect()->route('my.facebook');
    }
}
