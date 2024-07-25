<?php
namespace App\Modules\Blogs\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

final class BlogDTO extends DataTransferObject
{
    public int $user_id;
    public string $title;
    public string $description;
}