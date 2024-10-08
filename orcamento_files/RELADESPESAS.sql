CREATE PROCEDURE RELADESPESAS(
  PCODIGOCONTA INTEGER,
  PCODIGOMOVIMENTO INTEGER,
  PDESCRICAO VARCHAR(150) CHARACTER SET ISO8859_1,
  POBSERVACAO VARCHAR(150) CHARACTER SET ISO8859_1)
RETURNS(
  RTDEBITO NUMERIC(18, 2),
  RTCREDITO NUMERIC(18, 2),
  RDESCRICAOCONTA VARCHAR(150) CHARACTER SET ISO8859_1)
AS
BEGIN
  IF (PDESCRICAO <> 'Despesas com Material de Consumo') THEN
  BEGIN
    FOR SELECT SUM(L.DEBITO), SUM(L.CREDITO), C.DESCRICAO
    FROM LANCAMENTOS L
    INNER JOIN CONTAS      C ON (L.CODIGOCONTA = C.CODIGO)
    INNER JOIN TIPOSCONTAS T ON (C.CODIGOTIPOCONTA = T.CODIGO)
    WHERE C.CODIGO = :PCODIGOCONTA AND L.CODIGOMOVIMENTO = :PCODIGOMOVIMENTO
    AND L.DESCRICAO LIKE  '%' || :PDESCRICAO  || '%'
    AND UPPER(L.DESCRICAO) NOT LIKE '%' || 'SUPLEMENTA' || '%'
    AND L.OBSERVACAO LIKE '%' || :POBSERVACAO || '%'
    GROUP BY C.DESCRICAO
    ORDER BY C.DESCRICAO
    INTO :RTDEBITO, :RTCREDITO, :RDESCRICAOCONTA
    DO SUSPEND;
  END
  ELSE
  BEGIN
    FOR SELECT SUM(L.DEBITO), SUM(L.CREDITO), C.DESCRICAO
    FROM LANCAMENTOS L
    INNER JOIN CONTAS      C ON (L.CODIGOCONTA = C.CODIGO)
    INNER JOIN TIPOSCONTAS T ON (C.CODIGOTIPOCONTA = T.CODIGO)
    WHERE C.CODIGO = :PCODIGOCONTA AND L.CODIGOMOVIMENTO = :PCODIGOMOVIMENTO
    AND (L.DESCRICAO LIKE '%' || 'Almoxarifado' || '%'
    OR L.DESCRICAO LIKE '%' || 'Mi�das' || '%')
    AND UPPER(L.DESCRICAO) NOT LIKE '%' || 'SUPLEMENTA' || '%'
    AND L.OBSERVACAO LIKE '%' || :POBSERVACAO || '%'
    GROUP BY L.OBSERVACAO, C.DESCRICAO
    ORDER BY L.OBSERVACAO, C.DESCRICAO
    INTO :RTDEBITO, :RTCREDITO, :RDESCRICAOCONTA
    DO SUSPEND;
  END
END
