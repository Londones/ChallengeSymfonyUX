# MatchNCollect

Projet de la challenge stack semestriel ESGI

### Membre de l'équipe :
- Alicia Saci (AliciaSaci)
- Awa Bah (Londones)
- Mai Thi Tran Diep (maithi-trandiep)
- Lucas Campistron (Redeltaz)

## Contribuer

Pour contribuer au projet vous devrez d'abord le cloner, ensuite switchez sur une branche.

Une fois cloné, vous pourrez lancer le projet :
```
docker-compose up --build -d
```

Vous pouvez ensuite jouer créer la base de donnée et jouer les migrations :
```
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migration:migrate
```

Et ensuite build le projet pour avoir le style et le javascript :
```
npm run watch
```
