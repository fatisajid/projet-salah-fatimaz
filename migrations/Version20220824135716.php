<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824135716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD vehicule_id INT NOT NULL, ADD date_heure_depart DATETIME NOT NULL, ADD date_heure_fin DATETIME NOT NULL, ADD prix_total INT NOT NULL, ADD date_enregistrement DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4A4A3511');
        $this->addSql('DROP INDEX IDX_6EEAA67D4A4A3511 ON commande');
        $this->addSql('ALTER TABLE commande DROP vehicule_id, DROP date_heure_depart, DROP date_heure_fin, DROP prix_total, DROP date_enregistrement');
    }
}
