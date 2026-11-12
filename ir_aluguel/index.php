<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/newadm/CONTROLLER/trava.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>...:::: Calculadora IR - Aluguel ::::...</title>
  <link rel="shortcut icon" href="../imagens/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/estilo_modelo_simples.css" />
  <link rel="stylesheet" href="../newadm/include/css/estilo_header_footer.css" />
</head>

<body>
  <?php
  include "../newadm/include/header.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/newadm/CONTROLLER/conexao.php";
  //avisos
  require_once $_SERVER['DOCUMENT_ROOT'] . "/newadm/MODEL/avisos.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/newadm/CONTROLLER/avisos_dao.php";
  ?>

  <main>
    <div id='atualiza'>
      <?php
      $id_ferramentas = 32;
      $todosavisos = Avisos_DAO::buscarAvisos($id_ferramentas);
      foreach ($todosavisos as $avisosatual) {
        echo "
        <li class='lista_atualiza'>
          <p> $avisosatual->desc_avisos</p>
        </li>
	";
      }
      ?>
    </div>
    <div id="ferramenta">
      <div id="tit_ferramenta">
        <h2>Calculadora IR - Aluguel</h2>
        <p>
          Utilize está ferramenta para calcular o Imposto de Renda sobre os Alugueis, conforme o Art. 688 e Art. 118 do RIR/2018</p>
      </div>
      <form method="post" name="form_ferramenta">
        <div class="formulario">
          <label class="sub_tit_ferramenta">Informações para Cálculo </label>
        </div>
        <div class="formulario">
          <label>Valor Aluguel:</label>
          <input
            class="input"
            type="text"
            id="vlr_calc"
            maxlength="14"
            placeholder="R$ 00,00" />
          <button class="ajuda esconder" type="button">?</button>
        </div>
        <div class="formulario">
          <label>Valor da Taxa Imobiliária:</label>
          <input
            class="input"
            type="text"
            id="vlr_imobiliaria"
            maxlength="14"
            placeholder="R$ 00,00" />
          <button class="ajuda esconder" type="button">?</button>
        </div>
        <div class="formulario">
          <label>Dependentes:</label>
          <input type="text"
            class="input"
            id="dependentes"
            maxlength="2"
            placeholder="00">
          <button class="ajuda esconder" type="button">?</button>
        </div>
        <div class="formulario">
          <label>Desconto Simplificado:</label>
          <select class="input" id="desc_simplificado">
            <option value="0">Não</option>
            <option value="1" selected >Sim</option>
          </select>
          <button class="ajuda esconder" type="button">?</button>
        </div>
        <div id="bloco_botao">
          <button class="botao" id="bt_calcular" type="button"><i class="fa-solid fa-calculator"></i> Calcular</button>
        </div>
        <div id="aviso" class="sumir">
          <p></p>
        </div>
        <div id="resultado" class="sumir">
          <div class="overflow">
            <table>
              <tr class="tit_resul">
                <td colspan="4">Resultados</td>
              </tr>
              <tr>
                <th class="border">Alíquota Aplicada</th>
                <th class="border">IRRF a Recolher</th>
                <th class="border">Valor dos Dependentes</th>
                <th>Desconto Simplificado</th>
              </tr>
              <tr>
                <td class="border" id="aliq_ir_i"></td>
                <td class="border" id="vlr_ir_i"></td>
                <td class="border" id="dependentes_i"></td>
                <td id="desc_completo_i"></td>
              </tr>
            </table>
          </div>

        </div>
      </form>
      <div class="overflow">
        <table>
          <tr class="tit_resul">
            <td colspan="5">Alterações na Tributação Mensal (IRRF) Art.1° da Lei 15.270/2025</td>
          </tr>
          <tr>
            <th class="border">Rendimentos Tributáveis Sujeitos ao Ajuste Mensal</th>
            <th class="border">Redução do Imposto de Renda</th>
            <th>Efeito Prático</th>
          </tr>
          <tr>
            <td class="border">Até R$ 5.000,00</td>
            <td class="border">Até R$ 312,89</td>
            <td>O imposto devido é zerado, o que na prática amplia a faixa de
              isenção para rendimentos de até R$ 5.000,00 mensais.</td>
          </tr>
          <tr>
            <td class="border">De R$ 5.000,01 até R$ 7.350,00</td>
            <td class="border">Redução decrescente linearmente</td>
            <td>A redução é calculada pela fórmula: R$ 978,62 -
              (0,133145 x rendimentos tributáveis). A redução diminui progressivamente até
              ser zero para rendimentos a partir de R$ 7.350,00.</td>
          </tr>
          <tr>
            <td class="border">Acima de R$ 7.350,00</td>
            <td class="border">Nenhuma redução</td>
            <td>Contribuintes com rendimentos superiores a este valor
              não terão a redução de imposto prevista neste artigo.</td>
          </tr>
        </table>

        <table>
          <tr class="tit_resul">
            <td colspan="5">Tabela IRRF - Maio de 2025 em diante</td>
          </tr>
          <tr>
            <th class="border">Base de Cálculo (R$)</th>
            <th class="border">Alíquota (%)</th>
            <th>Parcela a Deduzir do IR (R$)</th>
          </tr>
          <tr>
            <td class="border">De 2.428,81 até 2.826,65</td>
            <td class="border">7,5%</td>
            <td>182,16</td>
          </tr>
          <tr>
            <td class="border">De 2.826,66 até 3.751,05</td>
            <td class="border">15%</td>
            <td>394,16</td>
          </tr>
          <tr>
            <td class="border">De 3.751,06 até 4.664,68</td>
            <td class="border">22,5%</td>
            <td>675,49</td>
          </tr>
          <tr>
            <td class="border">Acima de 4.664,68</td>
            <td class="border">27,5%</td>
            <td>908,73</td>
          </tr>
          <tr>
            <td class="border">Dependentes: R$ 189,59</td>
            <td class="border">Desconto simplificado: R$ 607,20</td>
            <td>-</td>
          </tr>
        </table>
      </div>
      <div id="txt_formulario">
        <p>Base Legal: <a href="http://www.planalto.gov.br/CCIVIL_03/_Ato2011-2014/2011/Lei/L12469.htm#:~:text=LEI%20N%C2%BA%2012.469%2C%20DE%2026%20DE%20AGOSTO%20DE%202011.&text=Altera%20os%20valores%20constantes%20da,2%20de%20julho%20de%202002." target="_blank">Artigo 1º, IX da Lei Nº 11.482, de 31 de Maio de 2007.</a></p>
        <h4>Como é feito o calculo:</h4>
        <p><strong>EXEMPLO 1</strong></p>
        <p>João recebe salário bruto de R$ 3.036,00 em 02/01/2026.</p>
        <p>Sua única dedução permitida é a contribuição previdenciária no valor de R$ 257,73.</p>
        <p>O desconto simplificado mensal, que substitui todas as deduções legais permitidas, é de 25%
          do limite máximo da tabela progressiva mensal, ou seja, 25% de R$ 2.428,80 = R$ 607,20.</p>
        <p>Como o desconto simplificado mensal é mais vantajoso do que as deduções legais, a fonte pagadora deve considerá-lo</p>
        <p>A base de cálculo do imposto sobre a renda será igual ao salário bruto subtraído do desconto simplificado, ou seja,
          R$ 3.036,00 – R$ 607,20 = R$ 2.428,00.</p>
        <p>Com o valor da base de cálculo, aplica-se a tabela progressiva.</p>
        <p>Esse valor está compreendido na 1ª faixa da tabela, com alíquota de 0%.</p>
        <p>Imposto sobre a Renda Retido na Fonte (IRRF) = (base de cálculo x alíquota) – parcela a deduzir =
          (R$ 2.428,00 x 0%) – R$ 0,00 = R$ 0,00.</p>
        <br>
        <p><strong>EXEMPLO 2</strong></p>
        <p>José recebe salário bruto de R$ 4.000,00 em 02/01/2026.</p>
        <p>Sua única dedução permitida é a contribuição previdenciária no valor de R$ 373,41.</p>
        <p>O desconto simplificado mensal, que substitui todas as deduções legais permitidas, é de 25% do limite máximo da
          tabela progressiva mensal, ou seja, 25% de R$ 2.428,80 = R$ 607,20.</p>
        <p>Como o desconto simplificado mensal é mais vantajoso do que as deduções legais, a fonte pagadora deve considerá-lo.</p>
        <p>A base de cálculo do imposto sobre a renda será igual ao salário bruto subtraído do desconto simplificado, ou
          seja, R$ 4.000,00 – R$ 607,20 = R$ 3.392,80.</p>
        <p>Com o valor da base de cálculo, aplica-se a tabela progressiva.</p>
        <p>Esse valor está compreendido na 3ª faixa da tabela, com alíquota de 15% (e parcela a deduzir de R$ 394,16).</p>
        <p>Imposto sobre a Renda Retido na Fonte (IRRF) = (base de cálculo x alíquota) – parcela a deduzir = (R$ 3.392,80 x 15%) – R$ 394,16 = R$ 114,76.</p>
        <p>Deve-se aplicar a redução do imposto no valor de até R$ 312,89 (de modo a que o imposto devido seja zero).</p>
        <p>Sendo assim, IRRF = R$ 114,76 – R$ 114,76 = R$ 0,00 (a dedução é limitada ao valor do imposto determinado com a tabela progressiva, no caso deste
          exemplo, ao valor de R$ 114,76).</p>
        <br>
        <p><strong>EXEMPLO 3</strong></p>
        <p>Maria recebe salário bruto de R$ 5.000,00 em 02/01/2026.</p>
        <p>Sua única dedução permitida é a contribuição previdenciária no valor de R$ 509,60.</p>
        <p>O desconto simplificado mensal, que substitui todas as deduções legais permitidas, é de 25% do limite máximo da tabela progressiva mensal, ou
          seja, 25% de R$ 2.428,80 = R$ 607,20.</p>
        <p>Como o desconto simplificado mensal é mais vantajoso do que as deduções legais, a fonte pagadora deve considerá-lo</p>
        <p>A base de cálculo do imposto sobre a renda será igual ao salário bruto subtraído do desconto simplificado, ou seja, R$
          5.000,00 – R$ 607,20 = R$ 4.392,80.</p>
        <p>Com o valor da base de cálculo, aplica-se a tabela progressiva.</p>
        <p>Esse valor está compreendido na 4ª faixa da tabela, com alíquota de 22,5% (e parcela a deduzir de R$675,49).</p>
        <p>Imposto sobre a Renda Retido na Fonte (IRRF) = (base de cálculo x alíquota) – parcela a deduzir = (R$ 4.392,80 x 22,5%) – R$ 675,49 = R$ 312,89.</p>
        <p>Deve-se aplicar a redução do imposto no valor de até R$ 312,89 (de modo a que o imposto devido seja zero).</p>
        <p>Sendo assim, IRRF = R$ 312,89 – R$ 312,89 = R$ 0,00 (a dedução é limitada ao valor do imposto determinado com a tabela progressiva, no caso
          deste exemplo, ao valor de R$ 312,89).</p>
        <br>
        <p><strong>EXEMPLO 4</strong></p>
        <p>Rita recebe salário bruto de R$ 6.000,00 em 02/01/2026.</p>
        <p>Sua única dedução permitida é a contribuição previdenciária no valor de R$ 649,60.</p>
        <p>O desconto simplificado mensal, que substitui todas as deduções legais permitidas, é de 25% do limite máximo da tabela progressiva mensal,
          ou seja, 25% de R$ 2.428,80 = R$ 607,20.</p>
        <p>Como o desconto simplificado mensal é menos vantajoso do que as deduções legais, a fonte pagadora deve considerar
          as deduções legais permitidas.</p>
        <p>A base de cálculo do imposto sobre a renda será igual ao salário bruto subtraído das deduções legais permitidas,
          ou seja, R$ 6.000,00 – R$ 649,60 = R$ 5.350,40.</p>
        <p>Com o valor da base de cálculo, aplica-se a tabela progressiva.</p>
        <p>Esse valor está compreendido na 5ª faixa da tabela, com alíquota de 27,5% (e parcela a deduzir de R$ 908,73).</p>
        <p>Imposto sobre a Renda Retido na Fonte (IRRF) = (base de cálculo x alíquota) – parcela a deduzir = (R$ 5.350,40 x 27,5%) – R$ 908,73 = R$ 562,63.</p>
        <p>Deve-se observar, ainda, o disposto na 2ª faixa da tabela do art. 6º-A da Lei nº 9.250, de 26 de dezembro de 1995, ou seja, deve-se aplicar a redução
          do imposto no valor de R$ 978,62 - (0,133145 x rendimentos tributáveis sujeitos à incidência mensal).</p>
        <p>Sendo assim, IRRF = R$ 562,63 – [R$ 978,62 – (0,133145 x R$ 6.000,00)] = R$ 562,63 – [R$ 978,62 – R$ 798,87] = R$ 562,63 – R$ 179,75 = R$ 382,88.</p>
        <br>
        <p><strong>EXEMPLO 5</strong></p>
        <p>Vera recebe salário bruto de R$ 7.607,20 em 02/01/2026.</p>
        <p>Vera não possui nenhuma dedução legal permitida.</p>
        <p>O desconto simplificado mensal, que substitui todas as deduções legais permitidas, é de 25% do limite máximo da tabela progressiva mensal, ou seja,
          25% de R$ 2.428,80 = R$ 607,20.</p>
        <p>Como o desconto simplificado mensal é mais vantajoso do que as deduções legais, a fonte pagadora deve considerá-lo.</p>
        <p>A base de cálculo do imposto sobre a renda será igual ao salário bruto subtraído do desconto simplificado mensal, ou seja, R$ 7.607,20 – R$ 607,20 = R$ 7.000,00.</p>
        <p>Com o valor da base de cálculo, aplica-se a tabela progressiva.</p>
        <p>Esse valor está compreendido na 5ª faixa da tabela, com alíquota de 27,5% (e parcela a deduzir de R$ 908,73).</p>
        <p>Imposto sobre a Renda Retido na Fonte (IRRF) = (base de cálculo x alíquota) – parcela a deduzir = (R$ 7.000,00 x 27,5%) – R$ 908,73 = R$ 1.016,27.</p>
        <p>Deve-se observar que neste exemplo o salário (rendimento tributável sujeito à incidência mensal) é superior ao valor de R$ 7.350,00, logo não é permitida a
          redução prevista na tabela do art. 6º-A da Lei nº 9.250, de 26 de dezembro de 1995, tendo em vista o disposto em sua 2ª faixa e no seu § 2º.</p>
        <p>Importante observar que se utiliza nessa tabela de redução o valor do salário (R$ 7.607,20), e não o da base de cálculo (R$ 7,000,00).</p>
      </div>
  </main>

  <?php
  include "../newadm/include/footer.php"
  ?>
  <script src="js/script.js?v=4"></script>
  <script src="../newadm/include/js/script.js"></script>
</body>

</html>