CREATE PROCEDURE INSEREUNIDADE(
  PID CHAR(2) CHARACTER SET ISO8859_1,
  PNOME VARCHAR(70) CHARACTER SET ISO8859_1,
  PDEPARTAMENTO VARCHAR(80) CHARACTER SET ISO8859_1)
AS
BEGIN
  INSERT INTO UNIDADE (ID, NOME, DEPARTAMENTO)
  VALUES (:PID, :PNOME, :PDEPARTAMENTO);
  SUSPEND;
END