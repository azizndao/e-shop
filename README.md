# E-Shop
## Instrction

1. Creer un utilisateur `adbou` et mot de passe `aziz` avec la commande
```sql
CREATE USER abdou IDENTIFIED BY 'aziz'
```
2. Creer une base de donnees avec comme nom `eshop`

```mysql
CREATE DATABASE eshop;
```
```mysql
GRANT ALL PRIVILEGES ON eshop.* TO abdou;
```


To run the project

```bash
php -S localhost:8000 -t public
```
