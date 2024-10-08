CREATE PROCEDURE OBTEMFICHAORCAMENTARIA(
  PCODIGODOTACAO INTEGER,
  PDATA DATE)
RETURNS(
  RCODIGO INTEGER,
  RCODIGOMOVIMENTO INTEGER,
  RCODIGODOTACAO INTEGER,
  RDATA DATE,
  RNEMPENHO INTEGER,
  RDESCRICAO VARCHAR(150) CHARACTER SET ISO8859_1,
  RDEBITO NUMERIC(18, 2),
  RCREDITO NUMERIC(18, 2),
  RSALDO NUMERIC(18, 2),
  ROBSERVACAO VARCHAR(150) CHARACTER SET ISO8859_1,
  RUSUARIO CHAR(10) CHARACTER SET ISO8859_1,
  RDHMODIFICACAO TIMESTAMP,
  RANOMOVIMENTO INTEGER,
  RDOTACAO VARCHAR(40) CHARACTER SET ISO8859_1)
AS
BEGIN
  FOR SELECT F.CODIGO, F.CODIGOMOVIMENTO, F.CODIGODOTACAO, F.DATA, F.NEMPENHO,
  F.DESCRICAO, F.DEBITO, F.CREDITO, F.SALDO, F.OBSERVACAO, F.USUARIO,
  F.DHMODIFICACAO, M.ANO, D.DOTACAO
  FROM FICHAORCAMENTARIA F
  INNER JOIN MOVIMENTO M ON (F.CODIGOMOVIMENTO = M.CODIGO)
  INNER JOIN DOTACAO   D ON (F.CODIGODOTACAO = D.CODIGO)
  WHERE F.CODIGODOTACAO = :PCODIGODOTACAO AND F.DATA = :PDATA
  INTO :RCODIGO, :RCODIGOMOVIMENTO, :RCODIGODOTACAO, :RDATA, :RNEMPENHO,
  :RDESCRICAO, :RDEBITO, :RCREDITO, :RSALDO, :ROBSERVACAO, :RUSUARIO,
  :RDHMODIFICACAO, :RANOMOVIMENTO, :RDOTACAO
  DO
  SUSPEND;
END
