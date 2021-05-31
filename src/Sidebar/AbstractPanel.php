<?php

namespace AscentCreative\CMS\Sidebar;


abstract class AbstractPanel {


    public abstract function isRenderable();

    public abstract function render();


}