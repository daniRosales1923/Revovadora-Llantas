CREATE TABLE Datosllantas (
  IDllanta              SERIAL NOT NULL, 
  FolioEntrada          int4 NOT NULL, 
  Descripcion           varchar(255), 
  IDMarca               int4 NOT NULL, 
  IDModelo              int4 NOT NULL, 
  IDCliente             int4 NOT NULL, 
  IDTrabajo             int4 NOT NULL, 
  Status                varchar(2) NOT NULL, 
  TrabajoIDTrabajo      int4, 
  TrabajoIDModelo       int4, 
  ModeloIDModelo        int4, 
  TrabajoModeloIDModelo int4, 
  ModeloIDMarca         int4, 
  PRIMARY KEY (IDllanta));
CREATE TABLE Entrada (
  FolioEntrada SERIAL NOT NULL, 
  IDUsuario    int4 NOT NULL, 
  Comentario   varchar(255), 
  Fecha        time(7) NOT NULL, 
  Status       varchar(2) NOT NULL, 
  IDCliente    int4 NOT NULL, 
  "Column"     int4, 
  PRIMARY KEY (FolioEntrada));
CREATE TABLE Usuario (
  IDUsuario       SERIAL NOT NULL, 
  Nombre          varchar(50) NOT NULL, 
  ApellidoPaterno varchar(50) NOT NULL, 
  ApellidoMaterno varchar(50) NOT NULL, 
  Correo          varchar(70) NOT NULL, 
  Telefono        varchar(10) NOT NULL, 
  Usuario         varchar(50) NOT NULL, 
  Contraseña      varchar(50) NOT NULL, 
  Status          varchar(2) NOT NULL, 
  PRIMARY KEY (IDUsuario));
CREATE TABLE Marcas (
  IDMarca SERIAL NOT NULL, 
  Marca   varchar(100) NOT NULL, 
  Status  varchar(2) NOT NULL, 
  PRIMARY KEY (IDMarca));
CREATE TABLE Modelo (
  IDModelo SERIAL NOT NULL, 
  IDMarca  int4 NOT NULL, 
  Status   varchar(2) NOT NULL, 
  PRIMARY KEY (IDModelo));
CREATE TABLE Cliente (
  IDCliente       SERIAL NOT NULL, 
  Nombre          varchar(50) NOT NULL, 
  ApellidoPaterno varchar(50) NOT NULL, 
  ApellidoMaterno varchar(50) NOT NULL, 
  RFC             varchar(13) NOT NULL, 
  Correo          varchar(70) NOT NULL, 
  Telefono        varchar(10) NOT NULL, 
  Calle           varchar(40) NOT NULL, 
  NumExt          varchar(10) NOT NULL, 
  NumInt          varchar(10), 
  Colonia         varchar(40) NOT NULL, 
  CP              varchar(5) NOT NULL, 
  Localidad       varchar(50) NOT NULL, 
  Status          varchar(2) NOT NULL, 
  PRIMARY KEY (IDCliente));
CREATE TABLE Trabajo (
  IDTrabajo   SERIAL NOT NULL, 
  IDModelo    int4 NOT NULL, 
  DescTrabajo varchar(50) NOT NULL, 
  Costo       numeric(19, 2), 
  Status      varchar(2) NOT NULL, 
  PRIMARY KEY (IDTrabajo));
CREATE TABLE ConcentradoRenovado (
  IDConcentrado SERIAL NOT NULL, 
  IDUsuario     int4 NOT NULL, 
  Comentario    varchar(50), 
  Fecha         time(7) NOT NULL, 
  Status        varchar(2) NOT NULL, 
  PRIMARY KEY (IDConcentrado));
CREATE TABLE ConcetradoRenovadoDetalle (
  IDConcentrado int4 NOT NULL, 
  IDDetalle     int4 NOT NULL, 
  IDllanta      int4 NOT NULL, 
  IDTrabajo     int4 NOT NULL, 
  Comentario    varchar(50), 
  PRIMARY KEY (IDConcentrado, 
  IDDetalle, 
  IDllanta));
