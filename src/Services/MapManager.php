<?php

namespace App\Services;

use App\Repository\TileRepository;

class MapManager
{
  private $tileRepository;

  public function __construct(TileRepository $tileRepository)
  {
    $this->tileRepository = $tileRepository;
  }

  public function tileExists(int $x, int $y): bool
  {
    $tile = $this->tileRepository->findOneBy([
      'coordX' => $x,
      'coordY' => $y,
    ]);
    return $tile ? true : false;
  }
}
