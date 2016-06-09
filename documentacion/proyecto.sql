CREATE DATABASE proyecto;


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "cliente"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `cliente` (
    `codCli` VARCHAR(8) NOT NULL,
    `nomempCli` VARCHAR(40) NOT NULL,
    `tlfCli` NUMERIC(9) NOT NULL,
    `emailCli` VARCHAR(40) NOT NULL,
    `nomconCli` VARCHAR(40) NOT NULL,
    CONSTRAINT `PK_cliente` PRIMARY KEY (`codCli`)
);

# ---------------------------------------------------------------------- #
# Add table "proyecto"                                                   #
# ---------------------------------------------------------------------- #

CREATE TABLE `proyecto` (
    `codPro` VARCHAR(9) NOT NULL,
    `nomPro` VARCHAR(40) NOT NULL,
    `fechiniPro` DATE NOT NULL,
    `fechfinPro` DATE,
    `horasPro` INTEGER,
    `fasePro` VARCHAR(40),
    `codcli` VARCHAR(8) NOT NULL,
    CONSTRAINT `PK_proyecto` PRIMARY KEY (`codPro`)
);

# ---------------------------------------------------------------------- #
# Add table "requisito"                                                  #
# ---------------------------------------------------------------------- #

CREATE TABLE `requisito` (
    `codReq` VARCHAR(9) NOT NULL,
    `nomReq` VARCHAR(40) NOT NULL,
    `desReq` VARCHAR(70) NOT NULL,
    `horaPreReq` INTEGER NOT NULL,
    `horaReq` INTEGER,
    `estadoReq` VARCHAR(40) NOT NULL,
    `faseReq` VARCHAR(40) NOT NULL,
    `codPro` VARCHAR(9),
    `codEqu` VARCHAR(40),
    CONSTRAINT `PK_requisito` PRIMARY KEY (`codReq`)
);

# ---------------------------------------------------------------------- #
# Add table "usuario"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `usuario` (
    `codUsu` VARCHAR(9) NOT NULL,
    `nomUsu` VARCHAR(40) NOT NULL,
    `emailUsu` VARCHAR(40) NOT NULL,
    `catUsu` VARCHAR(40) NOT NULL,
    `loginUsu` VARCHAR(40) NOT NULL,
    `passUsu` VARCHAR(40) NOT NULL,
    `permisoUsu` VARCHAR(40) NOT NULL,
    CONSTRAINT `PK_usuario` PRIMARY KEY (`codUsu`)
);

# ---------------------------------------------------------------------- #
# Add table "equipo"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `equipo` (
    `codEqu` VARCHAR(40) NOT NULL,
    `codUsuScrMaster` VARCHAR(9),
    CONSTRAINT `PK_equipo` PRIMARY KEY (`codEqu`)
);

# ---------------------------------------------------------------------- #
# Add table "equipo_programador"                                         #
# ---------------------------------------------------------------------- #

CREATE TABLE `equipo_programador` (
    `codEqu` VARCHAR(40) NOT NULL,
    `codUsu` VARCHAR(9) NOT NULL,
    CONSTRAINT `PK_equipo_programador` PRIMARY KEY (`codEqu`, `codUsu`)
);

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `proyecto` ADD CONSTRAINT `cliente_proyecto` 
    FOREIGN KEY (`codcli`) REFERENCES `cliente` (`codCli`);

ALTER TABLE `requisito` ADD CONSTRAINT `proyecto_requisito` 
    FOREIGN KEY (`codPro`) REFERENCES `proyecto` (`codPro`);

ALTER TABLE `requisito` ADD CONSTRAINT `equipo_requisito` 
    FOREIGN KEY (`codEqu`) REFERENCES `equipo` (`codEqu`);

ALTER TABLE `equipo` ADD CONSTRAINT `usuario_equipo` 
    FOREIGN KEY (`codUsuScrMaster`) REFERENCES `usuario` (`codUsu`);

ALTER TABLE `equipo_programador` ADD CONSTRAINT `equipo_equipo_programador` 
    FOREIGN KEY (`codEqu`) REFERENCES `equipo` (`codEqu`);

ALTER TABLE `equipo_programador` ADD CONSTRAINT `usuario_equipo_programador` 
    FOREIGN KEY (`codUsu`) REFERENCES `usuario` (`codUsu`);
