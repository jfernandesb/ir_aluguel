// Mascara do Input - Formato de Moeda (Não Mudar)

// usa vírgula como separador decimal, ponto como separador de milhar, sempre com 2 casas decimais
const formatter = new Intl.NumberFormat("pt-BR", {
  minimumFractionDigits: 2,
  maximumFractionDigits: 2,
});

function mask(e) {
  const input = e.target;
  // elimina tudo que não é dígito
  input.value = input.value.replace(/\D+/g, "");
  if (input.value.length === 0)
    // se não tem nada preenchido, não tem o que fazer
    return;
  // verifica se ultrapassou a quantidade máxima de dígitos (pegar o valor no dataset)
  const maxDigits = parseInt(input.dataset.maxDigits);
  if (input.value.length > maxDigits) {
    // O que fazer nesse caso? Decidi pegar somente os primeiros dígitos
    input.value = input.value.substring(0, maxDigits);
  }
  // lembrando que o valor é a quantidade de centavos, então precisa dividir por 100
  input.value = formatter.format(parseInt(input.value) / 100);
}

// Input que vai receber o formato de moeda (Mudar)
document.querySelector("#vlr_calc").addEventListener("input", mask);
document.querySelector("#vlr_imobiliaria").addEventListener("input", mask);

// Input em Formato Percentual (Não Mudar)
function maskpercent(mascara, documento) {
  let i = documento.value.length;
  let saida = "#";
  let texto = mascara.substring(i);
  while (texto.substring(0, 1) != saida && texto.length) {
    documento.value += texto.substring(0, 1);
    i++;
    texto = mascara.substring(i);
  }
}

//Altera o Formato de Moeda para Float (Não Mudar)
function moedaParaFloat(valor) {
  let textoLimpo = valor
    .replace(".", "")
    .replace(".", "")
    .replace(",", ".")
    .replace("", "0");
  return parseFloat(textoLimpo);
}

//Altera o Formato de Float para Moeda (Não Mudar)
function floatParaMoeda(valor) {
  // Converte o valor para um número
  const numero = parseFloat(valor);
  // Formata o número para moeda brasileira
  return `R$ ${numero.toLocaleString("pt-BR", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  })}`;
}

//Calcular (Não Mudar)
document.getElementById("bt_calcular").addEventListener("click", function () {
  //Declarar Variaveis do Input (Mudar)
  var myDiv_aviso = document.getElementById("aviso");

  var myDiv_resul = document.getElementById("resultado");

  var vlr_calc = moedaParaFloat(document.getElementById("vlr_calc").value);
  var vlr_imobiliaria = moedaParaFloat(document.getElementById("vlr_imobiliaria").value);
  var dependentes = document.getElementById("dependentes").value;

  //Bloquear Calculo quando Campos Estão em Branco e Mostrar Avisos (Mudar)

  if (vlr_calc == "") {
    
    var aviso_branco = "Valor para Cálculo não informado.";


    //(Não Mudar)
    myDiv_aviso.classList.remove("sumir");
    myDiv_aviso.offsetHeight;
    myDiv_aviso.classList.add("show_result");

    //Sumir Resultado (Não Mudar)
    myDiv_resul.classList.add("sumir");

    document.getElementById("aviso").textContent = aviso_branco;

    return; //Para parar o calculo
  } else {
    //Tabela de Resultado Aparecer (Não Mudar)
    myDiv_resul.classList.remove("sumir"); // Remove a classe 'hidden'
    myDiv_resul.offsetHeight; // Força o reflow para garantir que a transição aconteça
    myDiv_resul.classList.add("show_result"); // Adiciona a classe 'show' para iniciar a transição

    //Sumir Avisos (Não Mudar)
    myDiv_aviso.classList.add("sumir");
  }
  //Definir Aliquota Interestadual (Mudar)

  //Calcular Dependentes

  var vlr_dependts = dependentes * 189.59;

  // Base IR
  if (document.getElementById("desc_simplificado").value == 0) {
    var base_ir = vlr_calc - vlr_dependts - vlr_imobiliaria;
  } else {
    // Base IR Quando as Deduções legais (INSS, Dependentes, Pensão) for menor que 528

    var base_ir = vlr_calc - 607.2 - vlr_imobiliaria;
  }
  
  //Calculo Isenção e Reduções IR 2026
  if (vlr_calc <= 5000){
	  var desc_ir_2026 = 312.89;
  }
  else if (vlr_calc > 5000 && vlr_calc <= 7350){
	  var desc_ir_2026 = (0.133145 * vlr_calc) - 978.62;
  }
  else if (vlr_calc > 7350){
	  var desc_ir_2026 = 0;
  };
  
  //Calcular base e valor do IR (Cálculo Janeiro/2026)
  
  if (base_ir <= 2428.8) {
    var vlr_ir = 0;
    var aliq_ir = 0;
  }
  if (base_ir >= 2428.81 && base_ir <= 2826.65) {
    var vlr_ir = (base_ir * 0.075 - 182.16) - desc_ir_2026;
    var aliq_ir = 7.5;
  }
  if (base_ir >= 2826.66 && base_ir <= 3751.05) {
    var vlr_ir = (base_ir * 0.15 - 394.16) - desc_ir_2026;
    var aliq_ir = 15;
  }
  if (base_ir >= 3751.06 && base_ir <= 4664.68) {
    var vlr_ir = (base_ir * 0.225 - 675.49) - desc_ir_2026;
    var aliq_ir = 22.5;
  }
  if (base_ir >= 4664.68 && base_ir <= 5000) {
    var vlr_ir = (base_ir * 0.275 - 908.73) - desc_ir_2026;
    var aliq_ir = 27.5;
  }
  if ((base_ir >= 5001 && base_ir <= 7350)) {
    var vlr_ir = (base_ir * 0.275 - 908.73) - desc_ir_2026;
    var aliq_ir = 27.5;
  }
  if (base_ir > 7350) {
    var vlr_ir = base_ir * 0.275 - 908.73;
    var aliq_ir = 27.5;
  }

  if (vlr_ir < 0) {
    var vlr_ir = 0;
  }
  //Mostrar no Resultado (Mudar)
  document.getElementById("aviso").textContent = aviso_branco;
  document.getElementById("aliq_ir_i").textContent = aliq_ir + "%";
  document.getElementById("vlr_ir_i").textContent = floatParaMoeda(
    vlr_ir.toFixed(2)
  );
  document.getElementById("dependentes_i").textContent = floatParaMoeda(
    vlr_dependts.toFixed(2)
  );
  if (document.getElementById("desc_simplificado").value == 1) {
    document.getElementById("desc_completo_i").textContent = "Aplicado";
  } else {
    document.getElementById("desc_completo_i").textContent = "Não Aplicado";
  }
});


