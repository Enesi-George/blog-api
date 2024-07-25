<?php
namespace App\Modules\Posts\Dtos;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

final class PostDTO extends DataTransferObject
{
    public ?string $blog_id;
    public ?string $title;
    public ?string $content;
    public ?string $image;
}