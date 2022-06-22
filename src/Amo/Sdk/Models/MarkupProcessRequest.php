<?php

namespace Amo\Sdk\Models;

class MarkupProcessRequest extends AbstractModel
{
    protected string $markup;

    public static function markup(string $markup): MarkupProcessRequest {
        return new self([
            'markup' => $markup
        ]);
    }

    /**
     * @return string
     */
    public function getMarkup(): string
    {
        return $this->markup;
    }
}
