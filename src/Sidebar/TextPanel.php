<?php

namespace AscentCreative\CMS\Sidebar;


class TextPanel extends AbstractPanel {

    public function isRenderable() {
        return true;
    }

    public function render() {
        // really, this is going to need to come from the DB...
        echo 'TEXT PANEL CONTENT HERE';

        

    }


}