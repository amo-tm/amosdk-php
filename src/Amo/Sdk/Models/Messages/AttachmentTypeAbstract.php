<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\File;

class AttachmentTypeAbstract extends AbstractModel
{
    protected File $file;
    protected string $link;

    protected array $cast = [
        'file' => File::class
    ];

    public static function create(string $link): self {
        return new static([
            'link' => $link
        ]);
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}
