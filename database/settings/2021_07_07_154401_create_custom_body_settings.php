<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateCustomBodySettings extends SettingsMigration
{
    public function up(): void
    {
     

        try{
            $this->migrator->add('cms.custom_body_tags_start', '');
        } catch (Exception $e) {
            // skip - exists
        }

        try{
            $this->migrator->add('cms.custom_body_tags_end', '');
        } catch (Exception $e) {
            // skip - exists
        }


    }

    public function down() {


        try{
            $this->migrator->delete('cms.custom_body_tags_start');
            $this->migrator->delete('cms.custom_body_tags_end');

        } catch (Exception $e) {

        }



    }

}
