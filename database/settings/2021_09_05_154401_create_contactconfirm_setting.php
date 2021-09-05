<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateContactConfirmSetting extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('cms.contact_confirm_page_id', null);
        } catch (Exception $e) {
            // skip - exists
        }

       

    }

    public function down() {


        try{
            $this->migrator->delete('cms.contact_confirm_page_id');

        } catch (Exception $e) {

        }



    }

}
