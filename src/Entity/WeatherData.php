<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherDataRepository")
 */
class WeatherData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FavouriteCity", inversedBy="weatherData")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mainWeather;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $weather_description;

    /**
     * @ORM\Column(type="float")
     */
    private $temperature;

    /**
     * @ORM\Column(type="float")
     */
    private $humidity;

    /**
     * @ORM\Column(type="float")
     */
    private $windspeed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timeUpdated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?FavouriteCity
    {
        return $this->city;
    }

    public function setCity(?FavouriteCity $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getMainWeather(): ?string
    {
        return $this->mainWeather;
    }

    public function setMainWeather(string $mainWeather): self
    {
        $this->mainWeather = $mainWeather;

        return $this;
    }

    public function getWeatherDescription(): ?string
    {
        return $this->weather_description;
    }

    public function setWeatherDescription(string $weather_description): self
    {
        $this->weather_description = $weather_description;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getWindspeed(): ?float
    {
        return $this->windspeed;
    }

    public function setWindspeed(float $windspeed): self
    {
        $this->windspeed = $windspeed;

        return $this;
    }

    public function getTimeUpdated(): ?\DateTimeInterface
    {
        return $this->timeUpdated;
    }

    public function setTimeUpdated(\DateTimeInterface $timeUpdated): self
    {
        $this->timeUpdated = $timeUpdated;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
