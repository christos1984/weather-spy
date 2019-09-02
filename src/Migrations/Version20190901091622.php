<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190901091622 extends AbstractMigration
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
        $this->addSql('CREATE TABLE weather_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, main_weather VARCHAR(255) NOT NULL, weather_description VARCHAR(255) NOT NULL, temperature DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, windspeed DOUBLE PRECISION NOT NULL, time_updated DATETIME NOT NULL, icon VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_3370691A8BAC62AF ON weather_data (city_id)');
        $this->addSql('CREATE TABLE available_cities (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, coord VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE favourite_city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country_code VARCHAR(10) NOT NULL, owm_id INTEGER NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('DROP TABLE available_cities');
        $this->addSql('DROP TABLE favourite_city');
    }
}
