<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateHomepageSetting extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('cms.homepage_id', null);
        } catch (Exception $e) {
            // skip - exists
        }

       

    }

    public function down() {


        try{
            $this->migrator->delete('cms.homepage_id');

        } catch (Exception $e) {

        }



    }

}
