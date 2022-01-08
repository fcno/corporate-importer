<?php
/**
 * @see https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc.
 */

return <<<XML
<?xml version='1.0' encoding='UTF-8'?>
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
        <cargo id="8" nome=""/>
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
        <funcao id="8" nome=""/>
        <!-- Nome com mais de 255 caracteres -->
        <funcao id="9" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4"/>
    </funcoes>
    <lotacoes>
         <!-- Lotações Válidas -->
        <lotacao id="1" nome="Lotação 1" sigla="sigla 1"/>
        <lotacao id="2" nome="Lotação 2" sigla="sigla 2" idPai=""/>
        <lotacao id="3" nome="Lotação 3" sigla="sigla 3" idPai="1"/>
        <!-- Lotações Inválidas -->
        <!-- Sem o ID -->
        <lotacao nome="Lotação 4" sigla="sigla 4" idPai="1"/>
        <!-- ID nulo/vazio -->
        <lotacao id="" nome="Lotação 5" sigla="sigla 5"/>
        <!-- ID menor ou igual a zero -->
        <lotacao id="0" nome="Lotação 6" sigla="sigla 6" idPai="1"/>
        <!-- Sem o nome -->
        <lotacao id="7" sigla="sigla 7"/>
        <!-- Nome nulo/vazio -->
        <lotacao id="8" nome="" sigla="sigla 8" idPai="1"/>
        <!-- Nome com mais de 255 caracteres -->
        <lotacao id="9" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4" sigla="sigla 9"/>
        <!-- Sem o sigla -->
        <lotacao id="10" nome="Lotação 10" idPai="1"/>
        <!-- Sigla nulo/vazio -->
        <lotacao id="12" nome="Lotação 11" sigla=""/>
        <!-- Sigla com mais de 55 caracteres -->
        <lotacao id="12" nome="Lotação 12" sigla="X7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45" idPai="1"/>
    </lotacoes>
</base>
XML;
