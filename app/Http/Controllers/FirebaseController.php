<?php

// app/Http/Controllers/FirebaseController.php

namespace App\Http\Controllers;

use App\Services\FireBaseNotificationTriggerService;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    protected $firebaseService;

    public function __construct(FireBaseNotificationTriggerService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function getAccessToken(Request $request)
    {
        try {
          return  $accessToken = $this->firebaseService->getAccessToken();
            return response()->json(['access_token' => $accessToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
