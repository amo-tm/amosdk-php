<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\File;

class Attachment extends AbstractModel
{
    protected string $type;
    protected ?AttachmentTypeDocument $document = null;
    protected ?AttachmentTypePhoto $photo = null;
    protected ?AttachmentTypeVoice $voice = null;
    protected ?AttachmentTypeVideo $video = null;

    protected array $cast = [
        'document' => AttachmentTypeDocument::class,
        'photo' => AttachmentTypePhoto::class,
        'voice' => AttachmentTypeVoice::class,
        'video' => AttachmentTypeVideo::class,
    ];

    public static function document(AttachmentTypeDocument $document): self {
        return new Attachment([
           'type' => 'document',
           'document' => $document
        ]);
    }

    public static function photo(AttachmentTypePhoto $photo): self {
        return new Attachment([
            'type' => 'photo',
            'photo' => $photo
        ]);
    }

    public static function voice(AttachmentTypeVoice $voice): self {
        return new Attachment([
            'type' => 'voice',
            'voice' => $voice
        ]);
    }

    public static function video(AttachmentTypeVideo $video): self {
        return new Attachment([
            'type' => 'video',
            'video' => $video
        ]);
    }

    public function getFile(): ?File {
        return match (true) {
            $this->photo != null => $this->photo->getFile(),
            $this->document != null => $this->document->getFile(),
            $this->video != null => $this->video->getFile(),
            $this->voice != null => $this->voice->getFile(),
            default => null,
        };
    }
}
