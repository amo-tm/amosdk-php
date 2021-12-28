<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class SubjectStatus extends AbstractModel
{
    protected string $title;
    protected string $colorHex;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->colorHex;
    }

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