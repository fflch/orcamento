CREATE PROCEDURE RELAPREVISAOMATCONSUMO(
  PCODIGOMOVIMENTO INTEGER)
RETURNS(
  RNOMEAREA VARCHAR(40) CHARACTER SET ISO8859_1,
  RTOTALCREDITO NUMERIC(18, 2),
  RTOTALDEBITO NUMERIC(18, 2),
  RSALDOCONSUMO NUMERIC(18, 2))
AS
BEGIN
  FOR SELECT DISTINCT A.NOME, (SUM(L.CREDITO)) AS TOTALCREDITO,
  (SUM(L.DEBITO)) AS TOTALDEBITO, SA.SALDOCONSUMO
  FROM LANCAMENTOS L
  INNER JOIN CONTAS      C ON (L.CODIGOCONTA = C.CODIGO)
  INNER JOIN TIPOSCONTAS T ON (C.CODIGOTIPOCONTA = T.CODIGO)
  INNER JOIN SALDOAREAS SA ON (C.CODIGOAREA = SA.CODIGOAREA)
  RIGHT JOIN AREAS       A ON (SA.CODIGOAREA = A.CODIGO)
  WHERE SA.CODIGOMOVIMENTO = :PCODIGOMOVIMENTO
  AND L.CODIGOMOVIMENTO = :PCODIGOMOVIMENTO
  AND ((L.DESCRICAO LIKE '%' || 'Almoxarifado' || '%')
  OR (L.DESCRICAO LIKE '%' || 'Mi�das' || '%')
  OR (UPPER(L.DESCRICAO) LIKE '%' || 'SUPLEMENTA' || '%'))
  AND UPPER(T.DESCRICAO) LIKE 'AREAS/S%'
  GROUP BY A.NOME, SA.SALDOCONSUMO
  INTO :RNOMEAREA, :RTOTALCREDITO, :RTOTALDEBITO, :RSALDOCONSUMO
  DO SUSPEND;
END
