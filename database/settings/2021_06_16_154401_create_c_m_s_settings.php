<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateCMSSettings extends SettingsMigration
{
    public function up(): void
    {
      //  if(!$this->migrator->checkIfPropertyExists('cms.site_name')) {
        try{
            $this->migrator->add('cms.site_name', '');
        } catch (Exception $e) {
            // skip - exists
        }

        try{
            $this->migrator->add('cms.custom_head_tags', '');
        } catch (Exception $e) {
            // skip - exists
        }

        try{
            $this->migrator->add('cms.contact_from_name', 'Website Enquiries');
        } catch (Exception $e) {
            // skip - exists
        }

        try{
            $this->migrator->add('cms.contact_from_address', 'info@website.com');
        } catch (Exception $e) {
            // skip - exists
        }

        try{
            $this->migrator->add('cms.contact_to_addresses', '');
        } catch (Exception $e) {
            // skip - exists
        }

        try{
            $this->migrator->add('cms.contact_recaptcha_threshold', '0.7');
        } catch (Exception $e) {
            // skip - exists
        }
        
         
        

    }

    public function down() {


        try{
            $this->migrator->delete('cms.site_name');
            $this->migrator->delete('cms.custom_head_tags');


            $this->migrator->delete('cms.contact_from_name');
            $this->migrator->delete('cms.contact_from_address');
            $this->migrator->delete('cms.contact_to_addresses');
        } catch (Exception $e) {

        }



    }

}
