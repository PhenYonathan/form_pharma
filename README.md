# Form pharma
Formulaire d'envoi d'ordonnances.

# Installation
## Cloner le projet
```bash
$ git clone git@github.com:PhenYonathan/form_pharma.git
```
## Installer composer
```bash
$ composer install
```
## Installer les dépendances

```bash
$ composer require
```
Puis appuyer sur la touche entrer.

# Utilisation
## Mise en place
- Renommer le fichier exemple_env en .env
- Renseigner les informations demandées dans ce fichier
```env
apiKey = clé d'api pour le capcha
mailTo = mail vers qui vont être envoyés les ordonnances
mailCc = un mail de cc

### Fourni par le server ###
host =  
username =
pswd =
port =
```

---
# Versions
[1.0.1]
- Ajout d'un .env
- Installation simplifiée et plus propre

[1.0.0]
- Possibilité d'envoi de formulaire
- Vérification d'erreur
- Envoi de mail
