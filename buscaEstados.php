<?php
header('Content-type: text/html; charset=ISO-8859-1');


/** Informações de conexão */
include('conexao.php');

include('funcoes.php');


$arrayDeEstados = buscaEstadosCadastrados($connOrulo);
$autorizacao = "Authorization: Bearer 8f023087-0623-476a-b1b3-6da0f9efaa90";
///////////////////////////////////////////////////////////////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $autorizacao));

curl_setopt($ch, CURLOPT_URL, "http://api-br.sandbox.open.navent.com/v1/locais");
$resposta = json_decode(curl_exec($ch));
curl_close($ch);

// var_dump($resposta);
// die("aqui");

$sql_insere_uf = "INSERT INTO imovelweb_uf (id_uf_imovel_web, nome_uf, nome_uf_completo) VALUES ";

$contador = 0;
foreach ($resposta as $estado) {

    if (!in_array($estado->id, $arrayDeEstados)) {
        $sql_insere_uf .= "('" . $estado->id . "', '" . $estado->nombre . "', '" . $estado->nombreCompleto . "'), ";
        $contador++;
    }
}

/** Trata o final da string */
$sql_insere_uf = substr($sql_insere_uf, 0, -2);
$sql_insere_uf .= ";";

//executar a query somente se houver outro estado para ser incluido
if ($contador > 0) {
    if (!mysqli_query($connOrulo, $sql_insere_uf)) { // insere o estado na tabela)
        var_dump("deu RUim");
    }
}
