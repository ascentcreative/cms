<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateFaviconSetting extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('cms.favicon', '');
        } catch (Exception $e) {
            // skip - exists
        }

       

    }

    public function down() {


        try{
            $this->migrator->delete('cms.favicon');

        } catch (Exception $e) {

        }



    }

}
