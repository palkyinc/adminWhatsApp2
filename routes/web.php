<?php

use Illuminate\Support\Facades\Route;
use App\Custom\MyFunctions;
use Illuminate\Http\Request;
use App\Http\Controllers\WaMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/conversations', [WaMessageController::class, 'index']);

Route::post('/whatssAppWebHoo', [WaMessageController::class, 'store']);
### Massages to Meta
Route::post('/markMenssageAsRead', [WaMessageController::class, 'markMenssageAsRead']); // enviar => {"wa_messages_id": 11}
Route::post('/sendTextMessage', [WaMessageController::class, 'sendTextMessage']); // {"to" : 542964516469, "body" : "Mensaje de Prueba"}
Route::post('/sendReplayToTextMessage', [WaMessageController::class, 'sendReplayToTextMessage']); // {"prev_messages_id" : "wamid.HBgNNTQ5Mjk2NDUxNjQ2ORUCABIYFDNBQjk4MzlBNkIyOEQ3NTE5MUIwAA==", "to" : 542964516469, "body" : "Mensaje de Prueba"}
Route::post('/sendReplayWithReactionMessage', [WaMessageController::class, 'sendReplayWithReactionMessage']); // {"emoji" : "\uD83D\uDE00", "messages_id" : "wamid.HBgNNTQ5Mjk2NDUxNjQ2ORUCABIYFDNBQjk4MzlBNkIyOEQ3NTE5MUIwAA==", "to" : 542964516469}
Route::post('/sendImageMessageByUrl', [WaMessageController::class, 'sendImageMessage']); // {"image_id": "<IMAGE_OBJECT_ID>", "image_link" : "https://", "to" : 542964516469}
Route::post('/downloadMedia', [WaMessageController::class, 'downloadMedia']);  //{"wa_message_table_id": 22}


/* Route::post('/whatssAppWebHoo', function (Request $request) {
    MyFunctions::loguear('a', '../storage/logs/logmassages.txt', 'contact from META');
    $url = 'http://palkyinc.duckdns.org:10400/whatssAppWebHoo';
    $postfields = json_encode( $request->all());
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"object":"whatsapp_business_account","entry":[{"id":"102282732686707","changes":[{"value":{"messaging_product":"whatsapp","metadata":{"display_phone_number":"15550804237","phone_number_id":"101734582742368"},"statuses":[{"id":"wamid.HBgNNTQ5Mjk2NDUxNjQ2ORUCABEYEkU0RTNGNzZFNERFNzEyRTZFNgA=","status":"delivered","timestamp":"1677186731","recipient_id":"5492964516469","conversation":{"id":"9755435de94dfd9eefe283f9e0bb8cdd","origin":{"type":"user_initiated"}},"pricing":{"billable":true,"pricing_model":"CBP","category":"user_initiated"}}]},"field":"messages"}]}]}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: XSRF-TOKEN=eyJpdiI6IkdnQkJhMzVXbFNqQXpna3Z0bUtSTnc9PSIsInZhbHVlIjoia2UxU3pNRml4c0ErSXlBR1haaWRudk5LYys5RlZ1WmhmSURVWmlDdU5EbEd5NlZ5aHNSVWFkM2tCMVd6Y081QUcyK29rMlJrdzU0eDRiZ2JXMjhodmE3UnJSR1E4aUxaNmZFQS9zK2dxS2RyNGpXMktpUU1RSWp2bG02cWFqTkQiLCJtYWMiOiI5NTNhNjE3YTBiNTFjYzNiMWQ3OTBmODM2NTVhMTE1ZDc5NmY1MWU2NTMwZmRiMDhhMzA2OThmNGE4MzhhMWE3IiwidGFnIjoiIn0%3D; admin_whatsapp_session=eyJpdiI6IlFvbUVSa0dpZXpscVRpRG5IMU9kdWc9PSIsInZhbHVlIjoiVlk0WVB2eGZSQm4rRE9mTkdYcWhycmZBUkpqWUxLdDFVMVZCWTBROXoxQWQyWWNtTlhDblM1ZGw5Z1JEQ3VESFRVbHlLSWdJMU5xRWZjWTZTVDlINXc3RHNEd1V4bThVejZWbFpsMzZ1Z2FacndRam1jNy9sWDduT01lRDhoTUgiLCJtYWMiOiJjNzhiYWMzYjRmZGJjOThmZDM0Yjg0NTVjOTcwNWM1MTgyZTdkNmY4OWZlMDgyZDNkZmQ2NmNmZjU5YTM1YWI2IiwidGFnIjoiIn0%3D'
        ),
        ));

        $$json = curl_exec($curl);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($info != 200) {
            MyFunctions::loguear('a', '../storage/logs/logmassages.txt', 'error a casa: ' . json_decode($json));
            return response($json, $info);
        }
    return response($json, 200);
}); */

Route::get('/whatssAppWebHoo', function (Request $request) {
    return response('OK Test por GET', 200);
});
Route::post('/testPost', function (Request $request) {
    return response('OK Test por POST', 200);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
