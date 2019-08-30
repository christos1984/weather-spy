<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190827083122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('DROP INDEX IDX_3370691A8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__weather_data AS SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM weather_data');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('CREATE TABLE weather_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, main_weather VARCHAR(255) NOT NULL COLLATE BINARY, weather_description VARCHAR(255) NOT NULL COLLATE BINARY, temperature DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, windspeed DOUBLE PRECISION NOT NULL, time_updated DATETIME NOT NULL, CONSTRAINT FK_3370691A8BAC62AF FOREIGN KEY (city_id) REFERENCES favourite_city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO weather_data (id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated) SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM __temp__weather_data');
        $this->addSql('DROP TABLE __temp__weather_data');
        $this->addSql('CREATE INDEX IDX_3370691A8BAC62AF ON weather_data (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_3370691A8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__weather_data AS SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM weather_data');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('CREATE TABLE weather_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, main_weather VARCHAR(255) NOT NULL, weather_description VARCHAR(255) NOT NULL, temperature DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, windspeed DOUBLE PRECISION NOT NULL, time_updated DATETIME NOT NULL)');
        $this->addSql('INSERT INTO weather_data (id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated) SELECT id, city_id, main_weather, weather_description, temperature, humidity, windspeed, time_updated FROM __temp__weather_data');
        $this->addSql('DROP TABLE __temp__weather_data');
        $this->addSql('CREATE INDEX IDX_3370691A8BAC62AF ON weather_data (city_id)');
    }
}
