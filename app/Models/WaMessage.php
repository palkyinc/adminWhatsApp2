<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Custom\MyFunctions;

class WaMessage extends Model
{
    use HasFactory;

    public function markAsRead () {
        //dd("esta mal");
        $mensaje = array('messaging_product'=>'whatsapp',
                         'status'=>'read',
                         'message_id'=>$this->messages_id);
        $json = $this->sendToMeta($mensaje);
        $rta = json_decode($json);
        if (isset($rta->success) && $rta->success === true) {
            $this->statuses_status = "read";
            $this->save();
        }
        return $json;
    }
    public function sendText () {
        if ($this->contacts_wa_id[0] == 5 && $this->contacts_wa_id[1] == 4 && $this->contacts_wa_id[2] == 9) {
            $phone_number = $this->contacts_wa_id[0] . 
                            $this->contacts_wa_id[1] . 
                            $this->contacts_wa_id[3] . 
                            $this->contacts_wa_id[4] . 
                            $this->contacts_wa_id[5] . 
                            $this->contacts_wa_id[6] . 
                            $this->contacts_wa_id[7] . 
                            $this->contacts_wa_id[8] . 
                            $this->contacts_wa_id[9] . 
                            $this->contacts_wa_id[10] . 
                            $this->contacts_wa_id[11] . 
                            $this->contacts_wa_id[12];
        } else {
            $phone_number = $this->contacts_wa_id;
        }
        $mensaje = array(
            'messaging_product'=>'whatsapp',
            "preview_url"=> false,
            "recipient_type"=> "individual",
            "to" => $phone_number,
            "type"=> "text",
            "text"=> array("body"=> $this->send_text_body)
        );
        $json = $this->sendToMeta($mensaje);
        $this->saveMessageId($json);
        return $json;
    }
    public function sendReplayToText () {
        $mensaje = array(
            'messaging_product' => 'whatsapp',
            "recipient_type" => "individual",
            "to" => $this->contacts_wa_id,
            "context" => array("message_id" => $this->context_id),
            "type" => "text",
            "text" => array("preview_url" => false, "body" => $this->send_text_body)
        );
        $json = $this->sendToMeta($mensaje);
        $this->saveMessageId($json);
        return $json;
    }
    public function sendReplayWithReaction () {
        $mensaje = array(
            'messaging_product' => 'whatsapp',
            "recipient_type" => "individual",
            "to" => $this->contacts_wa_id,
            "type" => "reaction",
            "reaction" => array("message_id" => $this->reaction_message_id, "emoji" => $this->reaction_emoji)
        );
        $json = $this->sendToMeta($mensaje);
        $this->saveMessageId($json);
        return $json;
    }
    public function SendImage () {
        if (!$this->image_id) {
            /* $imageFileType = strtolower(pathinfo($this->image_link,PATHINFO_EXTENSION));
            $mje = array('messaging_product' => 'whatsapp','file'=> $this->image_link . ';type=image/jpeg');
            dd($this->sendToMeta ($mje, "application/json", "media")); */
        }
        $mensaje = array(
            'messaging_product' => 'whatsapp',
            "recipient_type" => "individual",
            "to" => $this->contacts_wa_id,
            "type" => "image",
            "image" => array("link" => $this->image_link)
        );
        $json = $this->sendToMeta($mensaje);
        $this->saveMessageId($json);
        return $json;
    }
    public function retrieveMediaUrl() {
        if ($this->image_id) {
            $media_id = $this->image_id;
        }
        $url = 'https://graph.facebook.com/' . env('META_VERSION') . '/' . $media_id . '?phone_number_id=' . $this->phone_number_id;
        return json_decode(MyFunctions::curlGet($url));
    }
    private function saveMessageId ($json) {
        $rta = json_decode($json, true);
        //dd($json);
        if (isset($rta['messages'][0]['id'])) {
            $this->messages_id = $rta['messages'][0]['id'];
            $this->save();
        }
    }
    private function sendToMeta ($mensaje, $content_type = 'application/json', $destination = "messages") {
        $url = 'https://graph.facebook.com/' . env('META_VERSION') . '/' . $this->phone_number_id . '/' . $destination;
        $postfields = json_encode($mensaje);
        return MyFunctions::curlPost($url, $postfields, $content_type);
    }
}
