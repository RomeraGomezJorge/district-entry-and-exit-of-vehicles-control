<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\SlugGenerator;
use Ausi\SlugGenerator\SlugGenerator as Slug;

final class AusiSlugGenerator implements SlugGenerator
{
    public function generate(string $string): string
    {
        $generator = new Slug();

        return $generator->generate($string);
    }
}
