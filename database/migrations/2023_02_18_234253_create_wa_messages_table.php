<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wa_messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('field', 20)->nullable();
            $table->string('messaging_product', 20)->nullable();
            $table->string('display_phone_number', 20)->nullable();
            $table->string('phone_number_id', 20)->nullable();
            $table->string('profile_name', 20)->nullable();
            //$table->string('wa_id', 20)->nullable();
            $table->string('messages_from', 20)->nullable();
            $table->string('messages_id', 150)->nullable();
            $table->timestamp('messages_timestamp')->nullable();
            $table->string('messages_type', 20)->nullable();
            $table->text('messages_text_body')->nullable();
            $table->text('send_text_body')->nullable();
            $table->string('object', 30)->nullable();
            $table->string('entry_id', 20)->nullable();
            $table->string('reaction_message_id', 150)->nullable();
            $table->string('reaction_emoji', 20)->nullable();
            $table->string('image_caption', 20)->nullable();
            $table->string('image_mime_type', 20)->nullable();
            $table->string('image_sha256', 64)->nullable();
            $table->string('image_id', 20)->nullable();
            $table->string('image_link', 150)->nullable();  // https://palkyinc.wiz.com.ar/yrAww9tqax3HVLb7zQ8TUwbD3YC86CNj/kichi.jpg
            //$table->string('sticker_mime_type', 20)->nullable();
            //$table->string('sticker_sha256', 64)->nullable();
            //$table->string('sticker_id', 20)->nullable();
            //$table->string('errors_code',20)->nullable();
            //$table->string('errors_details', 100)->nullable();
            //$table->string('errors_title', 100)->nullable();
            //$table->string('location_latitude', 20)->nullable();
            //$table->string('location_longitude', 20)->nullable();
            //$table->string('location_name', 20)->nullable();
            //$table->string('location_address', 50) ->nullable();
            //$table->string('contacts_addresses_city', 30)->nullable();
            //$table->string('contacts_addresses_country', 30)->nullable();
            //$table->string('contacts_addresses_country_code', 20)->nullable();
            //$table->string('contacts_addresses_state', 20)->nullable();
            //$table->string('contacts_addresses_street', 20)->nullable();
            //$table->string('contacts_addresses_type', 20)->nullable();
            //$table->string('contacts_addresses_zip', 20)->nullable();
            //$table->string('contacts_birthday', 20)->nullable();
            //$table->string('contacts_emails_email', 50)->nullable();
            //$table->string('contacts_emails_type', 20)->nullable();
            //$table->string('contacts_name_formatted_name', 30)->nullable();
            //$table->string('contacts_name_first_name', 20)->nullable();
            //$table->string('contacts_name_last_name', 20)->nullable();
            //$table->string('contacts_name_middle_name', 20)->nullable();
            //$table->string('contacts_name_suffix', 20)->nullable();
            //$table->string('contacts_name_prefix', 20)->nullable();
            //$table->string('contacts_org_company', 20)->nullable();
            //$table->string('contacts_org_department', 20)->nullable();
            //$table->string('contacts_org_title', 20)->nullable();
            //$table->string('contacts_phones_phone', 20)->nullable();
            //$table->string('contacts_phones_wa_id', 20)->nullable();
            $table->string('contacts_wa_id', 20)->nullable();
            //$table->string('contacts_phones_type', 20)->nullable();
            //$table->string('contacts_urls_url', 50)->nullable();
            //$table->string('contacts_urls_type', 20)->nullable();
            //$table->string('context_from', 20)->nullable();
            $table->string('context_id', 150)->nullable();
            //$table->string('button_text', 20)->nullable();
            //$table->string('button_payload', 20)->nullable();
            //$table->string('interactive_list_reply_id', 20)->nullable();
            //$table->string('interactive_list_reply_title', 20)->nullable();
            //$table->string('interactive_list_reply_description', 20)->nullable();
            //$table->string('interactive_type', 20)->nullable();
            //$table->string('interactive_button_reply_id', 20)->nullable();
            //$table->string('interactive_button_reply_title', 20)->nullable();
            //$table->string('referral_source_url', 50)->nullable();
            //$table->string('referral_source_id', 20)->nullable();
            //$table->string('referral_source_type', 20)->nullable();
            //$table->string('referral_headline', 20)->nullable();
            //$table->string('referral_body', 20)->nullable();
            //$table->string('referral_media_type', 20)->nullable();
            //$table->string('referral_image_url', 50)->nullable();
            //$table->string('referral_video_url', 50)->nullable();
            //$table->string('referral_thumbnail_url', 50)->nullable();
            //$table->string('context_referred_product_catalog_id', 20)->nullable();
            //$table->string('context_referred_product_product_retailer_id', 20)->nullable();
            //$table->string('order_catalog_id', 20)->nullable();
            //$table->string('order_product_items_product_retailer_id', 30)->nullable();
            //$table->string('order_product_items_quantity', 20)->nullable();
            //$table->string('order_product_items_item_price', 20)->nullable();
            //$table->string('order_product_items_currency', 20)->nullable();
            //$table->string('order_text', 50)->nullable();
            //$table->string('system_body', 50)->nullable();
            //$table->string('system_new_wa_id', 20)->nullable();
            //$table->string('system_type', 20)->nullable();
            $table->string('statuses_id', 150)->nullable(); // wamid.HBgNNTQ5Mjk2NDUxNjQ2ORUCABEYEjlBQ0QyRjU2NjExRUFGMUE3NgA=
            $table->string('statuses_recipient_id', 20)->nullable();
            $table->string('statuses_status', 20)->nullable();
            $table->timestamp('statuses_timestamp')->nullable();
            $table->string('conversation_id', 50)->nullable(); //2dd009ed21af8d3e20b16ec7673c3967
            $table->timestamp('conversation_expiration_timestamp')->nullable();
            $table->string('conversation_origin_type', 20)->nullable();
            $table->string('pricing_model', 20)->nullable();
            $table->string('pricing_billable', 20)->nullable();
            $table->string('pricing_category', 20)->nullable();
            //$table->string('statuses_errors_code', 20)->nullable();
            //$table->string('statuses_errors_title', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wa_messages');
    }
}
