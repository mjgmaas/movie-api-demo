<?php


namespace App\DTO;

/**
 * Class GenreOutputDTO
 * @package App\DTO
 */
final class GenreOutputDTO {

    /**
     * @var integer§
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * MovieOutputDTO constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

}