CREATE TABLE Salidas (
  IDSalida  SERIAL NOT NULL, 
  IDusuario int4 NOT NULL, 
  IDCliente int4 NOT NULL, 
  Fecha     time(7), 
  Status    varchar(2), 
  PRIMARY KEY (IDSalida));
CREATE TABLE SalidasDetalle (
  IDSalida      int4 NOT NULL, 
  IDDetSalida   int4 NOT NULL, 
  IDConcentrado int4 NOT NULL, 
  IDDetConcen   int4 NOT NULL, 
  IDllanta      int4 NOT NULL, 
  Monto         numeric(19, 2), 
  "Column"      int4, 
  PRIMARY KEY (IDSalida, 
  IDDetSalida));
ALTER TABLE Datosllantas ADD CONSTRAINT FKDatosllant116695 FOREIGN KEY (FolioEntrada) REFERENCES Entrada (FolioEntrada);
ALTER TABLE Entrada ADD CONSTRAINT FKEntrada812519 FOREIGN KEY (IDUsuario) REFERENCES Usuario (IDUsuario);
ALTER TABLE Datosllantas ADD CONSTRAINT FKDatosllant952765 FOREIGN KEY (IDMarca) REFERENCES Marcas (IDMarca);
ALTER TABLE Modelo ADD CONSTRAINT FKModelo932080 FOREIGN KEY (IDMarca) REFERENCES Marcas (IDMarca);
ALTER TABLE Datosllantas ADD CONSTRAINT FKDatosllant991104 FOREIGN KEY (ModeloIDModelo) REFERENCES Modelo (IDModelo);
ALTER TABLE Datosllantas ADD CONSTRAINT FKDatosllant404041 FOREIGN KEY (IDCliente) REFERENCES Cliente (IDCliente);
ALTER TABLE Datosllantas ADD CONSTRAINT FKDatosllant112560 FOREIGN KEY (TrabajoIDTrabajo) REFERENCES Trabajo (IDTrabajo);
ALTER TABLE ConcentradoRenovado ADD CONSTRAINT FKConcentrad957010 FOREIGN KEY (IDUsuario) REFERENCES Usuario (IDUsuario);
ALTER TABLE Trabajo ADD CONSTRAINT FKTrabajo44601 FOREIGN KEY (IDModelo) REFERENCES Modelo (IDModelo);
ALTER TABLE ConcetradoRenovadoDetalle ADD CONSTRAINT FKConcetrado584719 FOREIGN KEY (IDConcentrado) REFERENCES ConcentradoRenovado (IDConcentrado);
ALTER TABLE ConcetradoRenovadoDetalle ADD CONSTRAINT FKConcetrado717697 FOREIGN KEY (IDllanta) REFERENCES Datosllantas (IDllanta);
ALTER TABLE Entrada ADD CONSTRAINT FKEntrada484326 FOREIGN KEY (IDCliente) REFERENCES Cliente (IDCliente);
ALTER TABLE ConcetradoRenovadoDetalle ADD CONSTRAINT FKConcetrado650410 FOREIGN KEY (IDTrabajo) REFERENCES Trabajo (IDTrabajo);
ALTER TABLE Salidas ADD CONSTRAINT FKSalidas820490 FOREIGN KEY (IDusuario) REFERENCES Usuario (IDUsuario);
ALTER TABLE Salidas ADD CONSTRAINT FKSalidas803628 FOREIGN KEY (IDCliente) REFERENCES Cliente (IDCliente);
ALTER TABLE SalidasDetalle ADD CONSTRAINT FKSalidasDet847017 FOREIGN KEY (IDConcentrado, IDDetConcen, IDllanta) REFERENCES ConcetradoRenovadoDetalle (IDConcentrado, IDDetalle, IDllanta);
ALTER TABLE SalidasDetalle ADD CONSTRAINT FKSalidasDet240776 FOREIGN KEY (IDSalida) REFERENCES Salidas (IDSalida);
