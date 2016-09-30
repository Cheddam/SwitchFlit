<?php

namespace SwitchFlit;

interface SwitchFlitable
{
    /**
     * @return string The title to use in SwitchFlit for this DataObject
     */
    public function SwitchFlitTitle();

    /**
     * @return string The link to use in SwitchFlit for this DataObject
     */
    public function SwitchFlitLink();
}
