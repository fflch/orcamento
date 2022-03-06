CREATE PROCEDURE RELADESPESASMIUDASAREACONTA
RETURNS(
  RCODIGOAREA INTEGER,
  RCODIGOCONTA INTEGER,
  RNOMEAREA VARCHAR(40) CHARACTER SET ISO8859_1,
  RDESCRICAOCONTA VARCHAR(150) CHARACTER SET ISO8859_1)
AS
BEGIN
  FOR SELECT A.CODIGO, C.CODIGO, A.NOME, C.DESCRICAO
  FROM AREAS A
  INNER JOIN CONTAS C ON (A.CODIGO = C.CODIGOAREA)
  ORDER BY A.NOME, C.DESCRICAO
  INTO :RCODIGOAREA, :RCODIGOCONTA, :RNOMEAREA, :RDESCRICAOCONTA
  DO SUSPEND;
END