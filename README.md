# LaravelTestPrevisao
 Nesse projeto, você tem as seguintes funcionalidades:
 * Realizar a pesquisa da previsão do clima através do IP públic do solicitante
 * Gravar o resultado na base de dados
 * Envia notificação de email todos os dias às 07 horas com a previsão do clima com base no último IP público do usuário
 
# Excutar o projeto
Configure o banco de dados no arquivo e o email no arquivo .ENV
* php artisan migrate
* php artisan db:seed
* php artisan queue:work --tries=1 (Execute esse comando em outro terminal).
* php artisan serve

# Como acessar?
* acesse a seguinte url http://127.0.0.1:8000/api/v1/weather
