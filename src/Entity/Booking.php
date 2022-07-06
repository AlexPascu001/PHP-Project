<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Car::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: true)]
    private $car;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private $station;

    #[ORM\Column(type: 'datetime')]
    private $charge_start;

    #[ORM\Column(type: 'datetime')]
    private $charge_end;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getChargeStart(): ?\DateTimeInterface
    {
        return $this->charge_start;
    }

    public function setChargeStart(\DateTimeInterface $charge_start): self
    {
        $this->charge_start = $charge_start;

        return $this;
    }

    public function getChargeEnd(): ?\DateTimeInterface
    {
        return $this->charge_end;
    }

    public function setChargeEnd(\DateTimeInterface $charge_end): self
    {
        $this->charge_end = $charge_end;

        return $this;
    }
}
