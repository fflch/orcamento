Transformar usuário em admin pelo tinker:

    php artisan tinker
    User:all()
    $eu = User::find(1);
    $eu->perfil = 'Administrador';
    $eu->save();

 ### Abas:
- <b>Lancamentos</b>
- <b>Movimentos</b>
- <b>Relatórios</b>
- <b>Administração</b>
- <b>MInhas Contas</b>

## Lancamento
<p> na aba ‘Lancamento’ (Somente aberta para os usuários registrados como Admin), cria-se um novo lançamento com os campos grupo, receita, data, empenho, descrição, se foi debito ou credito e observações. Na pagina, pode-se salvar o lançamento, desfazer ele (zerar os campos) e voltar para a pagina anterior. Quando se salva um lançamento, é possível alterar e deletar ele. No caso de alteração, é mostrado "cadastrado/alterado por" com o nome de quem alterou, a criação e ultima modificação do lançamento. Além disso, da pra incluir percentuais. Você pode adicionar a conta, o tipo da conta e o percentual, e salva. nao é possível salvar em branco.</p>
<br>

## Ficha Orcamentaria
<p> na aba ‘Ficha Orcamentaria’ (Somente aberta para os usuários registrados como Admin), cria-se uma nova ficha orcamentaria com os campos dotação, data, empenho, descrição, se foi debito ou credito e observações. Na pagina, pode-se salvar a ficha, e voltar para a pagina anterior. Quando se salva uma Ficha, é possível alterar e deletar ela. Não é possível salvar fichas sem dotação definida. No caso de alteração, é mostrado "cadastrado/alterado por" com o nome de quem alterou, a criação e ultima modificação da ficha orcamentaria. Além disso, da pra incluir a contra-partida da ficha orcamentaria. Você pode adicionar a conta, o tipo da conta, o grupo, receita e o débito/credito, e salva. nao é possível salvar em branco.</p>
<br>
  
## Relatorios
<p> na aba ‘Relatórios’ (Somente aberta para os usuários registrados como Admin), há as opções 'balancete', 'acompanhamento', 'saldo-contas', 'saldo-dotacoes', 'lancamentos' e 'ficha orcamentaria', todas acompanhadas de um botão de 'ok'. Em 'balancete', seleciona-se a data do balancete e ao clicar no botão ok o sistema salva automaticamente um pdf na maquina com o balancete referente. Isso acontece para todos as outras opções. Ao preencher os campos referentes a cada tipo de solicitação, e clicar em ok, o sistema retorna salvando um pdf com a solicitação feita pelo usuário. </p>
<br>

## Administração
<p> na aba ‘Administração’ (Somente aberta para os usuários registrados como Admin), há as opções 'lançamentos', que exibe uma lista de todos os lançamentos, 'fichas orçamentarias', que exibe uma lista de todas as fichas orçamentárias, 'movimentos', com uma lista de todos os movimentos, 'tipos de conta', com uma lista de todos os tipos de conta, 'contas', com uma lista de todas as contas, 'dotações orcamentarias', com uma lista de todas as dotações orçamentárias,'notas', com uma lista de todas as notas, e 'usuários', com uma lista de todos os usuários. todas acompanhadas de uma barra de pesquisa para facilitar a filtragem de um dado específico e de botões de visualização, edição e exclusão.</p>
<br>

## Minhas Contas
<p> na aba ‘Minhas Contas’, é possível selecionar a conta do usuário logado e checar os dados e movimentações da conta.</p>
<br>

### Models:

- <b>Conta</b>
- <b>ContaLancamento</b>
- <b>ContaUsuario</b>
- <b>DotOrcamentaria</b>
- <b>FicOrcamentaria</b>
- <b>Lancamento</b>
- <b>Movimento</b>
- <b>Nota</b>
- <b>TipoConta</b>
- <b>Unidade</b>
- <b>User</b>
<br>

## Conta
<p> Cria, atualiza, mostra e guarda as contas cadastradas. Fazendo relação com os usuarios e com os tipos de conta.</p>
<br>

## ContaLancamento
<p> gera o lancamento da conta</p>
<br>

## ContaUsuario
<p> Relaciona as conta com os usuarios do sistema.</p>
<br>

## DotOrcamentaria
<p> Relaciona o usuario com suas fichas orcamentarias e dotacoes orcamentarias</p>
<br>

## FicOrcamentaria
<p> Cria ou atualiza uma ficha orcamentaria com os campos presentes na area de preenchimento mencionada na aba</p>
<br>

## Lancamento
<p> Cria ou atualiza um lançamento com os campos presentes na area de preenchimento mencionada na aba</p>
<br>

## Movimento
<p> Acompanha os movimentos do usuário, seus lançamentos, fichas orçamentárias. Contem as opções movimentos ativos e em anos</p>
<br>

## Nota
<p> Guarda as descrições e observações (notas) das movimentações</p>
<br>

## TipoConta
<p> Guarda as informações do tipo da conta em questão</p>
<br>

## Unidade
<p> Guarda as informações da unidade (numero, nome, depto)</p>
<br>

## Users
<p> Contém os usuários do sistema e suas informações</p>
<br>

