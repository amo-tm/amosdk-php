<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class SubjectStatus extends AbstractModel
{
    protected string $title;
    protected string $colorHex;

    /**
     * @param string $title
     * @param string $colorHex
     * @return SubjectStatus
     */
    static public function status(string $title, string $colorHex): SubjectStatus {
        return new SubjectStatus([
            'title'=>$title,
            'color_hex'=>$colorHex,
        ]);
    }
}