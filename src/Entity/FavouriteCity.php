<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavouriteCityRepository")
 */
class FavouriteCity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $owmId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WeatherData", mappedBy="city")
     */
    private $weatherData;

    public function __construct()
    {
        $this->weatherData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getOwmId(): ?int
    {
        return $this->owmId;
    }

    public function setOwmId(int $owmId): self
    {
        $this->owmId = $owmId;

        return $this;
    }

    /**
     * @return Collection|WeatherData[]
     */
    public function getWeatherData(): Collection
    {
        return $this->weatherData;
    }

    public function addWeatherData(WeatherData $weatherData): self
    {
        if (!$this->weatherData->contains($weatherData)) {
            $this->weatherData[] = $weatherData;
            $weatherData->setCity($this);
        }

        return $this;
    }

    public function removeWeatherData(WeatherData $weatherData): self
    {
        if ($this->weatherData->contains($weatherData)) {
            $this->weatherData->removeElement($weatherData);
            // set the owning side to null (unless already changed)
            if ($weatherData->getCity() === $this) {
                $weatherData->setCity(null);
            }
        }

        return $this;
    }
}
