<?php

namespace SwitchFlit;

interface WithCustomQuery
{
    /**
     * @param \DataList $data The original DataList.
     * @return \DataList The DataList with custom filters applied.
     */
    public static function SwitchFlitQuery(\DataList $data);
}
