<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateSocialMediaSettings extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('cms.social_accounts', []);
        } catch (Exception $e) {
            // skip - exists
        }

       

    }

    public function down() {


        try{
            $this->migrator->delete('cms.social_accounts');

        } catch (Exception $e) {

        }



    }

}
