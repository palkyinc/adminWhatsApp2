<?php

namespace App\Http\Controllers;

use App\Models\WaMessage;
use Illuminate\Http\Request;
use DateTime;
use App\Custom\MyFunctions;

class WaMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = WaMessage::where('messages_from', '!=', 'local')
                                    ->where('messages_from', '!=', null)
                                    ->get();
            foreach ($messages as $message) {
                if (!isset($phone_clients) || !in_array($message->messages_from, $phone_clients)) {
                    $phone_clients[] = $message->messages_from;
                }
            }
        if (!empty($request->all())) {
            $conversation = WaMessage::orWhere('messages_from', $request->phone_number)
                                        ->orWhere('contacts_wa_id', $request->phone_number)
                                        ->orWhere('statuses_recipient_id', $request->phone_number)
                                        ->get();
            $phone_number = $request->phone_number;
            //dd($conversation);
        } else {
            $conversation = [];
            $phone_number = "";
        }
        
        //dd($phone_clients);
        return view('developMensapi', ["phone_clients" => $phone_clients,
                                        "conversation" => $conversation,
                                        "phone_number" => $phone_number]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ///
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WaMessage  $waMessage
     * @return \Illuminate\Http\Response
     */
    public function show(WaMessage $waMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WaMessage  $waMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(WaMessage $waMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WaMessage  $waMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WaMessage $waMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WaMessage  $waMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaMessage $waMessage)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_message = new WaMessage;
        $new_message->object = $request['object'] ?? null;
        $new_message->entry_id = $request['entry'][0]['id'] ?? null;
        $new_message->field = $request['entry'][0]['changes'][0]['field'] ?? null;
        
        $value = $request['entry'][0]['changes'][0]['value'] ?? null;
        $new_message->messaging_product = $value['messaging_product'] ?? null;
        
        $metadata = $value['metadata'] ?? null;
        $new_message->display_phone_number = $metadata['display_phone_number'] ?? null;
        $new_message->phone_number_id = $metadata['phone_number_id'] ?? null;
        
        $statuses = $value['statuses'][0] ?? null;
        $new_message->statuses_id = $statuses['id'] ?? null;
        $new_message->statuses_status = $statuses['status'] ?? null;
        $new_message->statuses_timestamp = isset($statuses['timestamp']) ? date("Y-m-d H:i:s",$statuses['timestamp']) : null;
        $new_message->statuses_recipient_id = $statuses['recipient_id'] ?? null;
        
        $conversation = $statuses['conversation'] ?? null;
        $new_message->conversation_id = $conversation['id'] ?? null;
        $new_message->conversation_expiration_timestamp = isset($conversation['expiration_timestamp']) ? date("Y-m-d H:i:s",$conversation['expiration_timestamp']) : null;
        $new_message->conversation_origin_type = $conversation['origin']['type'] ?? null;
        
        $pricing = $statuses['pricing'] ?? null;
        $new_message->pricing_billable = $pricing['billable'] ?? null;
        $new_message->pricing_model = $pricing['pricing_model'] ?? null;
        $new_message->pricing_category = $pricing['category'] ?? null;
        
        $contacts = $request['entry'][0]['changes'][0]['value']['contacts'][0] ?? null;
        $new_message->contacts_wa_id = $contacts['wa_id'] ?? null;
        
        $profile = $request['entry'][0]['changes'][0]['value']['contacts'][0]['profile'] ?? null;
        $new_message->profile_name = $profile['name'] ?? null;
        
        $messages = $request['entry'][0]['changes'][0]['value']['messages'][0] ?? null;
        $new_message->messages_from = $messages['from'] ?? null;
        $new_message->messages_id = $messages['id'] ?? null;
        $new_message->messages_timestamp = isset($messages['timestamp']) ? date("Y-m-d H:i:s", $messages['timestamp']) : null;
        $new_message->messages_type = $messages['type'] ?? null;
        $new_message->messages_text_body = $messages['text']['body'] ?? null;

        $reaction = $messages['reaction'] ?? null;
        $new_message->reaction_message_id = $reaction['message_id'] ?? null;
        $new_message->reaction_emoji = $reaction['emoji'] ?? null;
        
        $image = $request['entry'][0]['changes'][0]['value']['messages'][0]['image'] ?? null;
        $new_message->image_caption = $image['caption'] ?? null;
        $new_message->image_mime_type = $image['mime_type'] ?? null;
        $new_message->image_sha256 = $image['sha256'] ?? null;
        $new_message->image_id = $image['id'] ?? null;
        
        $new_message->save();
        
        if (isset($new_message->statuses_id)) {
            $main_message = WaMessage::where('messages_id', $new_message->statuses_id)->first();
            $main_message->statuses_status = $new_message->statuses_status;
            $main_message->save();
        }
        if (isset($new_message->reaction_message_id)) {
            $main_message = WaMessage::where('messages_id', $new_message->reaction_message_id)->first();
            $main_message->reaction_emoji = $new_message->reaction_emoji;
            $main_message->save();
        }
        return response('', 200);
    }

    public function markMenssageAsRead (Request $request) 
    {
        $message = WaMessage::find($request->wa_messages_id);
        if ($message) {
            $rta = $message->markAsRead();
        } else {
            $rta = json_encode(array("error" => "Could not find wa_messages_id in the database."));
        }
        return response($rta, 200);
    }
    public function sendTextMessage(Request $request) {
        $message = new WaMessage;
        $message->send_text_body = $request->body;
        $message->contacts_wa_id = $request->to;
        $message->messages_type = "text";
        $message->messages_from = "local";
        $message->phone_number_id = env('META_PHONE_NUMBER_ID');
        $message->save();
        $rta = $message->sendText();
        if (isset($request->develop_view)) {
            return redirect()->action([WaMessageController::class, 'index'], ["phone_number" => $request->to]);
        } else {
            return response($rta, 200);
        }
    }
    public function sendReplayToTextMessage(Request $request) {
        $message = new WaMessage;
        $message->send_text_body = $request->body;
        $message->contacts_wa_id = $request->to;
        $message->messages_from = "local";
        $message->context_id = $request->prev_messages_id;
        $message->phone_number_id = env('META_PHONE_NUMBER_ID');
        $message->save();
        $rta = $message->sendReplayToText();
        return response($rta, 200);
    }
    public function sendReplayWithReactionMessage(Request $request) {
        $message = new WaMessage;
        $message->send_text_body = $request->body;
        $message->contacts_wa_id = $request->to;
        $message->messages_from = "local";
        $message->reaction_message_id = $request->prev_messages_id;
        $message->reaction_emoji = $request->emoji;
        $message->phone_number_id = env('META_PHONE_NUMBER_ID');
        $message->save();
        $rta = $message->sendReplayWithReaction();
        return response($rta, 200);
    }
    public function sendImageMessage(Request $request) {
        $message = new WaMessage;
        $message->send_text_body = $request->body ?? null;
        $message->contacts_wa_id = $request->to;
        $message->image_id = $request->image_id ?? null;
        $message->image_link = $request->image_link ?? null;
        $message->messages_from = "local";
        $message->phone_number_id = env('META_PHONE_NUMBER_ID');
        $message->save();
        $rta = $message->SendImage();
        return response($rta, 200);
    }
    public function downloadMedia(Request $request) {
        $message = WaMessage::Find($request->wa_message_table_id);
        $urlRetrieved = $message->retrieveMediaUrl();
        return ($urlRetrieved->url);
        if (!isset($urlRetrieved->error)) {

            $extension = explode('/', $urlRetrieved->mime_type)[1];
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }
            $nameF = new DateTime('now');
            $fileName = env('MEDIA_FOLDER') . ($nameF->format('YmdHis')) . '.' . $extension;
            $rta = MyFunctions::curlGetFile($urlRetrieved->url, $fileName);
            return($rta);
            $new_message = new WaMessage;
            if ($message->image_id) {
                $new_message = $message->image_id;
            }
            $new_message->image_mime_type = $urlRetrieved->mime_type;
            $new_message->image_sha256 = $urlRetrieved->sha256;
            $new_message->messaging_product = $urlRetrieved->messaging_product;
            $new_message->save();
        }
        else {
            return json_encode($urlRetrieved);
        }

    }

}
