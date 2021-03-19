<?php
set_time_limit(-1);     // Permite que a rotine execute por tempo indeterminado

/** Informações de conexão */
include('conexao.php');

include('funcoes.php');


$arrayDeEstados = buscaEstadosCadastrados($connOrulo);
$arrayMunicipios = buscaMunicipiosCadastrados($connOrulo);

/** */

$autorizacao = "Authorization: Bearer 8f023087-0623-476a-b1b3-6da0f9efaa90";
///////////////////////////////////////////////////////////////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $autorizacao));


foreach ($arrayDeEstados as $municipio_id) {

    curl_setopt($ch, CURLOPT_URL, "http://api-br.sandbox.open.navent.com/v1/locais/$municipio_id");
    $municipios = json_decode(curl_exec($ch));

    $sql_insere_municipio = "INSERT INTO imovelweb_municipios (id_municipio_imovel_web, id_uf_imove_web, nome_municipio, nome_completo_municipio) VALUES ";
    foreach ($municipios->localidades as $municipio) {
        $municipioNome = str_replace("'", "´", $municipio->nombre);
        $nombreCompleto = str_replace("'", "´", $municipio->nombreCompleto);
        $sql_insere_municipio .= "('" . $municipio->id . "', '" . $municipios->id .  "', '" . $municipioNome . "', '" . $nombreCompleto . "'), ";
    }

    /** Trata o final da string */
    $sql_insere_municipio = substr($sql_insere_municipio, 0, -2);
    $sql_insere_municipio .= ";";

    //var_dump($sql_insere_municipio);
    if (!in_array($municipio->id, $arrayMunicipios)) {

        if (!mysqli_query($connOrulo, $sql_insere_municipio)) { // insere o empreendimento na tabela)
            var_dump("deu RUim");
            echo "<pre>";
            var_dump($sql_insere_municipio);
            echo "</pre>";
        }
    }
    //die();
}

//curl_close($ch);
die();
