<?php
/**
 * @see https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc.
 */

return <<<XML
<?xml version='1.0' encoding='ISO-8859-1'?>
<base orgaoUsuario="ES" dataHora="">
    <cargos>
        <!-- Cargos Válidos -->
        <cargo id="1" nome="Cargo 1"/>
        <cargo id="2" nome="Cargo 2"/>
        <cargo id="3" nome="Cargo 3"/>
        <!-- Cargos Inválidos -->
        <!-- Sem o ID -->
        <cargo nome="Cargo 4"/>
        <!-- ID nulo/vazio -->
        <cargo id="" nome="Cargo 5"/>
        <!-- ID menor ou igual a zero -->
        <cargo id="0" nome="Cargo 6"/>
        <!-- Sem o nome -->
        <cargo id="7"/>
        <!-- Nome nulo/vazio -->
        <cargo id="8" nom=""/>
        <!-- Nome com mais de 255 caracteres -->
        <cargo id="9" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4"/>
    </cargos>
    <funcoes>
         <!-- Funções Válidas -->
        <funcao id="1" nome="Função 1"/>
        <funcao id="2" nome="Função 2"/>
        <funcao id="3" nome="Função 3"/>
        <!-- Funções Inválidas -->
        <!-- Sem o ID -->
        <funcao nome="Função 4"/>
        <!-- ID nulo/vazio -->
        <funcao id="" nome="Função 5"/>
        <!-- ID menor ou igual a zero -->
        <funcao id="0" nome="Função 6"/>
        <!-- Sem o nome -->
        <funcao id="7"/>
        <!-- Nome nulo/vazio -->
        <funcao id="8" nom=""/>
        <!-- Nome com mais de 255 caracteres -->
        <funcao id="9" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4"/>
    </funcoes>
</base>
XML;
