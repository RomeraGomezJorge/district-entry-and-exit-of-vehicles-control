<?php

namespace App\Backoffice\District\Application\Find;

use App\Backoffice\District\Domain\District;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\District\Domain\Exception\DistrictNotExist;
use App\Shared\Domain\ValueObject\Uuid;

final class DistrictFinder
{
    private DistrictRepository $repository;

    public function __construct(DistrictRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $id): District
    {
        $id = new Uuid($id);

        $district = $this->repository->search($id);

        if (null === $district) {
            throw new DistrictNotExist($id);
        }

        return $district;
    }
}
