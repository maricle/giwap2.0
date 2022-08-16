<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200904214452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tipo_documento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipodepago (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items (id INT AUTO_INCREMENT NOT NULL, alicuota_id INT DEFAULT NULL, orden_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, comprobante_id INT DEFAULT NULL, descripcion VARCHAR(100) DEFAULT NULL, precio NUMERIC(15, 4) DEFAULT \'0.0000\' NOT NULL, cantidad NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, INDEX fk_items_producto1_idx (producto_id), INDEX fk_items_orden1_idx (orden_id), INDEX fk_items_comprobante1_idx (comprobante_id), INDEX fk_items_alicuota1_idx (alicuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, alicuota_id INT DEFAULT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(200) DEFAULT NULL, precio NUMERIC(15, 4) DEFAULT \'0.0000\' NOT NULL, costo NUMERIC(15, 4) DEFAULT NULL, controlstock TINYINT(1) NOT NULL, stockinicial INT NOT NULL, listadeprecio VARCHAR(255) DEFAULT NULL, INDEX fk_producto_alicuota1_idx (alicuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pago (id INT AUTO_INCREMENT NOT NULL, comprobante_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, tipodepago_id INT DEFAULT NULL, orden_id INT DEFAULT NULL, fecha DATE NOT NULL, descripcion VARCHAR(45) DEFAULT NULL, referencia VARCHAR(45) DEFAULT NULL, valor NUMERIC(15, 4) NOT NULL, INDEX IDX_F4DF5F3E9750851F (orden_id), INDEX fk_pago_persona1_idx (persona_id), INDEX fk_pago_tipodepago1_idx (tipodepago_id), INDEX fk_pago_comprobante1_idx (comprobante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, condicion_iva_id INT DEFAULT NULL, tipo_documento_id INT DEFAULT NULL, apellido VARCHAR(50) NOT NULL, nombre VARCHAR(50) NOT NULL, email VARCHAR(45) DEFAULT NULL, direccion VARCHAR(150) DEFAULT NULL, telefono VARCHAR(45) DEFAULT NULL, documento VARCHAR(45) NOT NULL, habilitado TINYINT(1) DEFAULT \'1\' NOT NULL, gremio TINYINT(1) NOT NULL, proveedor TINYINT(1) NOT NULL, INDEX fk_Persona_condicion_iva_idx (condicion_iva_id), INDEX fk_Persona_tipo_documento1_idx (tipo_documento_id), UNIQUE INDEX UNIQ_51E5B69BB6B12EC7 (documento), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comprobante (id INT AUTO_INCREMENT NOT NULL, persona_id INT DEFAULT NULL, tipocomprobante_id INT DEFAULT NULL, puntodeventa VARCHAR(45) DEFAULT NULL, numero INT NOT NULL, fecha DATE NOT NULL, fecha_vencimiento DATE DEFAULT NULL, documento VARCHAR(11) DEFAULT NULL, codigo VARCHAR(100) DEFAULT NULL, cae VARCHAR(45) DEFAULT NULL, tipo INT DEFAULT NULL, total NUMERIC(15, 4) DEFAULT \'0.0000\' NOT NULL, saldo NUMERIC(15, 4) DEFAULT \'0.0000\', enviado TINYINT(1) DEFAULT NULL, afip TINYINT(1) DEFAULT NULL, estadopago INT DEFAULT NULL, compra TINYINT(1) NOT NULL, INDEX fk_comprobante_tipocomprobante1_idx (tipocomprobante_id), INDEX fk_comprobante_persona1_idx (persona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listadeprecio (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE linea_orden (id INT AUTO_INCREMENT NOT NULL, orden_id INT NOT NULL, producto_id INT NOT NULL, cantidad INT NOT NULL, precio NUMERIC(15, 4) NOT NULL, INDEX IDX_E702ABF99750851F (orden_id), INDEX IDX_E702ABF97645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipodetrabajo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alicuota (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, valor NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristicas (id INT AUTO_INCREMENT NOT NULL, tipodetrabajo_id INT DEFAULT NULL, ordenes_id INT DEFAULT NULL, nombre VARCHAR(45) NOT NULL, costro VARCHAR(45) DEFAULT NULL, valor VARCHAR(45) DEFAULT NULL, tipocalculo VARCHAR(45) DEFAULT NULL, INDEX IDX_1497AB9113BA949C (ordenes_id), INDEX fk_caracteristicas_tipodetrabajo1_idx (tipodetrabajo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condicion_iva (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) DEFAULT NULL, descripcion VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cofiguracion (nombre VARCHAR(20) NOT NULL, valor VARCHAR(45) NOT NULL, PRIMARY KEY(nombre)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipocomprobante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(100) DEFAULT NULL, codigo VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orden (id INT AUTO_INCREMENT NOT NULL, estadotrabajo_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, puntodeventa_id INT NOT NULL, tipodetrabajo_id INT NOT NULL, fecha DATE  NOT NULL, prioridad INT DEFAULT 1 NOT NULL, nombre VARCHAR(100) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, cantidad DOUBLE PRECISION NOT NULL, medida_trabajo VARCHAR(50) NOT NULL, papel VARCHAR(100) DEFAULT NULL, color VARCHAR(100) DEFAULT NULL, precio DOUBLE PRECISION DEFAULT NULL, copias INT DEFAULT NULL, baja TINYINT(1) NOT NULL, numeracion VARCHAR(200) DEFAULT NULL, entrega DOUBLE PRECISION NOT NULL, original DATETIME DEFAULT NULL, impresion DATETIME DEFAULT NULL, terminado DATETIME DEFAULT NULL, entregado DATETIME DEFAULT NULL, sucursal VARCHAR(10) DEFAULT NULL, saldo NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_E128CFD7F649352D (puntodeventa_id), INDEX IDX_E128CFD7D16B4C58 (tipodetrabajo_id), INDEX fk_orden_persona1_idx (persona_id), INDEX fk_orden_estadotrabajo1_idx (estadotrabajo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE puntodeventa (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) DEFAULT NULL, numero INT NOT NULL, direccion VARCHAR(200) DEFAULT NULL, cuit VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estadotrabajo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(45) NOT NULL, color VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DCE980405 FOREIGN KEY (alicuota_id) REFERENCES alicuota (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D9750851F FOREIGN KEY (orden_id) REFERENCES orden (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D25662B3A FOREIGN KEY (comprobante_id) REFERENCES comprobante (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615CE980405 FOREIGN KEY (alicuota_id) REFERENCES alicuota (id)');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E25662B3A FOREIGN KEY (comprobante_id) REFERENCES comprobante (id)');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3EF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E791F298E FOREIGN KEY (tipodepago_id) REFERENCES tipodepago (id)');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3E9750851F FOREIGN KEY (orden_id) REFERENCES orden (id)');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69BE262B53E FOREIGN KEY (condicion_iva_id) REFERENCES condicion_iva (id)');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69BF6939175 FOREIGN KEY (tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE comprobante ADD CONSTRAINT FK_55DEEE82F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE comprobante ADD CONSTRAINT FK_55DEEE828A85384A FOREIGN KEY (tipocomprobante_id) REFERENCES tipocomprobante (id)');
        $this->addSql('ALTER TABLE linea_orden ADD CONSTRAINT FK_E702ABF99750851F FOREIGN KEY (orden_id) REFERENCES orden (id)');
        $this->addSql('ALTER TABLE linea_orden ADD CONSTRAINT FK_E702ABF97645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE caracteristicas ADD CONSTRAINT FK_1497AB91D16B4C58 FOREIGN KEY (tipodetrabajo_id) REFERENCES tipodetrabajo (id)');
        $this->addSql('ALTER TABLE caracteristicas ADD CONSTRAINT FK_1497AB9113BA949C FOREIGN KEY (ordenes_id) REFERENCES orden (id)');
        $this->addSql('ALTER TABLE orden ADD CONSTRAINT FK_E128CFD7BBACDA21 FOREIGN KEY (estadotrabajo_id) REFERENCES estadotrabajo (id)');
        $this->addSql('ALTER TABLE orden ADD CONSTRAINT FK_E128CFD7F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE orden ADD CONSTRAINT FK_E128CFD7F649352D FOREIGN KEY (puntodeventa_id) REFERENCES puntodeventa (id)');
        $this->addSql('ALTER TABLE orden ADD CONSTRAINT FK_E128CFD7D16B4C58 FOREIGN KEY (tipodetrabajo_id) REFERENCES tipodetrabajo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69BF6939175');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E791F298E');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D7645698E');
        $this->addSql('ALTER TABLE linea_orden DROP FOREIGN KEY FK_E702ABF97645698E');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3EF5F88DB9');
        $this->addSql('ALTER TABLE comprobante DROP FOREIGN KEY FK_55DEEE82F5F88DB9');
        $this->addSql('ALTER TABLE orden DROP FOREIGN KEY FK_E128CFD7F5F88DB9');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D25662B3A');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E25662B3A');
        $this->addSql('ALTER TABLE caracteristicas DROP FOREIGN KEY FK_1497AB91D16B4C58');
        $this->addSql('ALTER TABLE orden DROP FOREIGN KEY FK_E128CFD7D16B4C58');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DCE980405');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615CE980405');
        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69BE262B53E');
        $this->addSql('ALTER TABLE comprobante DROP FOREIGN KEY FK_55DEEE828A85384A');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D9750851F');
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3E9750851F');
        $this->addSql('ALTER TABLE linea_orden DROP FOREIGN KEY FK_E702ABF99750851F');
        $this->addSql('ALTER TABLE caracteristicas DROP FOREIGN KEY FK_1497AB9113BA949C');
        $this->addSql('ALTER TABLE orden DROP FOREIGN KEY FK_E128CFD7F649352D');
        $this->addSql('ALTER TABLE orden DROP FOREIGN KEY FK_E128CFD7BBACDA21');
        $this->addSql('DROP TABLE tipo_documento');
        $this->addSql('DROP TABLE tipodepago');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE pago');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE comprobante');
        $this->addSql('DROP TABLE listadeprecio');
        $this->addSql('DROP TABLE linea_orden');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE tipodetrabajo');
        $this->addSql('DROP TABLE alicuota');
        $this->addSql('DROP TABLE caracteristicas');
        $this->addSql('DROP TABLE condicion_iva');
        $this->addSql('DROP TABLE cofiguracion');
        $this->addSql('DROP TABLE tipocomprobante');
        $this->addSql('DROP TABLE orden');
        $this->addSql('DROP TABLE puntodeventa');
        $this->addSql('DROP TABLE estadotrabajo');
    }
}
