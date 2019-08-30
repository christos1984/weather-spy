<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190826131620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3370691A8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__weather_data AS SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM weather_data');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('CREATE TABLE weather_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, main_weather VARCHAR(255) NOT NULL COLLATE BINARY, weather_description VARCHAR(255) NOT NULL COLLATE BINARY, temperature DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, windspeed DOUBLE PRECISION NOT NULL, time_updated DATETIME NOT NULL, CONSTRAINT FK_3370691A8BAC62AF FOREIGN KEY (city_id) REFERENCES favourite_city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO weather_data (id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated) SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM __temp__weather_data');
        $this->addSql('DROP TABLE __temp__weather_data');
        $this->addSql('CREATE INDEX IDX_3370691A8BAC62AF ON weather_data (city_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__available_cities AS SELECT id, name, country_code FROM available_cities');
        $this->addSql('DROP TABLE available_cities');
        $this->addSql('CREATE TABLE available_cities (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, country VARCHAR(255) NOT NULL, coord VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO available_cities (id, name, country) SELECT id, name, country_code FROM __temp__available_cities');
        $this->addSql('DROP TABLE __temp__available_cities');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__available_cities AS SELECT id, name FROM available_cities');
        $this->addSql('DROP TABLE available_cities');
        $this->addSql('CREATE TABLE available_cities (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, owm_id INTEGER NOT NULL, country_code VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO available_cities (id, name) SELECT id, name FROM __temp__available_cities');
        $this->addSql('DROP TABLE __temp__available_cities');
        $this->addSql('DROP INDEX IDX_3370691A8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__weather_data AS SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM weather_data');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('CREATE TABLE weather_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, main_weather VARCHAR(255) NOT NULL, weather_description VARCHAR(255) NOT NULL, temperature DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, windspeed DOUBLE PRECISION NOT NULL, time_updated DATETIME NOT NULL)');
        $this->addSql('INSERT INTO weather_data (id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated) SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM __temp__weather_data');
        $this->addSql('DROP TABLE __temp__weather_data');
        $this->addSql('CREATE INDEX IDX_3370691A8BAC62AF ON weather_data (city_id)');
    }
}
