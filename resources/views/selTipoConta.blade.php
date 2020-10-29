<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
if(!isset($_SESSION)) {
  session_start();
}
unset($_SESSION["CTipoConta"]);
 // session_unregister("CTipoConta");
//if ( isset($_POST[Descricao]) ) {
$sDescricao = isset($_POST["Descricao"]) ? $_POST["Descricao"] : null; 
$SQL = "SELECT RCODIGO, RDESCRICAO 
        FROM OBTEMTODOSTIPOSCONTAS 
        ORDER BY RDESCRICAO;";
$color = "#FFFFFF";
$contador = 0;
//}
?>
<html>
<head>
<title>::.. Seleciona Tipo de Conta ..::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../botoes.css" rel="stylesheet" type="text/css">
<LINK href="../caixas.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
function pasteColumn(codigo,descricao) {
	window.opener.document.Formulario.CodigoTipoConta.value = codigo;
	window.opener.document.Formulario.DescricaoTipoConta.value = descricao;
	window.close();
}
</SCRIPT>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body class="body">
<p align="center"><font size="6" face="Tahoma" color=#003399><strong>Tipos de 
  Contas - Sele&ccedil;&atilde;o</strong></font> </p>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><form name="form1" method="post" action="selTipoConta.php">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td>
              <?php if ( isset( $resultado )) { ?>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#000099"> 
                  <td width="10%">
<div align="center"><strong><font color="#FFFFFF" size="2" face="Tahoma">&nbsp;<span class="label2">C&oacute;digo</span></font></strong></div></td>
                  <td width="90%"><strong><font color="#FFFFFF" size="2" face="Tahoma">&nbsp;<span class="label2">Descri&ccedil;&atilde;o</span></font></strong></td>
                </tr>
                <?php while ($linhas = ibase_fetch_object($resultado)) { ?>
                <tr> 
                  <td bgcolor="<?php print $color; ?>"><div align="right"><font size="2" face="Tahoma">&nbsp;<?php print $linhas->RCODIGO ?></font></div></td>
                  <td bgcolor="<?php print $color; ?>"><font size="2" face="Tahoma">&nbsp;<a href="javascript:pasteColumn('<?php print $linhas->RCODIGO; ?>','<?php print $linhas->RDESCRICAO; ?>')" class="linkselecao"><?php print $linhas->RDESCRICAO; ?></a></font></td>
                </tr>
                <?php  if ( $color == "#FFFFFF" ) { 
			                  $color = "#EFEFEF"; 
					        } else {
							  $color = "#FFFFFF";
							}
					     $contador += 1; 		
				       } ?>
                <tr> 
                  <td colspan="2"><font size="2" face="Tahoma">&nbsp;</font></td>
                </tr>
                <tr> 
                  <td colspan="2"><font size="2" face="Tahoma">&nbsp;<strong>Foram encontrados <?php print $contador; ?> registros.</strong></font></td>
                </tr>
              </table>
              <?php } ?>
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
