CREATE PROCEDURE INSERECONTAS(
  PCODIGOTIPOCONTA INTEGER,
  PCODIGOAREA INTEGER,
  PDESCRICAO VARCHAR(150) CHARACTER SET ISO8859_1,
  PEMAIL VARCHAR(40) CHARACTER SET ISO8859_1,
  PNUMERO VARCHAR(10) CHARACTER SET ISO8859_1,
  PATIVO CHAR(1) CHARACTER SET ISO8859_1)
AS
BEGIN
  INSERT INTO CONTAS (CODIGOTIPOCONTA, CODIGOAREA, DESCRICAO, EMAIL, NUMERO,
  ATIVO)
  VALUES (:PCODIGOTIPOCONTA, :PCODIGOAREA, :PDESCRICAO, :PEMAIL, :PNUMERO,
  :PATIVO);
  SUSPEND;
END